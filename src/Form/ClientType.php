<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du client est obligatoire'
                    ])
                ]
            ])
            ->add('site',TextType::class, [
                'label' => 'Site',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le site du client est obligatoire'
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'required' => false
            ])
            ->add('ville')
            ->add('contact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
