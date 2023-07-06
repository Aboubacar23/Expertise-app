<?php

namespace App\Form;

use App\Entity\Roulement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoulementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_ca')
            ->add('type_coa')
            ->add('graisse_ca')
            ->add('graisse_coa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roulement::class,
        ]);
    }
}
