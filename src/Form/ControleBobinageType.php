<?php

namespace App\Form;

use App\Entity\ControleBobinage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleBobinageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('conformite1', ChoiceType::class, [
                'choices' => [
                    'Choisissez' => 'Choisissez',
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('conformite2',ChoiceType::class, [
                'choices' => [
                    'Choisissez' => 'Choisissez',
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('constat1')
            ->add('constat2')

            ->add('observation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleBobinage::class,
        ]);
    }
}
