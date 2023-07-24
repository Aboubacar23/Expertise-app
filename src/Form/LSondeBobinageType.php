<?php

namespace App\Form;

use App\Entity\LSondeBobinage;
use App\Entity\ControleResistance;
use Symfony\Component\Form\AbstractType;
use App\Repository\ControleResistanceRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LSondeBobinageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle',EntityType::class, [
                'class' => ControleResistance::class,
                'query_builder' => function(ControleResistanceRepository $em){
                    $query = $em->createQueryBuilder('a');
                    return  $query;
                }
            ])
            ->add('critere')
            ->add('valeur_relevee')
            ->add('valeur')   
            ->add('unite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Ω' => 'Ω',
                    'mΩ' => 'mΩ',
                    'µΩ' => 'µΩ',
                    'kΩ' => 'kΩ',
                    'MΩ' => 'MΩ',
                    'GΩ' => 'GΩ',
                ]
            ])
            ->add('temp_correction')
            ->add('conformite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '' => '',
                    'Sans Objet' => 'Sans Objet',
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LSondeBobinage::class,
        ]);
    }
}
