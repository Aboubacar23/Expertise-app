<?php

namespace App\Form;

use App\Entity\AffaireMetrologie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffaireMetrologieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_affaire')
            ->add('nom_affaire')
            ->add('chef_chantier')
            ->add('observation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffaireMetrologie::class,
        ]);
    }
}
