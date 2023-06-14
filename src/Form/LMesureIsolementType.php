<?php

namespace App\Form;

use App\Entity\LMesureIsolement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LMesureIsolementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle', ChoiceType::class, [
                'choices' => [
                    'R phase U' => 'R phase U',
                    'R phase V' => 'R phase V',
                    'R phase W' => 'R phase W',
                    'RI U/V.W.masse - 1 min' => 'RI U/V.W.masse - 1 min',
                    'RI V/U.W.masse - 1 min' => 'RI V/U.W.masse - 1 min',
                    'RI W/V.W.masse - 1 min' => 'RI W/V.W.masse - 1 min',
                    'RI U.V.W/masse - 1 min' => 'RI U.V.W/masse - 1 min',
                    'RI U.V.W/masse - 10 min' => 'RI U.V.W/masse - 10 min',
                    'IP calculé 10 min / 1 min' => 'IP calculé 10 min / 1 min',
                ]
            ])
            ->add('critere')
            ->add('tension')
            ->add('valeur')
            ->add('conformite', ChoiceType::class, [
                'choices' => [
                    'Choisir' => 'Choisir',
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LMesureIsolement::class,
        ]);
    }
}
