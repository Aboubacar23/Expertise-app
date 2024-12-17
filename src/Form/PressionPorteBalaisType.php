<?php

namespace App\Form;

use App\Entity\PressionPorteBalais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PressionPorteBalaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_balai', IntegerType::class, [
                'label' => 'N° Balai',
                'attr' => [
                    'placeholder' => '0'
                ]
            ])
            ->add('critere', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    '' => '',
                    'Sans Objet' => 'Sans Objet',
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('pression', TextType::class, [
                'label' => 'Pression (kg)',
                'attr' => [
                    'placeholder' => '0.0'
                ]
            ])
          //  ->add('parametre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PressionPorteBalais::class,
        ]);
    }
}
