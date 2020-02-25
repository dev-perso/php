<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null,
            [
                'label'     => 'Nom',
                'required'  => true
            ])
            ->add('prenom', null,
            [
                'label'     => 'Prénom',
                'required'  => true
            ])
            ->add('username', null,
            [
                'label'     => 'Utilisateur',
                'required'  => true
            ])
            ->add('password', PasswordType::class,
            [
                'label'     => 'Mot de passe',
                'required'  => true
            ])
            ->add('confirm_password', PasswordType::class,
            [
                'label'     => 'Confirmation du mot de passe',
                'required'  => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
