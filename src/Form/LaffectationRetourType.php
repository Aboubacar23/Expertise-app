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

class LaffectationRetourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('type')
            ->add('numero_serie')
            ->add('date_retour',DateType::class, [
                'label' => 'Date Retour Prévue',
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('observation')
            ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Laffectation::class,
        ]);
    }
}
