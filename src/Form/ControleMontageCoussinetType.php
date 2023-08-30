<?php

namespace App\Form;

use App\Entity\ControleMontageConssinet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleMontageCoussinetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accouplement_avant1')
            ->add('accouplement_avant2')
            ->add('accouplement_avant3')
            ->add('accouplement_arriere1')
            ->add('accouplement_arriere2')
            ->add('accouplement_arriere3')
            ->add('accouplement_oppose_avant1')
            ->add('accouplement_oppose_avant2')
            ->add('accouplement_oppose_avant3')
            ->add('accouplement_oppose_arriere1')
            ->add('accouplement_oppose_arriere2')
            ->add('accouplement_oppose_arriere3')
            ->add('ca_nature_releve')
            ->add('ca_diametre_attendu')
            ->add('ca_tolerence')
            ->add('ca_moyenne_releve')
            ->add('ca_conformite', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ] 
            ])
            ->add('ca_observation')
            ->add('coa_nature_releve')
            ->add('coa_diametre_attendu')
            ->add('coa_tolerance')
            ->add('coa_moyenne_releve')
            ->add('coa_conformite',ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('coa_observation') 
            ->add('d1')
            ->add('d2')
            ->add('d3')
            ->add('d4')
            ->add('d5')
            ->add('d6')
            ->add('d7')
            ->add('d8')
            ->add('d9')
            ->add('d10')
            ->add('d11')
            ->add('d12')
            ->add('longueur_accouplement')
            ->add('longueur_opp_accouplement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleMontageConssinet::class,
        ]);
    }
}
