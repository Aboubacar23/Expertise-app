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

class LinterventionRetourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('marque')
             /*->add('type_intervention', ChoiceType::class, [
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
            */
            ->add('date_retour', DateType::class, [
                'label' => 'Date Retour Prévue',
                'widget' => 'single_text',
            ])
            ->add('observation')
            ->add('type')
            ->add('numero_certificat')
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat',
                'placeholder' => 'Choisissez un état',
                'choices' => [
                    'Fonctionnel' => 'Fonctionnel',
                    'Hors Validite' => 'Hors Validite',
                    'Perdu' => 'Perdu',
                    'HS' => 'HS',
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'placeholder' => 'Choisissez un statut',
                'choices' => [
                    'Conforme' => 'Conforme',
                    'NC' => 'NC',
                    'Tendance' => 'Tendance',
                ]
            ])
            ->add('date_etalonnage',DateType::class, [
                'label' => 'Date Etalonnage',
                'widget' => 'single_text',
            ])
           /* ->add('appareil', EntityType::class, [
                'label' => 'Repère',
                'class' => Appareil::class,
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lintervention::class,
        ]);
    }
}
