<?php

namespace App\Form;

use App\Entity\Cave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite')
            ->add('prix')
            ->add('description')
            ->add('note')
            ->add('imageFile', FileType::class,
            [
                'required'          => false,
                'label'             => 'Image du vin'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cave::class,
        ]);
    }
}
