<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('nom', null,
            [
                'label'     => false,
                'required'  => true
            ])
            ->add('prenom', null,
            [
                'label'     => false,
                'required'  => true
            ])*/
            ->add('email', null,
            [
                'label'     => false,
                'required'  => true
            ])
            /*->add('confirm_email', null,
            [
                'label'     => false,
                'required'  => true
            ])*/
            ->add('password', PasswordType::class,
            [
                'label'     => false,
                'required'  => true
            ]);
            /*->add('confirm_password', PasswordType::class,
            [
                'label'     => false,
                'required'  => true
            ]);*/
            /*->add('imageFile', FileType::class,
            [
                'label'     => 'Image du profile',
                'required'  => false
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
