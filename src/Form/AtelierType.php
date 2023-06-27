<?php

namespace App\Form;

use App\Entity\Atelier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('operations',ChoiceType::class,[
                'choices' => [
                    'A réception' => 'A réception',
                    'Démontage moteur' => 'Démontage moteur',
                    'Lavage / Etuvage / Nettoyage' => 'Lavage / Etuvage / Nettoyage',
                    'Expertise électrique' => 'Expertise électrique',
                    'Expertise mécanique' => 'Expertise mécanique',
                    'Remontage moteur' => 'Remontage moteur',
                    'Autres' => 'Autres',
                ]
            ])
            ->add('travaux')
            ->add('heures')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
