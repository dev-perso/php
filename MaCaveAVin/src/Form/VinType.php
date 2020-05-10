<?php

namespace App\Form;

use App\Entity\Vin;
use App\Entity\Region;
use App\Entity\Couleur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
               'placeholder'    => 'Choisir l\'année'
            ])
            ->add('id_couleur', EntityType::class,
            [
                'class'         => Couleur::class,
                'choice_label'  => 'couleur',
                'label'         => 'Couleur',
                'choice_value'  => 'id_couleur',
                'placeholder'   => 'Choisir la couleur',
                'required'      => true
            ])
            ->add('id_region', EntityType::class,
            [
                'class'         => Region::class,
                'choice_label'  => 'region',
                'label'         => 'Région',
                'placeholder'   => 'Choisir la région',
                'choice_value'  => 'id_region'
            ]);


        $builder->add('cave', CollectionType::class,
        [
            'entry_type' => WineImgType::class,
            'entry_options' => ['label' => false],
        ]);
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
