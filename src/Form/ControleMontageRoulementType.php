<?php

namespace App\Form;

use App\Entity\ControleMontageRoulement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControleMontageRoulementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ca_roulement')
            ->add('ca_montage')
            ->add('ca_kit', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('coa_roulement')
            ->add('coa_montage')
            ->add('coa_kit', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('cote_ca_a')
            ->add('cote_ca_b')
            ->add('cote_ca_c')
            ->add('cote_ca_d')
            ->add('cote_ca_vide1')
            ->add('cote_ca_jeu')
            ->add('cote_ca_vide2')
            ->add('cote_coa_a')
            ->add('cote_coa_b')
            ->add('cote_coa_c')
            ->add('cote_coa_d')
            ->add('cote_coa_vide1')
            ->add('cote_coa_jeu')
            ->add('cote_coa_vide2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleMontageRoulement::class,
        ]);
    }
}
