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

        
        
        return $this->render("cave/macave.html.twig", [
            'vins' => $vins->getResult(),
            'couleur' => $this->couleur
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
     * @Route("/", name="connexion")
     * @return Response
     */
    public function tempConnexion() : Response
    {
        return $this->render("cave/macave.html.twig");
    }
}