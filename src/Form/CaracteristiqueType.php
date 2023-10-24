<?php

namespace App\Form;

use App\Entity\Caracteristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CaracteristiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class,[
                'label' => 'Capture du tableau',
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
          /*  ->add('i1')
            ->add('i2')
            ->add('i3')
            ->add('p')
            ->add('q')
            ->add('cos')
            ->add('n')
            ->add('pj')
            ->add('p_pj')
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Caracteristique::class,
        ]);
    }
}
