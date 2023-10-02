<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class, [
                'label' => 'Nom Utilisateur',
                'required' => false,
               // 'disabled' => true,
                'attr' => [
                    'placeholder' => 'au moins 6 caractères'
                ],
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le nom utilisateur doit comporter au moins {{ limit }} caractères',
                        'max' => 14,
                        'maxMessage' => 'Le nom utilisateur ne doit pas dépasser {{ limit }} caractères'
                    ]),
                    new NotBlank([
                        'message' => "Veuillez entrer le nom d'utilisateur",
                    ]),
                ],
            ])
            ->add('nom',TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer le nom de l'utilisateur",
                    ]),
                ],
            ])
            ->add('telephone',TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'minMessage' => 'Le numéro de téléphone est de {{ limit }} chiffres',
                        'max' => 14,
                        'maxMessage' => 'Le numéro de téléphone est de {{ limit }} chiffres'
                    ]),
                ],
            ])
            ->add('prenom',TextType::class, [
                'label' => 'Prenom',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer le prenom de l'utilisateur",
                    ]),
                ],
            ])
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer l'email de l'utilisateur",
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'email@gmail.com'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les conditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions',
                    ]),
                ],
                'label_attr' => [
                    'class' => 'text-danger'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password (par défaut Password@0 )',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'SUPER ADMIN' => 'ROLE_SUPER_ADMIN',
                    'CHEF PROJET' => 'ROLE_CHEF_PROJET', 
                    'AGENT DE MAÎTRISE' => 'ROLE_AGENT_MAITRISE',
                    'VÉRIFICATEUR' => 'ROLE_VERIFICATEUR',
                    'TECHNICIEN ÉLECTRICIEN' => 'ROLE_TECHNICIEN_ELECTRICIEN',
                    'TECHNICIEN MECANICIEN' => 'ROLE_TECHNICIEN_MECANICIEN',
                    'LECTEUR' => 'ROLE_LECTEUR',
                    'MAGASINIER' => 'ROLE_MAGASINIER',
                    'METROLOGUE' => 'ROLE_METROLOGUE',
                    ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez choisir au moins un rôle utilisateur",
                    ]),
                ],
            ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
