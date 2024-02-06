<?php

namespace App\Form;

use App\Entity\Chercher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChercherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'placeholder' => 'Choisissez un état',
                'choices' => [
                    'Fonctionnel' => 'Fonctionnel',
                    'Hors Validite' => 'Hors Validite',
                    'Perdu' => 'Perdu',
                    'HS' => 'HS',
                ]
            ])
            ->add('periodicite',ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    '0' => '0',
                    '3' => '3',
                    '6' => '6',
                    '9' => '9',
                    '12' => '12',
                    '18' => '18',
                    '24' => '24',
                    '36' => '36',
                    '48' => '48',
                    '60' => '60',
                ]
            ])
            ->add('date_min', DateType::class, [ 
                'required' => false,
                'widget' => 'single_text',
                'label'=> 'Date Min',
                'attr' => [
                    'placeholder' => 'Date Min'
                ] 
            ])
            ->add('date_max', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label'=> 'Date Max',
                'attr' => [
                    'placeholder' => 'Date Max'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chercher::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
} 
