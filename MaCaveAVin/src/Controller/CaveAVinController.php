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

    public function __construct(EntityManagerInterface $em, VinRepository $vin)
    {
        $this->em   = $em;
        $this->vin  = $vin;
    }

    /**
     * @Route("/", name="caveavin")
     * @return Response
     */
    public function index(): Response
    {
        //$vins = $this->vin->findAll();
        
        $qb = $this->vin->createQueryBuilder('v')
            ->where('v.quantite > :quantite')
            ->setParameter('quantite', 0)
            ->orderBy('v.annee', 'ASC');

        $vins = $qb->getQuery();
        
        return $this->render("cave/macave.html.twig", [
            'vins' => $vins->getResult()
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
     * @Route("/", name="connexion")
     * @return Response
     */
    public function tempConnexion() : Response
    {
        return $this->render("cave/macave.html.twig");
    }
}