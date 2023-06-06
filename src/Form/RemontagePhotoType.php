<?php

namespace App\Form;

use App\Entity\RemontagePhoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RemontagePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle',ChoiceType::class, [
            'choices' => [
                "Photo de l'ensemble avant départ" => "Photo de l'ensemble avant départ",
                "Photo de l'accouplement avant départ" => "Photo de l'accouplement avant départ",
                "Photo du bridage avant départ" => "Photo du bridage avant départ",
                "Photo boite à borne avant départ" => "Photo boite à borne avant départ"
            ]
        ])
        ->add('image', FileType::class, [
            'label' => 'Images',
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
            'data_class' => RemontagePhoto::class,
        ]);
    }
}
