<?php

namespace App\Form;

use DateTime;
use App\Entity\Appareil;
use App\Entity\Lintervention;
use App\Repository\AppareilRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LinterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('marque')
            ->add('type_intervention', ChoiceType::class, [
                'label' => 'Type Intervation',
                'choices' => [
                    'VERIFICATION' => 'VERIFICATION',
                    'ETALONNAGE' => 'ETALONNAGE',
                    'REPARATION' => 'REPARATION',
                    'CALIBRAGE' => 'CALIBRAGE',
                    'MAINTENANCE' => 'MAINTENANCE',
                    'PRET' => 'PRET'
                ]
            ])
            ->add('date_retour', DateType::class, [
                'label' => 'Date Retour Prévue',
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('observation')
            ->add('appareil', EntityType::class, [
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
            'data_class' => Lintervention::class,
        ]);
    }
}
