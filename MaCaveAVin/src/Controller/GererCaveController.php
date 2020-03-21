<?php

namespace App\Controller;

use App\Repository\VinRepository;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use App\Repository\CouleurRepository;
use App\Repository\DomaineRepository;
use App\Entity\Vin;
use App\Entity\Cave;
use App\Form\VinType;
use App\Form\CommenterVinType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

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

    public function __construct(EntityManagerInterface $em, VinRepository $vin, CouleurRepository $couleur, PaysRepository $pays, RegionRepository $region, DomaineRepository $domaine)
    {
        $this->em       = $em;
        $this->pays     = $pays;
        $this->couleur  = $couleur;
        $this->domaine  = $domaine;
        $this->region   = $region;
        $this->vin      = $vin;
    }

    /**
     * @Route("/caveavin/gestion/ajouter", name="caveavin.gestion.ajout")
     * @return Response
     */
    public function ajouterVin(Request $request, Security $security): Response
    {
        $couleurs   = $this->couleur->findAll();
        $regions    = $this->region->findAll();

        $vin    = new Vin();
        $cave   = new Cave();

        // Récupère le user
        $user   = $security->getUser();

        // Cré le formulaire d'ajout du Vin
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user)
        {
            // Récupère les informations du formulaire
            $domaineFromForm = $_POST['domaine'];
            $data = $form->getData();
            
            $domaine = $this->domaine->createQueryBuilder('d')
                ->where('d.domaine = :domaine')
                ->setParameter('domaine', $domaineFromForm)
                ->getQuery()
                ->getResult();

            
            if ($domaine)
            {
                $vin->setIdDomaine($domaine[0]);
            }
            
            dump($vin);
            dump($data->getAppellation());
            /*
            
            $this->couleur[$couleur] = $this->domaine->createQueryBuilder('v')
                ->select('count(v.id)')
                ->where('v.couleur = :couleur');


            $this->em->persist($vin);
            $this->em->flush();

            $cave->setQuantite(1);
            $cave->setIdUser($user);
            $cave->setIdVin($vin);
            
            $this->em->persist($cave);
            $this->em->flush();
*/
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