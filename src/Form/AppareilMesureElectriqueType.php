<?php

namespace App\Form;

use App\Entity\Appareil;
use App\Entity\AppareilMesureElectrique;
use App\Repository\AppareilRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppareilMesureElectriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appareil', EntityType::class, [
                'class' => Appareil::class,
                'placeholder' => 'Choisir votre appareil de messure',
                'query_builder' => function(AppareilRepository $appareilRepository)
                {
                    $query = $appareilRepository->createQueryBuilder('a')->andWhere("a.etat = 'Fonctionnel' and a.statut = 'Conforme' and a.type_service ='electrique'");
                    return $query;
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppareilMesureElectrique::class,
        ]);
    }
}
