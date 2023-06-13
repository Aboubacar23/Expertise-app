<?php

namespace App\Form;

use App\Entity\MesureIsolement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MesureIsolementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temp_ambiante')
            ->add('temp_tolerie')
            ->add('hygrometrie')
            ->add('date_essais', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('valeur1')
            ->add('valeur2')
            ->add('valeur3')
            ->add('valeur4')
            ->add('valeur5')
            ->add('valeur6')
            ->add('valeur7')
            ->add('tension1')
            ->add('tension2')
            ->add('tension3')
            ->add('tension4')
            ->add('tension5')
            ->add('tension6')
            ->add('tension7')
            ->add('conformite1', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite2', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite3', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite4', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite5', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite6', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('conformite7', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesureIsolement::class,
        ]);
    }
}
