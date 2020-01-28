<?php

namespace App\Controller;

use App\Repository\VinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CaveAVinController extends AbstractController
{
    /*
     * @var VinRepository
     */
    private $vin;

    public function __construct(VinRepository $vin)
    {
        $this->vin = $vin;
    }

    /**
     * @Route("/", name="caveavin")
     * @return Response
     */
    public function index(): Response
    {
        $vins = $this->vin->findAll();

        return $this->render("cave/vin.html.twig", [
            'vins' => $vins
        ]);
    }

    /**
     * @Route("/caveavin/bouteille/{id}", name="caveavin.bouteille.information")
     * @return Response
     */
    public function informationVin ($id): Response
    {
        $vin = $this->vin->find($id);
        return $this->render("cave/bouteille.html.twig",
        [
            'vin' => $vin
        ]);
    }

    /**
     * @Route("/", name="connexion")
     * @return Response
     */
    public function tempConnexion() : Response
    {
        return $this->render("cave/vin.html.twig");
    }
}