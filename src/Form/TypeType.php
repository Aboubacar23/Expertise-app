<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Machine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')   
            ->add('machine', EntityType::class,[
                'class' => Machine::class,
                'placeholder' => 'Choisir la machine'
            ]) 
            ->add('type_machine', ChoiceType::class, [
                'choices' => [
                    'Moteur' => 'Moteur',
                    'Alternateur' => 'Alternateur',
                    'Génératrice' => 'Génératrice'
                ],
                'placeholder' => 'Choisir le type de machine'
            ])
            ->add('puissance')
            ->add('montage')
            ->add('fabricant')
            ->add('presence_balais')
            ->add('vitesse') 
            ->add('masse')
            ->add('type_palier', ChoiceType::class, [
                'choices' => [
                    'Roulements' => 'Roulements',
                    'Coussinets' => 'Coussinets'
                ],
                'placeholder' => 'Choisir un type de palier'
            ])
            ->add('presence_balais_masse')
            ->add('stator_tension', NumberType::class, [
                'label' => 'Tension (V)'
            ])
            ->add('stator_tension2',NumberType::class, [
                'label' => 'Tension (V)'
            ])
            ->add('stator_frequence',NumberType::class, [
                'label' => 'Fréquence (Hz)'
            ])
            ->add('stator_courant',NumberType::class, [
                'label' => 'Courant (A)'
            ])
            ->add('stator_couplage', ChoiceType::class, [
                'choices' => [
                    'Etoile' => 'Etoile',
                    'Triangle' => 'Triangle'
                ],
                'placeholder' => 'Choisir couplage'
            ])
            ->add('date_arrivee', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('rotor_tension',NumberType::class, [
                'label' => 'Tension (V)'
            ])
            ->add('rotor_tension2',NumberType::class, [
                'label' => 'Tension 2 (V)'
            ])
            ->add('rotor_expertise_refrigeant',ChoiceType::class, [
                'label'=> 'Expertise Réfrigeant',
                'choices' => [
                    'Hydro' => 'Hydro',
                    'Aéro' => 'Aéro',
                    'Aucun' => 'Aucun'
                ],
                'placeholder' => 'Choisir expertise'
            ])
            ->add('rotor_courant',NumberType::class, [
                'label' => 'Courant (A)'
            ])
            ->add('presence_plans')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}
