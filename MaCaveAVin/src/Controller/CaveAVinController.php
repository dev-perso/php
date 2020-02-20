<?php

namespace App\Controller;

use App\Repository\VinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

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

    /*
     * @var Array
     */
    private $couleur;

    /*
     * @var Array
     */
    private $region;

    public function __construct(EntityManagerInterface $em, VinRepository $vin)
    {
        $this->em   = $em;
        $this->vin  = $vin;
        $this->couleur = array
        (
            "blanc" => 0,
            "rouge" => 0,
            "rose"  => 0
        );
        $this->region = array
        (
            "alsace" => 0,
            "bordeaux" => 0,
            "bourgogne" => 0,
            "cote_rhone" => 0,
            "corse" => 0,
            "languedoc" => 0,
            "loire" => 0,
            "etranger" => 0
        );
    }

    /**
     * @Route("/", name="caveavin")
     * @return Response
     */
    public function index(): Response
    {
        // Récupère les vins avec une quantité strictement supérieur à 0
        $qb = $this->vin->createQueryBuilder('v')
            ->where('v.quantite > :quantite')
            ->setParameter('quantite', 0)
            ->orderBy('v.annee', 'ASC');

        $vins = $qb->getQuery();

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
     * @Route("/caveavin/filtre/{filtre}", name="caveavin.filtre.couleur")
     * @return Response
     */
    public function filtreVin ($filtre): Response
    {
        $vins = null;

        if (array_key_exists($filtre, $this->couleur))
        {
            $qb = $this->vin->createQueryBuilder('v')
                ->where('v.couleur = :couleur')
                ->andWhere('v.quantite > :quantite')
                ->setParameter('couleur', $filtre)
                ->setParameter('quantite', 0)
                ->orderBy('v.annee', 'ASC');

            $vins = $qb->getQuery();

            // Count region
            foreach ($this->region as $region => $nombre)
            {
                $this->region[$region] = $this->vin->createQueryBuilder('v')
                    ->select('count(v.id)')
                    ->where('v.region = :region')
                    ->andWhere('v.quantite > :quantite')
                    ->andWhere('v.couleur = :couleur')
                    ->setParameter('region', $region)
                    ->setParameter('quantite', 0)
                    ->setParameter('couleur', $filtre)
                    ->getQuery()
                    ->getSingleScalarResult();
            }
        }
        else if (array_key_exists($filtre, $this->region))
        {
            $qb = $this->vin->createQueryBuilder('v')
                ->where('v.region = :region')
                ->andWhere('v.quantite > :quantite')
                ->setParameter('region', $filtre)
                ->setParameter('quantite', 0)
                ->orderBy('v.annee', 'ASC');

            $vins = $qb->getQuery();

            // Count couleur
            foreach ($this->couleur as $couleur => $nombre)
            {
                $this->couleur[$couleur] = $this->vin->createQueryBuilder('v')
                    ->select('count(v.id)')
                    ->where('v.couleur = :couleur')
                    ->andWhere('v.quantite > :quantite')
                    ->andWhere('v.region = :region')
                    ->setParameter('couleur', $couleur)
                    ->setParameter('quantite', 0)
                    ->setParameter('region', $filtre)
                    ->getQuery()
                    ->getSingleScalarResult();
            }
        }

        return $this->json(
        [
            'vins'      => $vins->getResult(),
            'couleurs'  => $this->couleur,
            'regions'   => $this->region,
            'filtres'   => $filtre
        ]);
    }

    /**
     * @Route("/", name="connexion")
     * @return Response
     */
    public function tempConnexion() : Response
    {
        return $this->render("cave/macave.html.twig");
    }
}