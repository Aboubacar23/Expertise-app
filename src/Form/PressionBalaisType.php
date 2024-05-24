<?php

namespace App\Form;

use App\Entity\PressionBalais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PressionBalaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('critere')
            ->add('preconisation')
            ->add('conformite',ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            //->add('parametre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PressionBalais::class,
        ]);
    }
}
