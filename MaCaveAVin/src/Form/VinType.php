<?php

namespace App\Form;

use App\Entity\Vin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region')
            ->add('couleur')
            ->add('appellation')
            ->add('chateau')
            ->add('annee')
            ->add('prix')
            ->add('note');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
