<?php

namespace App\Form;

use App\Entity\EtudesAchats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EtudesAchatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quoi')
            ->add('delai', NumberType::class, [
                'required' => false
            ])
            ->add('observation')
            ->add('type',ChoiceType::class,[
                'choices' => [
                    'ETUDES' => 'ETUDES',
                    'ACHATS / SOUS-TRAITANCE' => 'ACHATS / SOUS-TRAITANCE',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtudesAchats::class,
        ]);
    }
}
