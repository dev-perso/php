<?php

namespace App\Controller;

use App\Repository\VinRepository;
use App\Entity\Vin;
use App\Form\VinType;
use App\Form\CommenterVinType;
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
     * @Route("/caveavin/gestion/ajouter", name="caveavin.gestion.ajout")
     * @return Response
     */
    public function ajouterVin(Request $request)
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
        
        return $this->render("cave/gestionVin/ajouter.html.twig", [
            "vin"   => $vin,
            "form"  => $form->createView()
        ]);
    }

    /**
     * @Route("/caveavin/gestion/modifier/{id}", name="caveavin.gestion.modifier")
     * @return Response
     */
    public function modifierVin(Request $request, $id)
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);

            $form = $this->createForm(VinType::class, $vin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // Update
                $this->em->persist($vin);
                $this->em->flush();
    
                return $this->redirectToRoute("caveavin");
            }

            return $this->render("cave/gestionVin/modifier.html.twig", [
                "vin"   => $vin,
                "form"  => $form->createView()
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/caveavin/gestion/utiliser/{id}", name="caveavin.gestion.utiliser")
     * @return Response
     */
    public function utiliserVin(Request $request, $id)
    {
        if ($id != null)
        {
            $vin = $this->vin->find($id);

            $form = $this->createForm(CommenterVinType::class, $vin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
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

            return $this->render("cave/gestionVin/commenter.html.twig", [
                "vin"   => $vin,
                "form"  => $form->createView()
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/caveavin/gestion/remettre/{id}", name="caveavin.gestion.remettre")
     * @return Response
     */
    public function remettreVin(Request $request, $id)
    {
        $vin = $this->vin->find($id);

        // Ajout du vin dans la cave
        $quantite = $vin->getQuantite();
        $quantite++;
        $vin->setQuantite($quantite);

        // Update
        $this->em->persist($vin);
        $this->em->flush();

        $qb = $this->vin->createQueryBuilder('v')
            ->where('v.quantite > :quantite')
            ->setParameter('quantite', 0)
            ->orderBy('v.annee', 'ASC');

        $vins = $qb->getQuery();
        
        return $this->render("cave/macave.html.twig", [
            'vins' => $vins->getResult()
        ]);
    }
}