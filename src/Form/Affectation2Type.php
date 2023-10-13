<?php

namespace App\Form;

use App\Entity\AffaireMetrologie;
use DateTime;
use App\Entity\Affectation;
use App\Entity\ServiceResponsable;
use App\Repository\AffaireMetrologieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class Affectation2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_affaire')
            ->add('date_sortie', DateType::class, [
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('sortie_par')
            ->add('retour')
            ->add('service_affectation', EntityType::class, [
                'label' => 'Service Responsable',
                'class' => ServiceResponsable::class,
                'placeholder' => 'Choisissez un Service'
            ]); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
