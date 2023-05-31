<?php

namespace App\Form;

use App\Entity\ControleGeometrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleGeometriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pivot_b1')
            ->add('pivot_b2')
            ->add('pivot_b3')
            ->add('pivot_b4')
            ->add('tolerie_e1')
            ->add('tolerie_e2')
            ->add('tolerie_e3')
            ->add('tolerie_e4')
            ->add('pivot_f1')
            ->add('pivot_f2')
            ->add('pivot_f3')
            ->add('pivot_f4')
            ->add('conformite_b', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('conformite_e', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('conformite_f', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('add_1')
            ->add('add_2')
            ->add('add_3')
            ->add('add_4')
            ->add('conformite_add', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('tolerie_c1')
            ->add('tolerie_c2')
            ->add('tolerie_c3')
            ->add('tolerie_c4')
            ->add('conformite_c')
            ->add('tolerie_d1')
            ->add('tolerie_d2')
            ->add('tolerie_d3')
            ->add('tolerie_d4')
            ->add('conformite_d', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('accouplement_g1')
            ->add('accouplement_g2')
            ->add('accouplement_g3')
            ->add('accouplement_g4')
            ->add('conformite_g', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleGeometrique::class,
        ]);
    }
}
