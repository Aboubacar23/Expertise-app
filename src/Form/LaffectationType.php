<?php

namespace App\Form;

use DateTime;
use App\Entity\Appareil;
use App\Entity\Laffectation;
use App\Repository\AppareilRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LaffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('type') 
            ->add('type_service', ChoiceType::class, [
                'label' => 'Type Service',
                'placeholder' => 'Choisissez',
                'choices' => [
                    'mecanique' => 'mecanique',
                    'electrique' => 'electrique',
                ]
            ])
            ->add('numero_serie')
            ->add('date_sortie')
            ->add('observation')
            ->add('date_retour', DateType::class, [
                'label' => 'Date Retour Prévue',
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('appareil',EntityType::class, [
                'label' => 'Repère',
                'placeholder' => 'Choisissez',
                'class' => Appareil::class, 
                'query_builder' => function(AppareilRepository $appareilRepository)
                {
                    $query = $appareilRepository->createQueryBuilder('a')->andWhere("a.statut = 'Conforme' and a.etat = 'Fonctionnel' and a.status = 0 ");
                    return $query;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Laffectation::class,
        ]);
    }
}
