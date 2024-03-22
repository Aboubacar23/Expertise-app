<?php

namespace App\Form;

use App\Entity\PhotoExpertiseMecanique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PhotoExpertiseMecaniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',ChoiceType::class, [
                'choices' => [
                    "Photo de l'ensemble à l'arrivée" => "Photo de l'ensemble à l'arrivée",
                    "Photo de l'accouplement à l'arrivée" => "Photo de l'accouplement à l'arrivée",
                    "Photo du bridage à l'arrivée" => "Photo du bridage à l'arrivée",
                    "Photo du rotor au démontage" => "Photo du rotor au démontage",
                    "Photo des Réfrigérant à l'expertise" => "Photo des Réfrigérant à l'expertise",
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Images',
                'required' => true,
                'attr' => [
                    'class' => 'form-file-path'
                ],
                 'constraints' => [
                     new File([
                         'maxSize' => '50M',
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
            'data_class' => PhotoExpertiseMecanique::class,
        ]);
    }
}
