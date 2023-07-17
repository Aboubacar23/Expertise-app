<?php

namespace App\Form;

use App\Entity\ControleVisuelMecanique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleVisuelMecaniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bridage')
            ->add('chassis')
            ->add('boite_borne')
            ->add('barrette_neutre')
            ->add('reference_rotor')
            ->add('reference_stator')
            ->add('peinture')
            ->add('vis_verins')
            ->add('tresse_masse')
            ->add('clavette')
            ->add('sonde_palier_ca')
            ->add('sonde_palier_coa')
            ->add('autres_sondes')
            ->add('numero_serie')
            ->add('nombre_accessoire')
            ->add('phase_neutre')
            ->add('accouplement',ChoiceType::class, [
                'choices' => [
                    'Aucun' => 'Aucun',
                    'Débordant' => 'Débordant',
                    'Rentré' => 'Rentré',
                    'Affleurant' => 'Affleurant',
                ],
                'placeholder' => "Choisir l'accouplement"
            ])
            ->add('position_accouplement')
        ;
    }  

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleVisuelMecanique::class,
        ]);
    }
}
