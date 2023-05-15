<?php

namespace App\Form;

use App\Entity\Machine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', ChoiceType::class, [
                'label' => 'Categorie',
                'placeholder' => 'Choisir une catégorie',
                'choices' => [
                    'Machines Asynchrone' => 'Machines Asynchrone',
                    'Machines Synchrone' => 'Machines Synchrone',
                    'Machines à courant continu' => 'Machines à courant continu',
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
                    'Excitation par jeu de bagues et châssi de régulation' => 'Excitation par jeu de bagues et châssi de régulation',
                    'Excitation par AE et pont diodes' => 'Excitation par AE et pont diodes',
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
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Machine::class,
        ]);
    }
}
