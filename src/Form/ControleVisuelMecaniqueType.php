<?php

namespace App\Form;

use App\Entity\ControleVisuelMecanique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class ControleVisuelMecaniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bridage')
            ->add('chassis')
            ->add('boite_borne',CheckboxType::class,[
                'label' => 'Boîte à borne Phase',
                'required' => false
            ])
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
            ->add('phase_neutre', CheckboxType::class,[
                'label' => 'Boîte à borne Neutre',
                'required' => false,
            ])
            ->add('photo_accouplement',FileType::class, [
                'label' => 'photo_accouplement',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir une image png, jpg ou jpeg',
                    ])
                ]
            ])
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
