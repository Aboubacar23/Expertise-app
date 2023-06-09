<?php

namespace App\Form;

use App\Entity\AutreControle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreControleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('balais_masse_preconisation1')
            ->add('balais_masse_preconisation2')
            ->add('balais_masse_preconisation3')
            ->add('balais_masse_preconisation4')
            ->add('balais_masse_preconisation5')
            ->add('balais_masse_preconisation6')
            ->add('balaisMasseConformite1', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])            
            ->add('balaisMasseConformite2', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])            
            ->add('balaisMasseConformite3', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])            
            ->add('balaisMasseConformite4', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])            
            ->add('balaisMasseConformite5', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])            
            ->add('balaisMasseConformite6', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balais_preconisation1')
            ->add('balais_preconisation2')
            ->add('balais_preconisation3')
            ->add('balais_preconisation4')
            ->add('balais_preconisation5')
            ->add('balais_preconisation6')
            ->add('balaisConformite1', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balaisConformite2', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balaisConformite3', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balaisConformite4', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balaisConformite5', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('balaisConformite6', ChoiceType::class, [
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
            'data_class' => AutreControle::class,
        ]);
    }
}
