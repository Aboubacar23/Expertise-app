<?php

namespace App\Form;

use App\Entity\RemontageEquilibrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RemontageEquilibrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vitesse')
            ->add('poids_rotor')
            ->add('vitesse_equilibrage')
            ->add('nb_plan')
            ->add('qualite_equilibrage')
            ->add('clavette_entiere', CheckboxType::class, [
                    'label' => false,
                    'required' => false,
                ])
             ->add('clavette_1_2', CheckboxType::class, [
                    'label' => false,
                    'required' => false,
                ])
            ->add('clavette_sans', CheckboxType::class, [
                    'label' => false,
                    'required' => false,
                ])
            ->add('sans_plan_ca1')
            ->add('sans_plan_ca2')
            ->add('sans_plan_ca3')
            ->add('sans_plan_ca4')
            ->add('sans_plan_ca5')
            ->add('sans_plan_ca6')
            ->add('avec_plan_ca1')
            ->add('avec_plan_ca2')
            ->add('avec_plan_ca3')
            ->add('avec_plan_ca4')
            ->add('avec_plan_ca5')
            ->add('avec_plan_ca6')
            ->add('correction')
            ->add('sans_plan_coa1')
            ->add('sans_plan_coa2')
            ->add('sans_plan_coa3')
            ->add('sans_plan_coa4')
            ->add('sans_plan_coa5')
            ->add('sans_plan_coa6')
            ->add('avec_plan_coa1')
            ->add('avec_plan_coa2')
            ->add('avec_plan_coa3')
            ->add('avec_plan_coa4')
            ->add('avec_plan_coa5')
            ->add('avec_plan_coa6')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RemontageEquilibrage::class,
        ]);
    }
}
