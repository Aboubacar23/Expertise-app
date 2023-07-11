<?php

namespace App\Form;

use App\Entity\Remarque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RemarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('image',FileType::class, [
                'label' => 'Image',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remarque::class,
        ]);
    }
}
