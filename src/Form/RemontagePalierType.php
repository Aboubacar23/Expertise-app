<?php

namespace App\Form;

use App\Entity\RemontagePalier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemontagePalierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('caa')
            ->add('cab')
            ->add('cac')
            ->add('cad')
            ->add('ca_roulement')
            ->add('type_graisse')
            ->add('coaa')
            ->add('coab')
            ->add('coac')
            ->add('coad')
            ->add('coa_roulement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RemontagePalier::class,
        ]);
    }
}
