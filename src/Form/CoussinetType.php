<?php

namespace App\Form;

use App\Entity\Coussinet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoussinetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref_palier_ca')
            ->add('ref_palier_coa')
            ->add('num_code_ca') 
            ->add('photo_ca',FileType::class, [
                'label' => 'Photo',
                'required' => true, 
                'mapped' => false,
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
            ->add('num_code_coa')
            ->add('photo_coa',FileType::class, [
                'label' => 'Photo',
                'required' => true, 
                'mapped' => false,
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
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coussinet::class,
        ]);
    }
}
