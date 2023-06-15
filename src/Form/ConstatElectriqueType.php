<?php

namespace App\Form;

use App\Entity\ConstatElectrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConstatElectriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('verification')
            ->add('critere')
            ->add('observation')
            ->add('preconisation_conclusion')
            ->add('retenu',ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('photo',FileType::class, [
                'label' => 'Images',
                'mapped' => false,
                'required' => true, 
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
            'data_class' => ConstatElectrique::class,
        ]);
    }
}
