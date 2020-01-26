<?php

namespace App\Controller;

use App\Repository\VinRepository;
use App\Entity\Vin;
use App\Form\VinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class GererCaveController extends AbstractController
{
    /*
     * @var ObjectManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/caveavin/gestion/ajout", name="caveavin.gestion.ajout")
     * @return Response
     */
    public function ajoutVin(Request $request)
    {
        $vin = new Vin();

        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($vin);
            $this->em->flush();

            return $this->redirectToRoute("caveavin");
        }
        dump($form);
        return $this->render("cave/gestionVin/ajout.html.twig", [
            "vin"   => $vin,
            "form"  => $form->createView()
        ]);
    }
}