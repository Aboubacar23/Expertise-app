<?php

namespace App\Form;

use App\Entity\Chercher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChercherPeriodiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('periodicite',ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    '0' => '0',
                    '3' => '3',
                    '6' => '6',
                    '9' => '9',
                    '12' => '12',
                    '18' => '18',
                    '24' => '24',
                    '36' => '36',
                    '48' => '48',
                    '60' => '60',
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
