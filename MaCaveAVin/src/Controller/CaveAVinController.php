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

    /**
     * @var VinRepository
     */
    private $vin;

    /**
     * Nombre de bouteilles : Blanc
     */
    private $whiteWinesNb;

    /**
     * Nombre de bouteilles : Rosé
     */
    private $roseWinesNb;

    /**
     * Nombre de bouteilles : Rouge
     */
    private $redWinesNb;

    /**
     * CaveAVinController constructor.
     * @param EntityManagerInterface $em
     * @param VinRepository $vin
     * @param CouleurRepository $couleur
     * @param PaysRepository $pays
     * @param RegionRepository $region
     * @param DomaineRepository $domaine
     * @param CaveRepository $cave
     * @param Security $security
     */
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
     * @Route("/", name="main")
     */
    public function main(): Response
    {
        // Récupére les vins avec une quantité strictement supérieur à 0
        $wines = $this->cave->getWinesFromUserCave($this->user->getIdUser());

        // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
        $this->refreshBottlesNumber($wines);

        return $this->render("main.html.twig", [
            'whiteWines'    => $this->whiteWinesNb,
            'roseWines'     => $this->roseWinesNb,
            'redWines'      => $this->redWinesNb
        ]);
    }

    /**
     * @Route("/caveavin", name="caveavin")
     * @return Response
     */
    public function cave(): Response
    {
        $userWines          = [];
        $allColorsInCave    = [];
        $allRegionsInCave   = [];

        // Récupére les vins avec une quantité strictement supérieur à 0
        $wines = $this->cave->getWinesFromUserCave($this->user->getIdUser());

        // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
        $this->refreshBottlesNumber($wines);

        foreach ($wines as $wine)
        {
            // Récupére la couleur et la région du vin
            $color  = $wine->getEntityVin()->getEntityCouleur()->getCouleur();
            $region = $wine->getEntityVin()->getEntityRegion()->getRegion();

            // Récupére les informations du vin
            $userWines[] = $this->getWineInformations($wine);
            
            // Récupére les couleurs des vins dans la cave
            if (!in_array($color, $allColorsInCave))
                $allColorsInCave[] = $color;

            // Récupére les régions des vins dans la cave
            if (!in_array($region, $allRegionsInCave))
                $allRegionsInCave[] = $region;
        }

        // Tri les vins par Année
        usort($userWines, array($this, "compareDate"));

        return $this->render("cave/cave.html.twig", [
            'colors'        => $allColorsInCave,
            'regions'       => $allRegionsInCave,
            'userWines'     => $userWines,
            'whiteWines'    => $this->whiteWinesNb,
            'roseWines'     => $this->roseWinesNb,
            'redWines'      => $this->redWinesNb
        ]);
    }

    // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
    private function refreshBottlesNumber($wines)
    {
        $whiteWines     = 0;
        $roseWines      = 0;
        $redWines       = 0;

        foreach ($wines as $wine)
        {
            // Récupére la couleur du vin
            $color = $wine->getEntityVin()->getEntityCouleur()->getCouleur();

            if ($color == "Blanc")
                $whiteWines++;
            elseif ($color == "Rosé")
                $roseWines++;
            elseif ($color == "Rouge")
                $redWines++;
        }

        $this->whiteWinesNb = $whiteWines;
        $this->roseWinesNb  = $roseWines;
        $this->redWinesNb   = $redWines;
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

    // Compare la date et range dans l'ordre ASC
    private function compareDate($firstWine, $secondWine)
    {
        if (is_array($firstWine))
        {
            if ($firstWine["annee"] == $secondWine["annee"])
                return 0;

            return ($firstWine["annee"] < $secondWine["annee"]) ? -1 : 1;
        }
        else if ($firstWine->getAnnee() !== null)
        {
            if ($firstWine->getAnnee() == $secondWine->getAnnee())
                return 0;

            return ($firstWine->getAnnee() < $secondWine->getAnnee()) ? -1 : 1;
        }

        return 0;
    }

    /**
     * @Route("/caveavin/bouteille/{id}", name="caveavin.bouteille.information")
     * @return Response
     */
    public function wineInformations ($id): Response
    {
        if ($id != null)
        {
            $userWine = $this->cave->findBy(["id_user" => $this->user->getIdUser(), "id_vin" => $id]);

            // Si le vin n'existe pas ou n'appartient pas à l'utilisateur
            if (!$userWine[0]) return $this->redirectToRoute("caveavin");

            // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
            $this->refreshBottlesNumber($this->cave->getWinesFromUserCave($this->user->getIdUser()));

            // Peut être pas nécessaire
            $wine = $this->vin->findBy(["id_vin" => $id]);

            return $this->render("cave/bottle.html.twig",
            [
                'userWine'      => $userWine[0],
                'wine'          => $wine[0], // Peut être pas nécessaire
                'whiteWines'    => $this->whiteWinesNb,
                'roseWines'     => $this->roseWinesNb,
                'redWines'      => $this->redWinesNb
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
        if ($this->user->getIdUser())
        {
            $wines = $this->cave->getArchiveFromUserCave($this->user->getIdUser());

            // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
            $this->refreshBottlesNumber($this->cave->getWinesFromUserCave($this->user->getIdUser()));

            return $this->render("cave/archive.html.twig", [
                'archives'      => $wines,
                'whiteWines'    => $this->whiteWinesNb,
                'roseWines'     => $this->roseWinesNb,
                'redWines'      => $this->redWinesNb
            ]);
        }
        else
            return $this->redirectToRoute("caveavin");
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

            // Tri les vins par Année
            usort($userWines, array($this, "compareDate"));

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

        // Tri les vins par Année
        usort($winesToSend, array($this, "compareDate"));

        return $this->json(
        [
            'filters'   => $allFilters,
            'wines'     => $winesToSend
        ]);
    }
}