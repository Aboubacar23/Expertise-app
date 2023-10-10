<?php

namespace App\Form;

use App\Entity\Chercher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChercherValiditeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_min', DateType::class, [ 
                'required' => false,
                'widget' => 'single_text',
                'label'=> 'Date Min',
                'attr' => [
                    'placeholder' => 'Date Min'
                ] 
            ])
            ->add('date_max', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label'=> 'Date Max',
                'attr' => [
                    'placeholder' => 'Date Max'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chercher::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
} 
