<?php

namespace App\Form;

use App\Entity\SondeBobinage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SondeBobinageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temp_ambiante')
            ->add('temp_tolerie')
            ->add('hygrometrie')
            ->add('date_essais', DateType::class, [
                'widget' => 'single_text',
                'required' => true
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SondeBobinage::class,
        ]);
    }
}
