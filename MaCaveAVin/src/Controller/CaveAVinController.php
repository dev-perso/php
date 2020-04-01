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
     * @Route("/test", name="caveavin")
     * @return Response
     */
    public function index(Security $security): Response
    {
        // Récupère le user
        $user   = $security->getUser();
        $vinsUser = [];
        $userCave = [];

        // Récupère les vins avec une quantité strictement supérieur à 0
        $vins = $this->cave->createQueryBuilder('c')
            ->where('c.id_user = :id_user')
            ->setParameter('id_user', $user->getIdUser())
            ->getQuery()
            ->getResult();

        foreach ($vins as $vin)
        {
            $vinsUser['id'] = $vin->getIdVin();
            $vinsUser['region'] = $this->region->find($this->vin->find($vin->getIdVin())->getIdRegion())->getRegion();
            $vinsUser['couleur'] = $this->couleur->find($this->vin->find($vin->getIdVin())->getIdCouleur())->getCouleur();
            $vinsUser['appellation'] = $this->vin->find($vin->getIdVin())->getAppellation();
            $vinsUser['annee'] = "Ajouter dans la table vin";
            $vinsUser['quantite'] = $vin->getQuantite();
            $vinsUser['prix'] = $vin->getPrix();
            $vinsUser['note'] = $vin->getNote();

            $userCave[] = $vinsUser;
        }
            /*

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
*/
        return $this->render("cave/test.html.twig", [
            /*'vins'      => $vins->getResult(),*/
            'couleurs'  => $this->couleur->findAll(),
            'regions'   => $this->region->findAll(),
            'userVins'  => $userCave
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
        $vins       = null;
        $nbFilter   = 0;
        $allFiltres = explode("--", $filtre);
        
        $qb = $this->vin->createQueryBuilder('v');
        
        foreach ($allFiltres as $oneFiltre)
        {
            if (array_key_exists($oneFiltre, $this->couleur))
            {
                $qb->orWhere('v.couleur = :couleur' . $nbFilter)
                ->setParameter('couleur' . $nbFilter, $oneFiltre);
            }
            else if (array_key_exists($oneFiltre, $this->region))
            {
                $qb->orWhere('v.region = :region' . $nbFilter)
                    ->setParameter('region' . $nbFilter, $oneFiltre);
            }
            $nbFilter++;
        }

        $qb->andWhere('v.quantite > :quantite')
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

        return $this->json(
        [
            'vins'      => $vins->getResult(),
            'couleurs'  => $this->couleur,
            'regions'   => $this->region,
            'filtres'   => $allFiltres
        ]);
    }
}