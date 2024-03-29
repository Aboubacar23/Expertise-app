<?php

namespace App\Form;

use App\Entity\AutrePointFonctionnementRotor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutrePointFonctionnementRotorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('m')
            ->add('iden')
            ->add('cd')
            ->add('u')
            ->add('i1')
            ->add('i2')
            ->add('i3')
            ->add('imoy')
            ->add('pabs')
            ->add('pjoule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutrePointFonctionnementRotor::class,
        ]);
    }
}
