<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CaveAVinController
{
    public function __construct (Environment $twig)
    {
        $this->twig = $twig;
    } 
    public function index()
    {
        return new Response($this->twig->render("cave/vin.html.twig"));
    }
}