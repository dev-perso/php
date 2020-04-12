<?php

namespace App\Form;

use App\Entity\Vin;
use App\Entity\Region;
use App\Entity\Couleur;
use App\Entity\Domaine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appellation')
            ->add('annee', ChoiceType::class,
            [
               'choices'        => $this->buildYearChoices(),
               'label'          => 'Année',
               'required'       => true,
               'placeholder'    => 'Select year'
            ])
            ->add('image', FileType::class, 
            [
                'required'      => false,
                'label'         => 'Image'
            ])
            ->add('id_couleur', EntityType::class,
            [
                'class'         => Couleur::class,
                'choice_label'  => 'couleur',
                'label'         => 'Couleur',
                'choice_value'  => 'id_couleur',
                'placeholder'   => 'Select color',
                'empty_data'  => null
            ])
            ->add('id_region', EntityType::class,
            [
                'class'         => Region::class,
                'choice_label'  => 'region',
                'label'         => 'Région',
                'placeholder'   => 'Select region',
                'choice_value'  => 'id_region'
            ])
        ;
    }

    public function buildYearChoices()
    {
        $yearFrom = 1900;
        $yearNow = date('Y');
        return array_combine(array_reverse(range($yearFrom, $yearNow)), array_reverse(range($yearFrom, $yearNow)));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
