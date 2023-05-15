<?php

namespace App\Form;

use App\Entity\Appareil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class AppareilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, [
                'label' => 'Désignation du moyen de contrôle',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'La désignation est obligatoire'
                    ])
                ]
            ])
            ->add('num_appareil', TextType::class,[
                'label' => 'N° appareil',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro est obligatoire'
                    ])
                ]
            ])
            ->add('date_validite', DateType::class, [
                'label' => 'Date validitée de la carte',
                'required' => true,
                'widget' => 'single_text',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appareil::class,
        ]);
    }
}
