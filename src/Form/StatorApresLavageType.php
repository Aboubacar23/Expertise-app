<?php

namespace App\Form;

use App\Entity\StatorApresLavage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatorApresLavageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temp_ambiante')
            ->add('temp_tolerie')
            ->add('hygrometrie')
            ->add('valeur1')
            ->add('valeur2')
            ->add('valeur3')
            ->add('valeur4')
            ->add('valeur5')
            ->add('valeur6')
            ->add('valeur7')
            ->add('conformite1')
            ->add('conformite2')
            ->add('conformite3')
            ->add('conformite4')
            ->add('conformite5')
            ->add('conformite6')
            ->add('conformite7')
            ->add('etat')
            ->add('parametre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatorApresLavage::class,
        ]);
    }
}
