<?php

namespace App\Controller;

use App\Repository\UserRepository;
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

    public function __construct(EntityManagerInterface $em, UserRepository $user)
    {
        $this->em   = $em;
        $this->user  = $user;
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
     * @Route("/gestion/profil", name="gestion.profil")
     */
    public function gestionProfil(Security $security) : Response
    {
        $user = $security->getUser();

        if ($user)
        {
            return $this->render("security/gestionCompte/profil.html.twig", [
                "user"  => $user
            ]);
        }

        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/gestion/profil/modifier", name="gestion.profil.modifier")
     */
    public function editProfil(Security $security) : Response
    {
        $user = $security->getUser();

        if ($user)
        {
            $user->setNom($_POST['nom']);
            $this->em->persist($user);
            $this->em->flush();
        }
        
        return $this->redirectToRoute("caveavin");
    }

    /**
     * @Route("/bienvenue", name="bienvenue")
     * @return Response
     */
    public function bienvenue() : Response
    {
        return $this->render("cave/bienvenue.html.twig");
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
}
