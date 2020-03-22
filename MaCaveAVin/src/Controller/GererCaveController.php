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

    public function __construct(EntityManagerInterface $em, VinRepository $vin, CouleurRepository $couleur, PaysRepository $pays, RegionRepository $region, DomaineRepository $domaine, CaveRepository $cave)
    {
        $this->em       = $em;
        $this->pays     = $pays;
        $this->couleur  = $couleur;
        $this->domaine  = $domaine;
        $this->region   = $region;
        $this->vin      = $vin;
        $this->cave     = $cave;
    }

    /**
     * @Route("/caveavin/gestion/ajouter", name="caveavin.gestion.ajout")
     * @return Response
     */
    public function ajouterVin(Request $request, Security $security): Response
    {
        // Récupère toutes les couleurs & régions disponibles
        $couleurs   = $this->couleur->findAll();
        $regions    = $this->region->findAll();

        // On prépare les objets pour les push en BDD après l'envoi du formulaire
        $domaine    = new Domaine();
        $vin        = new Vin();
        $cave       = new Cave();

        // Récupère le user
        $user   = $security->getUser();

        // Crée le formulaire d'ajout du Vin
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user)
        {
            // Récupère les informations du formulaire
            $domaineFromForm    = $_POST['domaine'];
            $quantiteFromForm   = $_POST['quantite'];
            $data               = $form->getData();

            // Cherche si le domaine existe
            $domaineFromDb = $this->domaine->createQueryBuilder('d')
                ->where('d.domaine = :domaine')
                ->setParameter('domaine', $domaineFromForm)
                ->getQuery()
                ->getResult();

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
            $vinFromDb = $this->vin->createQueryBuilder('v')
                ->where('v.appellation = :appellation')
                ->andWhere('v.id_couleur = :id_couleur')
                ->andWhere('v.id_domaine = :id_domaine')
                ->andWhere('v.id_region = :id_region')
                ->setParameter('appellation', $vin->getAppellation())
                ->setParameter('id_couleur', $vin->getIdCouleur())
                ->setParameter('id_domaine', $vin->getIdDomaine())
                ->setParameter('id_region', $vin->getIdRegion())
                ->getQuery()
                ->getResult();
            
            if (!empty($vinFromDb))
            {
                // Récupére le Vin déjà existant
                $cave->setIdVin($vinFromDb[0]);
            }
            else
            {
                // Crée le Vin
                $this->em->persist($vin);
                $this->em->flush();

                $cave->setIdVin($vin);
            }

            // Cherche si l'utilisateur a déjà ce vin dans sa cave
            $caveFromDb = $this->cave->createQueryBuilder('c')
                ->where('c.id_user = :id_user')
                ->andWhere('c.id_vin = :id_vin')
                ->setParameter('id_user', $user->getIdUser())
                ->setParameter('id_vin', $cave->getIdVin())
                ->getQuery()
                ->getResult();

            if (!empty($caveFromDb))
            {   
                // Incrémente la quantité du vin déjà dans la cave
                $quantiteFromForm += $caveFromDb[0]->getQuantite();
                $caveFromDb[0]->setQuantite($quantiteFromForm);
                
                $this->em->persist($caveFromDb[0]);
                $this->em->flush();
            }
            else
            {
                // Ajoute le vin à la cave du user
                $cave->setQuantite($quantiteFromForm);
                $cave->setIdUser($user);

                $this->em->persist($cave);
                $this->em->flush();
            }
            
            return $this->render("cave/gestionVin/ajouter.html.twig", 
            [
                "couleurs"  => $couleurs,
                "regions"   => $regions,
                "vin"       => $vin,
                "form"      => $form->createView()
            ]);
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
    public function modifierVin(Request $request, $id)
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);

            $form = $this->createForm(VinType::class, $vin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // Update
                $this->em->persist($vin);
                $this->em->flush();
    
                return $this->redirectToRoute("caveavin");
            }

            return $this->render("cave/gestionVin/modifier.html.twig", [
                "vin"   => $vin,
                "form"  => $form->createView()
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/caveavin/gestion/utiliser/{id}", name="caveavin.gestion.utiliser")
     * @return Response
     */
    public function utiliserVin(Request $request, $id)
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);

            $form = $this->createForm(CommenterVinType::class, $vin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // Quantité
                $quantite = $vin->getQuantite();
                $quantite--;
                $vin->setQuantite($quantite);

                // Archivage
                $archive = $vin->getArchive();
                if ($archive == false)
                    $archive = true;
                $vin->setArchive($archive);

                // Update
                $this->em->persist($vin);
                $this->em->flush();
    
                return $this->redirectToRoute("caveavin");
            }

            return $this->render("cave/gestionVin/commenter.html.twig", [
                "vin"   => $vin,
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