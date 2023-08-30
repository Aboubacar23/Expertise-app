<?php

namespace App\Form;

use App\Entity\RemontageFinition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RemontageFinitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle_carcasse',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_cablage1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_cablage2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_cablage3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_cablage4',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_sonde1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_sonde2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_sonde3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_arbre1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_arbre2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general4',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general5',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general6',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general7',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general8',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general9',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general10',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general11',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_carcasse2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_cablage2_1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_sonde2_1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_arbre2_1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_arbre2_2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_arbre2_3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                ]
            ])
            ->add('controle_general2_1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_4',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_5',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_6',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_7',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_general2_8',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_plaque1',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_plaque2',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_plaque3',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_plaque4',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
            ->add('controle_plaque5',ChoiceType::class, [
                'choices' => [
                    "Non applicable" => "Non applicable",
                    "Conforme" => "Conforme",
                    "Non conforme" => "Non conforme",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RemontageFinition::class,
        ]);
    }
}
