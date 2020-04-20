<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Entity\Cave;
use App\Form\VinType;
use Twig\Environment;
use App\Entity\Domaine;
use App\Form\CommenterVinType;
use Doctrine\ORM\QueryBuilder;
use App\Repository\VinRepository;
use App\Repository\CaveRepository;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use App\Repository\CouleurRepository;
use App\Repository\DomaineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GererCaveController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Vin
     */
    private $vin;

    public function __construct(EntityManagerInterface $em, VinRepository $vin, CouleurRepository $couleur, PaysRepository $pays, RegionRepository $region, DomaineRepository $domaine, CaveRepository $cave, Security $security)
    {
        $this->em       = $em;
        $this->pays     = $pays;
        $this->couleur  = $couleur;
        $this->domaine  = $domaine;
        $this->region   = $region;
        $this->vin      = $vin;
        $this->cave     = $cave;

        // Récupère le user
        $this->user     = $security->getUser();
    }

    /**
     * @Route("/caveavin/gestion/ajouter", name="caveavin.gestion.ajout")
     * @return Response
     */
    public function addWine(Request $request, Security $security): Response
    {
        // Récupère toutes les couleurs & régions disponibles
        $couleurs   = $this->couleur->findAll();
        $regions    = $this->region->findAll();

        // On prépare les objets pour les push en BDD après l'envoi du formulaire
        $domaine    = new Domaine();
        $vin        = new Vin();
        $cave       = new Cave();

        // Crée le formulaire d'ajout du Vin
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->user)
        {
            // Récupère les informations du formulaire
            $domaineFromForm    = $_POST['domaine'];
            $quantiteFromForm   = $_POST['quantite'];
            $prixFromForm       = str_replace(',', '.', $_POST['prix']);

            // Cherche si le domaine existe
            $domaineFromDb = $this->domaine->searchDomain($domaineFromForm);

            if ($domaineFromDb)
                $vin->setIdDomaine($domaineFromDb[0]);
            else
            {
                // Crée le nouveau domaine
                $domaine->setDomaine($domaineFromForm);
                $this->em->persist($domaine);
                $this->em->flush();

                // Ajoute l'id du domaine au Vin
                $vin->setIdDomaine($domaine);
            }

            // Cherche si le Vin existe
            $vinFromDb = $this->vin->searchIfExist($vin->getAppellation(),
                                                    $vin->getIdCouleur(),
                                                    $vin->getIdDomaine(),
                                                    $vin->getIdRegion(),
                                                    $vin->getAnnee());
            
            if (!empty($vinFromDb))
                // Récupére le Vin déjà existant
                $cave->setIdVin($vinFromDb[0]);
            else
            {
                // Crée le Vin
                $this->em->persist($vin);
                $this->em->flush();

                $cave->setIdVin($vin);
            }

            // Cherche si l'utilisateur a déjà ce vin dans sa cave
            $caveFromDb = $this->cave->doesWineIsInUserCave($this->user->getIdUser(), $cave->getIdVin());

            if (!empty($caveFromDb))
            {   
                // Incrémente la quantité du vin déjà dans la cave
                $quantiteFromForm += $caveFromDb[0]->getQuantite();
                $caveFromDb[0]->setQuantite($quantiteFromForm);

                if ($prixFromForm != null)
                    $caveFromDb[0]->setPrix((float)$prixFromForm);

                $this->em->persist($caveFromDb[0]);
                $this->em->flush();
            }
            else
            {
                // Ajoute le vin à la cave du user
                $cave->setQuantite($quantiteFromForm);
                $cave->setPrix($prixFromForm);
                $cave->setIdUser($this->user);

                $this->em->persist($cave);
                $this->em->flush();
            }
            
            return $this->redirectToRoute("caveavin");
        }

        return $this->render("cave/gestionVin/ajouter.html.twig", 
        [
            "couleurs"  => $couleurs,
            "regions"   => $regions,
            "vin"       => $vin,
            "form"      => $form->createView()
        ]);
    }

    /**
     * @Route("/caveavin/gestion/modifier/{id}", name="caveavin.gestion.modifier")
     * @return Response
     */
    public function editWine(Request $request, $id)
    {
        if ($id != null)
        {
            $wine = $this->vin->find($id);

            $form = $this->createForm(VinType::class, $wine);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // Update
                $this->em->persist($wine);
                $this->em->flush();
    
                return $this->redirectToRoute("caveavin");
            }

            return $this->render("cave/gestionVin/modifier.html.twig", [
                "vin"   => $wine,
                "form"  => $form->createView()
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/caveavin/gestion/utiliser/{id}", name="caveavin.gestion.utiliser")
     * @return Response
     */
    public function useWine(Request $request, $id)
    {
        if ($id != null)
        {
            $wine = $this->vin->find($id);
            $userWine = $this->cave->findBy(["id_user" => $this->user->getIdUser(), "id_vin" => $id]);

            $form = $this->createForm(CommenterVinType::class, $userWine);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // Quantité
                $quantite = $userWine[0]->getQuantite();
                $quantite--;
                $userWine[0]->setQuantite($quantite);

                // Archivage
                $archive = $userWine[0]->getArchive();
                if ($archive == false)
                    $archive = true;
                $userWine[0]->setArchive($archive);

                // Update
                $this->em->persist($userWine[0]);
                $this->em->flush();
    
                return $this->redirectToRoute("caveavin");
            }

            return $this->render("cave/gestionVin/commenter.html.twig", [
                "vin"   => $wine,
                "userWine" => $userWine,
                "form"  => $form->createView()
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/caveavin/gestion/remettre/{id}", name="caveavin.gestion.remettre")
     * @return Response
     */
    public function remettreVin(Request $request, $id)
    {
        $vin = $this->vin->find($id);

        // Ajout du vin dans la cave
        $quantite = $vin->getQuantite();
        $quantite++;
        $vin->setQuantite($quantite);

        // Update
        $this->em->persist($vin);
        $this->em->flush();

        $qb = $this->vin->createQueryBuilder('v')
            ->where('v.quantite > :quantite')
            ->setParameter('quantite', 0)
            ->orderBy('v.annee', 'ASC');

        $vins = $qb->getQuery();

        // Count
        foreach ($this->couleur as $couleur => $nombre)
        {
            $this->couleur[$couleur] = $this->vin->createQueryBuilder('v')
                ->select('count(v.id)')
                ->where('v.couleur = :couleur')
                ->andWhere('v.quantite > :quantite')
                ->setParameter('couleur', $couleur)
                ->setParameter('quantite', 0)
                ->getQuery()
                ->getSingleScalarResult();
        }

        // Count region
        foreach ($this->region as $region => $nombre)
        {
            $this->region[$region] = $this->vin->createQueryBuilder('v')
                ->select('count(v.id)')
                ->where('v.region = :region')
                ->andWhere('v.quantite > :quantite')
                ->setParameter('region', $region)
                ->setParameter('quantite', 0)
                ->getQuery()
                ->getSingleScalarResult();
        }
        
        return $this->render("cave/macave.html.twig", [
            'vins'      => $vins->getResult(),
            'couleurs'  => $this->couleur,
            'regions'   => $this->region
        ]);
    }
}