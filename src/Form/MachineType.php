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

class MachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          /*  ->add('type', EntityType::class,[
                'class' => Type::class,
                'placeholder' => 'Choisir le type'
            ])
            */
            ->add('categorie', ChoiceType::class, [
                'label' => 'Categorie',
                'placeholder' => 'Choisir une catégorie',
                'choices' => [
                    'Asynchrone' => 'Asynchrone',
                    'Synchrone' => 'Synchrone',
                    'À courant continu' => 'À courant continu',
                    'Autres' => 'Autres',
                ]
            ]) 
            ->add('sous_categorie', ChoiceType::class, [
                'label' => 'Sous Categorie',
                'placeholder' => 'Choisir une sous catégorie',
                'required' => false,
                'choices' => [
                    'A cage' => 'A cage',
                    'A Rotor bobiné' => 'A Rotor bobiné',
                   'Rotor à aimant permenant' => 'Rotor à aimant permenant',
                    'Stator Seul' => 'Stator Seul',
                    'Induit Seul' => 'Induit Seul',
                    'Self' => 'Self',
                    'Carcasse Seule' => 'Carcasse Seule',
                    'Rotor Seul' => 'Rotor Seul',
                    'Roue polaire' => 'Roue polaire',
                    'Roue polaire Seul' => 'Roue polaire Seul',
                ]
            ])
            ->add('sous_categorie2', ChoiceType::class, [
                'label' => 'Sous Categorie 2',
                'placeholder' => 'Choisir une sous catégorie',
                'required' => false,
                'choices' => [
                    'Neutre Sorti' => 'Neutre Sorti',
                    'Neutre Interne' => 'Neutre Interne',
                    'Alternatif' => 'Alternatif',
                    'Continu' => 'Continu',
                    'A cage' => 'A cage',
                    'Bobiné' => 'Bobiné',
                    'Excitation par Jeu de Bague et châssi de régulation' => 'Excitation par Jeu de Bague et châssi de régulation',
                    'Excitation par AE et Pont de diodess' => 'Excitation par AE et Pont de diodess',
                    'Roue polaire' => 'Roue polaire',
                ]
            ])
            ->add('sous_categorie3', ChoiceType::class, [
                'label' => 'Sous Categorie 3',
                'required' => false,
                'placeholder' => 'Choisir une sous catégorie',
                'choices' => [
                    'Neutre Sorti' => 'Neutre Sorti',
                    'Neutre Interne' => 'Neutre Interne',
                    ' - ' => ' - ',
                ],
            ])
        /*    
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
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Machine::class,
        ]);
    }
}
