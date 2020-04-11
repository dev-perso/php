<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Entity\Cave;
use App\Form\VinType;
use Twig\Environment;
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

class CaveAVinController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    /*
     * @var VinRepository
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
        $this->user = $security->getUser();
    }

    /**
     * @Route("/", name="caveavin")
     * @return Response
     */
    public function index(): Response
    {
        $userWines          = [];
        $allColorsInCave    = [];
        $allRegionsInCave   = [];

        // Récupère les vins avec une quantité strictement supérieur à 0
        $wines = $this->cave->createQueryBuilder('c')
            ->where('c.id_user = :id_user')
            ->andWhere('c.quantite > :quantite')
            ->setParameter('id_user', $this->user->getIdUser())
            ->setParameter('quantite', 0)
            ->getQuery()
            ->getResult();
            
        foreach ($wines as $wine)
        {
            // Récupère les informations du vin
            $userWines[] = $this->getWineInformations($wine);
            
            // Récupère les couleurs des vins dans la cave
            if (!in_array($wine->getEntityVin()->getEntityCouleur()->getCouleur(), $allColorsInCave))
                $allColorsInCave[] = $wine->getEntityVin()->getEntityCouleur()->getCouleur();

            // Récupère les régions des vins dans la cave
            if (!in_array($wine->getEntityVin()->getEntityRegion()->getRegion(), $allRegionsInCave))
                $allRegionsInCave[] = $wine->getEntityVin()->getEntityRegion()->getRegion();
        }
        
        return $this->render("cave/test.html.twig", [
            'colors'    => $allColorsInCave,
            'regions'   => $allRegionsInCave,
            'userWines' => $userWines
        ]);
    }

    private function getWineInformations($wine)
    {
        $userWine = [];
        
        $userWine['id'] = $wine->getIdVin();
        $userWine['region'] = $wine->getEntityVin()->getEntityRegion()->getRegion();
        $userWine['couleur'] = $wine->getEntityVin()->getEntityCouleur()->getCouleur();
        $userWine['appellation'] = $wine->getEntityVin()->getAppellation();
        $userWine['annee'] = $wine->getEntityVin()->getAnnee();
        $userWine['quantite'] = $wine->getQuantite();
        $userWine['prix'] = $wine->getPrix();
        $userWine['note'] = $wine->getNote();

        return $userWine;
    }

    /**
     * @Route("/caveavin/bouteille/{id}", name="caveavin.bouteille.information")
     * @return Response
     */
    public function informationVin ($id): Response
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);
            return $this->render("cave/bouteille.html.twig",
            [
                'vin' => $vin
            ]);
        }
        else
            return $this->redirectToRoute("caveavin");
    }

     /**
     * @Route("/caveavin/archive", name="caveavin.archive")
     * @return Response
     */
    public function archiveVin (): Response
    {
        $qb = $this->vin->createQueryBuilder('v')
            ->where('v.archive = :archive')
            ->setParameter('archive', true)
            ->orderBy('v.annee', 'ASC');

        $vins = $qb->getQuery();

        return $this->render("cave/archive.html.twig", [
            'vins' => $vins->getResult()
        ]);
    }

    /**
     * @Route("/caveavin/filtre/{filtre}", name="caveavin.filtre")
     * @return Response
     */
    public function filtreVin ($filtre): Response
    {
        /*$regions    = $this->region->findAll();*/
        $idColors   = [];
        $idRegions  = [];
        $winesFiltered = [];
        $nbFilter   = 0;
        $allFilters = explode("--", $filtre);
        
        foreach ($allFilters as $oneFilter)
        {
            $couleur = $this->couleur->findBy(['couleur' => $oneFilter]);
            $region = $this->region->findBy(['region' => $oneFilter]);
            $wineFiltered = [];

            if ($couleur)
            {
                $wineFiltered = $this->vin->createQueryBuilder('v')
                                    ->leftJoin('v.users', 'User')
                                    ->where('User.id_user = :id_user')
                                    ->andWhere('v.couleur = :couleur')
                                    ->setParameter('id_user', $this->user->getIdUser())
                                    ->setParameter('couleur', $couleur)
                                    ->getQuery()
                                    ->getResult();
            }
            else if ($region)
            {
                $wineFiltered = $this->vin->createQueryBuilder('v')
                                    ->leftJoin('v.users', 'User')
                                    ->where('User.id_user = :id_user')
                                    ->andWhere('v.region = :region')
                                    ->setParameter('id_user', $this->user->getIdUser())
                                    ->setParameter('region', $region)
                                    ->getQuery()
                                    ->getResult();
            }
                
            $quantite = $this->cave->createQueryBuilder('c')
                                            ->where('c.id_vin = :id_vin')
                                            ->andWhere('c.id_user = :id_user')
                                            ->setParameter('id_vin', $wineFiltered[0]->getIdVin())
                                            ->setParameter('id_user', $this->user->getIdUser())
                                            ->select('c.quantite')
                                            ->getQuery()
                                            ->getArrayResult();

            $wineFiltered[0]->setQuantity($quantite[0]['quantite']);
            $winesFiltered = array_merge($winesFiltered, $wineFiltered);
            /*if (in_array_r($oneFilter, $colors))
            {
                
                $idColors[] = $this->couleur->createQueryBuilder('c')
                    ->where('c.couleur = :couleur')
                    ->setParameter('couleur', $oneFilter)
                    ->select('c.id_couleur')
                    ->getQuery()
                    ->getResult();
            }
            else if (in_array_r($oneFilter, $regions))
            {
                $idRegions[] = $this->region->createQueryBuilder('c')
                    ->where('c.region = :region')
                    ->setParameter('region', $oneFilter)
                    ->select('c.id_region')
                    ->getQuery()
                    ->getResult();
            }*/

            $nbFilter++;
        }
    
        //$wines      = $this->vin->findAll(['user' => $this->user->getIdUser(), 'couleur' => $couleur, 'region' => $region]);

            /*$qb->andWhere('v.quantite > :quantite')
                ->setParameter('quantite', 0)
                ->orderBy('v.annee', 'ASC')
                ->getQuery();

            $wines = $qb->getResult();
 
            foreach($idWines as $idWine)
            {
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

        // Count couleur
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
*/

        return $this->json(
        [
            'filters'   => $allFilters,
            'wines'     => $winesFiltered,
            'couleurs'  => $this->couleur->findAll(),
            'regions'   => $this->region->findAll(),
            'nbFilter'  => $nbFilter,
            'oneFilter' => $oneFilter
        ]);
    }
}