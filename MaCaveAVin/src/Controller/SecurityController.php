<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\CaveRepository;
use App\Repository\UserRepository;
use DirectoryIterator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * Nombre de bouteilles : Blanc
     */
    private $whiteWinesNb;

    /**
     * Nombre de bouteilles : Rosé
     */
    private $roseWinesNb;

    /**
     * Nombre de bouteilles : Rouge
     */
    private $redWinesNb;

    public function __construct(EntityManagerInterface $em, UserRepository $user, CaveRepository $cave)
    {
        $this->em   = $em;
        $this->user = $user;
        $this->cave = $cave;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute("caveavin");
        }

        return $this->render('security/gestionCompte/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/gestion/profile", name="manage.profile")
     */
    public function manageProfile(Request $request, Security $security) : Response
    {
        $user = $security->getUser();

        if ($user)
        {
            $user->setConfirmEmail($user->getEmail());
            $user->setConfirmPassword($user->getPassword());

            $form = $this->createForm(EditProfileType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $this->em->persist($user);
                $this->em->flush($user);

                return $this->redirectToRoute("caveavin");
            }

            // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
            $this->refreshBottlesNumber($this->cave->getWinesFromUserCave($user->getIdUser()));

            return $this->render("security/gestionCompte/profile.html.twig", [
                'form'          => $form->createView(),
                'whiteWines'    => $this->whiteWinesNb,
                'roseWines'     => $this->roseWinesNb,
                'redWines'      => $this->redWinesNb
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/bienvenue", name="bienvenue")
     * @return Response
     */
    public function bienvenue() : Response
    {
        return $this->render("cave/welcome.html.twig");
    }

    /**
     * @Route("/connexion", name="connexion")
     * @return Response
     */
    public function connexion() : Response
    {
        return $this->render("security/connexion.html.twig");
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     * @return Response
     */
    public function deconnexion() : Response
    {
        // Route de déconnexion
    }

    // Rafraichie la valeur du nombre de bouteille par couleur dans la cave de l'utilisateur
    private function refreshBottlesNumber($wines)
    {
        $whiteWines     = 0;
        $roseWines      = 0;
        $redWines       = 0;

        foreach ($wines as $wine)
        {
            // Récupére la couleur du vin
            $color = $wine->getEntityVin()->getEntityCouleur()->getCouleur();

            if ($color == "Blanc")
                $whiteWines++;
            elseif ($color == "Rosé")
                $roseWines++;
            elseif ($color == "Rouge")
                $redWines++;
        }

        $this->whiteWinesNb = $whiteWines;
        $this->roseWinesNb  = $roseWines;
        $this->redWinesNb   = $redWines;
    }
}
