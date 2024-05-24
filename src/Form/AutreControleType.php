<?php

namespace App\Form;

use App\Entity\AutreControle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreControleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('balais_masse_preconisation1')
            ->add('balais_masse_critere1', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('balais_masse_critere1')
            ->add('balais_masse_critere2')
            ->add('balais_masse_critere3')
             ->add('balais_masse_preconisation5')
            ->add('balais_masse_preconisation6')
            ->add('balaisMasseConformite1', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('balaisMasseConformite5', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])           
            ->add('balaisMasseConformite6', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('balais_preconisation1')
            ->add('balais_critere1')
            ->add('balais_critere2')
            ->add('balais_critere3')
            ->add('balais_preconisation5')
            ->add('balais_preconisation6')
            ->add('balaisConformite1', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('balaisConformite5', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('balaisConformite6', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
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
