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
     * Nombre de bouteilles de vin Blanc
     */
    private $whiteWinesNb;

    /**
     * Nombre de bouteilles de vin Rosé
     */
    private $roseWinesNb;

    /**
     * Nombre de bouteilles de vin Rouge
     */
    private $redWinesNb;

    public function __construct(EntityManagerInterface $em, UserRepository $user, CaveRepository $cave)
    {
        $this->em   = $em;
        $this->user = $user;
        $this->cave = $cave;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $request->request;
        $user = new User();

        // Check si l'email existe en BDD
        if (empty($this->user->getEmailExist($form->get('email'))))
            $user->setEmail($form->get('email'));
        else
            // Message temporaire d'erreur
            $this->addFlash('error', 'Un compte existe déjà avec cette adresse email');

        // Hashage du password si celui-ci rempli les conditions de validations
        if ((strlen($form->get('password')) >= 8) && (preg_match('/[0-9]/', $form->get('password')) == 1) && (preg_match('/[A-Z]/', $form->get('password')) == 1) && (preg_match('/[a-z]/', $form->get('password'))))
        {
            $hash = $encoder->encodePassword($user, $form->get('password'));
            $user->setPassword($hash);

            // Message temporaire de validation
            $this->addFlash('success', 'Votre compte ' . $form->get('email') . ' a bien été créé');

            // Ajout du UserF dans la BDD
            $this->em->persist($user);
            $this->em->flush();
        }
        else
            // Message temporaire d'erreur
            $this->addFlash('error', 'Votre mot de passe doit faire 8 caractères minimum et contenir au moins une Majuscule, une minuscule et un chiffre');

        return $this->redirectToRoute("connexion");
    }

    /**
     * @Route("/register/email", name="register.email")
     * @return Response
     * Ajax pour vérifier que l'email n'est pas en base de données
     */
    public function checkEmail(): Response
    {
        $email = $_POST['email'];

        return $this->json(
        [
            'email' => $this->user->getEmailExist($email)
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
    public function connexion(Request $request) : Response
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
                $whiteWines = $whiteWines + $wine->getQuantite();
            elseif ($color == "Rosé")
                $roseWines = $roseWines + $wine->getQuantite();
            elseif ($color == "Rouge")
                $redWines = $redWines + $wine->getQuantite();
        }

        $this->whiteWinesNb = $whiteWines;
        $this->roseWinesNb  = $roseWines;
        $this->redWinesNb   = $redWines;
    }
}
