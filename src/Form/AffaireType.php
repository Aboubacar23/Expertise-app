<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Affaire;
use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class AffaireType extends AbstractType
{   
    private $entityManager;
 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code_client', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('num_fabrication', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('num_article_client', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('context',TextType::class, [
                'required' => false,
            ])
            ->add('num_affaire',TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('suivi_par',EntityType::class, [
                'required' => false,
                'class' => Admin::class,
                'placeholder' => 'Choisir un Chef de projet',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                    ],
                'query_builder' => function(AdminRepository $adminRepository){
                    $query = $adminRepository->createQueryBuilder('a')->andWhere("a.etat = 1");
                 //   dd($query);
                    return  $query;
                }
            ])
            ->add('date_livraison', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nom_rapport',TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
            ->add('presentation_travaux', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('travaux_sup', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,   
                'placeholder' => 'Choissir un client',
                'query_builder' => function(ClientRepository $clientRepository)
                {
                    $query = $clientRepository->createQueryBuilder('c')->andWhere('c.etat = 1');
                    return $query;
                }
            ])
        ;          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affaire::class,
        ]);
    }
}
