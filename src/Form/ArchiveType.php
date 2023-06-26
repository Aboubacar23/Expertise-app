<?php

namespace App\Form;

use App\Entity\Archive;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArchiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('version')
            ->add('date_archive', DateType::class, [
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('fichier', FileType::class, [
                'label' => 'Document Rapport (Fichier PDF)',
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'class' => 'text-primary',
                    'height' => 10,
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2097152k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                    ])
                ],
            ])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Archive::class,
        ]);
    }
}
