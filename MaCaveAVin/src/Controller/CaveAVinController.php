<?php

namespace App\Controller;

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
    public function index(): Response
    {
        return $this->render("cave/vin.html.twig");
    }
}