<?php

namespace App\Form;

use App\Entity\PointFonctionnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PointFonctionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('observation', FileType::class)
            /*
            ->add('t')
            ->add('u')
            ->add('i1')
            ->add('i2')
            ->add('i3')
            ->add('p')
            ->add('q')
            ->add('cos')
            ->add('n')
            ->add('i')
            ->add('tamb')
            ->add('ca')
            ->add('coa')
            ->add('observation')
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PointFonctionnement::class,
        ]);
    }
}
