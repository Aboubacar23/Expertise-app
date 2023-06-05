<?php

namespace App\Form;

use App\Entity\Caracteristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaracteristiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('u')
            ->add('i1')
            ->add('i2')
            ->add('i3')
            ->add('p')
            ->add('q')
            ->add('cos')
            ->add('n')
            ->add('pj')
            ->add('p_pj')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Caracteristique::class,
        ]);
    }
}
