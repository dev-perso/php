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

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appellation')
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
                'placeholder'   =>'Choose pet type',
                'empty_data'  => null
            ])
            ->add('id_region', EntityType::class,
            [
                'class'         => Region::class,
                'choice_label'  => 'region',
                'label'         => 'Région',
                'choice_value'  => 'id_region'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
