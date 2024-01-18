<?php

namespace App\Form;

use App\Entity\Equirepartition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EquirepartitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pole')
            ->add('tension', NumberType::class, [
                'label' => 'Tension',
                'required' => true,
                'attr' => [
                    'placeholder' => "0"
                ]
            ])
            ->add('conforme', ChoiceType::class, [
                'label' => 'Conformité',
                'required' => false,
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
           // ->add('parametre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equirepartition::class,
        ]);
    }
}
