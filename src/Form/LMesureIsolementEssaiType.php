<?php

namespace App\Form;

use App\Entity\ControleIsolement;
use App\Entity\LMesureIsolementEssai;
use Symfony\Component\Form\AbstractType;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LMesureIsolementEssaiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle', EntityType::class, [
                'class' => ControleIsolement::class,
                'query_builder' => function(ControleIsolementRepository $em){
                    $query = $em->createQueryBuilder('a');
                    return  $query;
                }
            ])
            ->add('critere')
            ->add('tension')
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
            ->add('valeur', NumberType::class, [
                'required' => true,
            ])
            ->add('conformite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '' => '',
                    'Sans Objet' => 'Sans Objet',
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '' => '',
                    'Stator' => 'Stator',
                    'Rotor' => 'Rotor'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LMesureIsolementEssai::class,
        ]);
    }
}