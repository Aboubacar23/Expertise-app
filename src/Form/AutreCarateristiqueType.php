<?php

namespace App\Form;

use App\Entity\AutreCaracteristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreCarateristiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('resistance')
            ->add('perte1')
            ->add('perte2')
            ->add('perte_fer1')
            ->add('perte_fer2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutreCaracteristique::class,
        ]);
    }
}
