<?php

namespace App\Form;

use App\Entity\ControleGeometrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleGeometriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('faux_rond_1')
            ->add('faux_rond_2')
            ->add('faux_rond_3')
            ->add('faux_rond_4')
            ->add('diametre', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    "∅ A" => "∅ A",
                    "∅ B" => "∅ B",
                    "∅ C" => "∅ C",
                    "∅ D" => "∅ D",
                    "∅ E" => "∅ E",
                    "∅ F" => "∅ F",
                    "∅ G" => "∅ G",
                    "∅ H" => "∅ H",

                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    "Bt.A Add" => "Bt.A Add",
                    "Pivot" => "Pivot",
                    "Tôlerie" => "Tôlerie",
                    "Accouplement" => "Accouplement"
                ],
                'required' => true
            ])
            ->add('conformite', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleGeometrique::class,
        ]);
    }
}
