<?php

namespace App\Form;

use App\Entity\Intervention;
use App\Entity\RetourIntervention;
use App\Repository\InterventionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetourInterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intervention', EntityType::class, [
                'label' => "Numéro DA",
                'class' => Intervention::class,
                'placeholder' => 'Choisissez un numéro DA',
                'query_builder' => function(InterventionRepository $interventionRepository)
                {
                    $query = $interventionRepository->createQueryBuilder('a')->andWhere("a.retour = 0 ");
                   // $query->orderBy('a.num_appareil', 'asc');
                    return $query;
                }
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RetourIntervention::class,
        ]);
    }
}
