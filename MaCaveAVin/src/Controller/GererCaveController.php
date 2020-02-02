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
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Vin
     */
    private $vin;

    public function __construct(EntityManagerInterface $em, VinRepository $vin)
    {
        $this->em   = $em;
        $this->vin  = $vin;
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
        
        return $this->render("cave/gestionVin/ajout.html.twig", [
            "vin"   => $vin,
            "form"  => $form->createView()
        ]);
    }

    /**
     * @Route("/caveavin/utiliser/{id}", name="caveavin.utiliser")
     * @return Response
     */
    public function utiliserVin($id)
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);

            // Quantité
            $quantite = $vin->getQuantite();
            $quantite--;
            $vin->setQuantite($quantite);

            // Archivage
            $archive = $vin->getArchive();
            if ($archive == false)
                $archive = true;
            $vin->setArchive($archive);

            // Update
            $this->em->persist($vin);
            $this->em->flush();

            return $this->redirectToRoute("caveavin");
        }

        return $this->redirectToRoute("caveavin");
    }
}