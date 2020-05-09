<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
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
            ->add('imageFile', FileType::class,
            [
                'label'     => 'Image du profile',
                'required'  => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
