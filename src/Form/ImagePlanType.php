<?php

namespace App\Form;

use App\Entity\ImagePlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImagePlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image_ca',FileType::class,[
                'label' => 'Photo CA',
                'required' => true,
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
            ])
            ->add('image_coa',FileType::class,[
                'label' => 'Photo COA',
                'required' => true,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImagePlan::class,
        ]);
    }
}
