<?php

namespace App\Form;

use App\Entity\Appareil;
use App\Entity\AppareilMesure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppareilMesureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appareil', EntityType::class, [
                'class' => Appareil::class,
                'placeholder' => 'Choisir votre appareil de messure'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppareilMesure::class,
        ]);
    }
}
