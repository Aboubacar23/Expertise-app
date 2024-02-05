<?php

namespace App\Form;

use App\Entity\ConstatMecanique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConstatMecaniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('verification')
            ->add('critere')
            ->add('observation')
            ->add('preconisation_conclusion')
             ->add('retenu', ChoiceType::class, [
                'label' => 'Retenu',
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON'
                ]
            ])
            ->add('photo',FileType::class, [
                'label' => 'Images',
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
            'data_class' => ConstatMecanique::class,
        ]);
    }
}
