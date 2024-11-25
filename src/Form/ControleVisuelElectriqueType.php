<?php

namespace App\Form;

use App\Entity\ControleVisuelElectrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleVisuelElectriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('balais_dimension')
            ->add('balais_marque')
            ->add('balais_quantite')
            ->add('balais_nuance')
            ->add('balais_longueur_shunt')
            ->add('balais_type_cosse')
            ->add('balais_aspect')
            ->add('balais_type_pression')
            ->add('balais_presence_gaine')
            ->add('balais_masse_dimension') 
            ->add('balais_masse_marque')
            ->add('balais_masse_quantite')
            ->add('balais_masse_nuance')
            ->add('balais_masse_longueur_shunt')
            ->add('balais_masse_type_cosse')
            ->add('balais_masse_aspect')
            ->add('balais_masse_type_pression')
            ->add('balais_masse_presence_gaine')
            ->add('pression_theorique')
            ->add('pression_theorique_balais_masse')
            ->add('sens_rotation', ChoiceType::class, [
                'choices' => [
                    'Horaire' => 'Horaire',
                    'Anti-Horaire' => 'Anti-Horaire',
                    'Les deux' => 'Les deux',
                ],
                'placeholder' => 'Choisir le sens'
            ])
            ->add('remarque')
            ->add('photo',FileType::class,[
                'label' => 'Photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '40M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir une image png, jpg ou jpeg',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ControleVisuelElectrique::class,
        ]);
    }
}
