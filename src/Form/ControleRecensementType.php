<?php

namespace App\Form;

use App\Entity\ControleRecensement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ControleRecensementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', ChoiceType::class, [
                'choices' => [
                    'Ensemble à l’arrivée' => 'Ensemble à l’arrivée',
                    'Bridage à l’arrivée' => 'Bridage à l’arrivée',
                ]
            ])
            ->add('photo',FileType::class, [
                'label' => 'Photo',
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
            'data_class' => ControleRecensement::class,
        ]);
    }
}
