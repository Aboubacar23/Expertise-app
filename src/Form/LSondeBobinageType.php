<?php

namespace App\Form;

use App\Entity\LSondeBobinage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LSondeBobinageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle',ChoiceType::class, [
                'choices' => [
                    'R Sonde phase U' => 'R Sonde phase U',
                    'R Sonde phase V' => 'R Sonde phase V',
                    'R Sonde phase W' => 'R Sonde phase W',
                    'R Sondes Palier CA' => 'R Sondes Palier CA',
                    'R Sondes Palier CA' => 'R Sondes Palier CAO',
                    'R entrée huile CA' => 'R entrée huile CA',
                    'R entrée huile CA' => 'R entrée huile COA',
                    'R sortie huile CA' => 'R sortie huile CA',
                    'R sortie huile CA' => 'R sortie huile COA',
                    'R entrée air 1' => 'R entrée air 1',
                    'R entrée air 2' => 'R entrée air 2',
                    'R sortie air 1' =>'R sortie air 1',
                    'R sortie air 2' => 'R sortie air 2',
                    'RI les X sondes réunies' => 'RI les X sondes réunies'
                ]
            ])
            ->add('critere')
            ->add('valeur_relevee')
            ->add('valeur')   
            ->add('conformite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '' => '',
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LSondeBobinage::class,
        ]);
    }
}
