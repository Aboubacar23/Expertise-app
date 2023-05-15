<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Affaire;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                'required' => true,
            ])
            ->add('num_fabrication', TextType::class, [
                'required' => true,
            ])
            ->add('num_article_client', TextType::class, [
                'required' => true,
            ])
            ->add('context',TextType::class, [
                'required' => false,
            ])
            ->add('num_affaire',TextType::class, [
                'required' => true,
            ])
            ->add('suivi_par',TextType::class, [
                'required' => true,
            ])
            ->add('date_livraison', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nom_rapport',TextType::class, [
                'required' => true,
            ])
            ->add('presentation_travaux', TextareaType::class, [
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('travaux_sup', TextareaType::class, [
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
