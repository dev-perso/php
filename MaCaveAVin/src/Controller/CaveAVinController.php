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
        $wines = $this->cave->getWinesFromUserCave($this->user->getIdUser());
            
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
        
        return $this->render("cave/macave.html.twig", [
            'colors'    => $allColorsInCave,
            'regions'   => $allRegionsInCave,
            'userWines' => $userWines
        ]);
    }

    // Get Wine Informations from object Vin
    private function getWineInformations($wine)
    {
        $userWine = [];
        
        $userWine['idVin'] = $wine->getIdVin();
        $userWine['entityRegion'] = $wine->getEntityVin()->getEntityRegion();
        $userWine['entityCouleur'] = $wine->getEntityVin()->getEntityCouleur();
        $userWine['appellation'] = $wine->getEntityVin()->getAppellation();
        $userWine['annee'] = $wine->getEntityVin()->getAnnee();
        $userWine['quantity'] = $wine->getQuantite();
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
    public function wineFilter ($filtre): Response
    {
        $winesFiltered = [];
        $winesToSend = [];
        $nbFilter   = 0;
        $allFilters = explode("--", $filtre);

        // Si on enlève le dernier filtre
        if ($allFilters[0] == "noFilter")
        {
            $userWines = [];

            // Récupère les vins avec une quantité strictement supérieur à 0
            $wines = $this->cave->getWinesFromUserCave($this->user->getIdUser());

            foreach ($wines as $wine)
                // Récupère les informations du vin
                $userWines[] = $this->getWineInformations($wine);
        
            return $this->json(
            [
                'wines'     => $userWines
            ]);
        }

        // Pour chaque filtre à prendre en compte
        foreach ($allFilters as $oneFilter)
        {
            // Tableau qui contiendra les vins filtrés
            $wineFiltered = [];

            // Cherche le filtre en cours dans la table couleur et region
            $couleur    = $this->couleur->findBy(['couleur' => $oneFilter]);
            $region     = $this->region->findBy(['region' => $oneFilter]);

            // Si le filtre est une couleur
            if ($couleur)
                // Récupère tous les vins de l'utilisateur avec le filtre de la couleur en cours
                $wineFiltered = $this->vin->getUserWineWithColorFilter($this->user->getIdUser(), $couleur);
            // Sinon si le filtre est une région
            else if ($region)
                // Récupère tous les vins de l'utilisateur avec le filtre de la region en cours
                $wineFiltered = $this->vin->getUserWineWithRegionFilter($this->user->getIdUser(), $region);

            $winesFiltered = array_merge($winesFiltered, $wineFiltered);

            $nbFilter++;
        }

        // Enlève tous les vins identiques
        $winesFiltered = array_unique($winesFiltered, SORT_REGULAR);

        // Pour chaque vin on récupère la quantité
        foreach ($winesFiltered as $wine)
        {
            $quantite = $this->cave->getWineQuantity($this->user->getIdUser(), $wine->getIdVin());

            if ($quantite[0]['quantite'] > 0)
            {
                $wine->setQuantity($quantite[0]['quantite']);

                // Réécris dans un tableau les vins filtrés
                $winesToSend[] = $wine;
            }
        }

        return $this->json(
        [
            'filters'   => $allFilters,
            'wines'     => $winesToSend
        ]);
    }
}