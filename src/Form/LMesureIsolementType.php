<?php

namespace App\Form;

use App\Entity\LMesureIsolement;
use App\Entity\ControleIsolement;
use Symfony\Component\Form\AbstractType;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LMesureIsolementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle', EntityType::class, [
                'class' => ControleIsolement::class,
                'query_builder' => function(ControleIsolementRepository $em)
                {
                    $query = $em->createQueryBuilder('a');
                    return  $query;
                }
            ])
            ->add('critere', NumberType::class,[
                'required' => false
            ])
            ->add('tension')
            ->add('unite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'MΩ' => 'MΩ',
                    'Ω' => 'Ω',
                    'mΩ' => 'mΩ',
                    'µΩ' => 'µΩ',
                    'kΩ' => 'kΩ',
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
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    "" => "",
                    "Stator" => "Stator",
                    'Rotor' => 'Rotor',
                    "Stator 2" => "Stator 2",
                    "Rotor 2" => "Rotor 2",
                    "Stator AE" => "Stator AE",
                    'Rotor AE' => 'Rotor AE',
                    "Régulation" => "Régulation",
                    "Jeu de Bague" => "Jeu de Bague",
                    "Sondes" => "Sondes",
                    "Rechauffage" => "Rechauffage",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LMesureIsolement::class,
        ]);
    }
}
