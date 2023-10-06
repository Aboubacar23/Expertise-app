<?php

namespace App\Form;

use DateTime;
use App\Entity\Affectation;
use App\Entity\RetourAffectation;
use Symfony\Component\Form\AbstractType;
use App\Repository\AffectationRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RetourAffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('retour_saisie_par')
            ->add('date_sortie', DateType::class, [
                'label' => 'Date Sortie',
                'required' => true,
                'widget' => 'single_text',
                'data' => new DateTime()

            ])
            ->add('affectation',EntityType::class, [
                'label' => "Numéro DA",
                'class' => Affectation::class,
                'placeholder' => 'Choisissez un numéro DA',
                'query_builder' => function(AffectationRepository $affectationRepository)
                {
                    $query = $affectationRepository->createQueryBuilder('a')->andWhere("a.retour = 0 ");
                    return $query;
                }
            ] )
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RetourAffectation::class,
        ]);
    }
}
