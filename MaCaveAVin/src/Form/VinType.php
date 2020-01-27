<?php

namespace App\Form;

use App\Entity\Vin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region', ChoiceType::class,
            [
                'placeholder' => 'Choisir une région',
                'choices' => 
                [
                    'Alsace'                => 'alsace',
                    'Bordeaux'              => 'bordeaux',
                    'Bourgogne'             => 'bourgogne',
                    'Côte du Rhône'         => 'cote_rhone',
                    'Corse'                 => 'corse',
                    'Languedoc Roussillon'  => 'languedoc',
                    'Loire'                 => 'loire',
                    'Etranger'              => 'etranger'
                ],
                'label' => 'Région'
            ])
            ->add('couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => 
                [
                    'Blanc' => 'blanc',
                    'Rosé'  => 'rose',
                    'Rouge' => 'rouge'
                ],
                'required' => true,
                'label' => 'Couleur'
            ])
            ->add('appellation', null, [
                'label' => 'Appellation'
            ])
            ->add('chateau', null, [
                'label' => 'Château'
            ])
            ->add('annee', null, [
                'label' => 'Année'
            ])
            ->add('prix', null, [
                'label' => 'Prix'
            ])
            ->add('note', null, [
                'label' => 'Note'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
