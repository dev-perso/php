<?php

namespace App\Controller;

use App\Repository\VinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CaveAVinController extends AbstractController
{
    /**
     * @Route("/", name="caveavin")
     * @return Response
     */
    public function index(VinRepository $vinRepository): Response
    {
        //$vin = $this->vinRepository->find(1);
        //dump($vin);
        return $this->render("cave/vin.html.twig");
    }

    public function ajoutVin ()
    {

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