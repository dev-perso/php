<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;

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
     * @Route("/inscription", name="security")
     */
    public function register()
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
