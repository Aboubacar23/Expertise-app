<?php

namespace App\Form;

use App\Entity\LMesureResistance;
use App\Entity\ControleResistance;
use Symfony\Component\Form\AbstractType;
use App\Repository\ControleResistanceRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LMesureResistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('controle', EntityType::class, [
                'class' => ControleResistance::class,
                'query_builder' => function(ControleResistanceRepository $em){
                    $query = $em->createQueryBuilder('a');
                    return  $query;
                }
            ])
            ->add('critere', TextType::class,[
                'required' => true,
                'label' => 'Critère'
            ])
            ->add('unite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'mΩ' => 'mΩ',
                    'Ω' => 'Ω',
                    'µΩ' => 'µΩ',
                    'kΩ' => 'kΩ',
                    'MΩ' => 'MΩ',
                    'GΩ' => 'GΩ',
                    ' ' => ' ',
                ]
            ])
            ->add('temp_correction')
            ->add('valeur', TextType::class, [
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
                    '' => '',
                    'Stator' => 'Stator',
                    'Rotor' => 'Rotor',
                    "Stator 2" => "Stator 2",
                    "Rotor 2" => "Rotor 2",
                    "Stator PV" => "Stator PV",
                    "Stator GV" => "Stator GV",
                    "Rotor PV" => "Rotor PV",
                    "Rotor GV" => "Rotor GV",
                    "Stator AE" => "Stator AE",
                    'Rotor AE' => 'Rotor AE',
                    "Régulation" => "Régulation",
                    "Jeu de Bagues" => "Jeu de Bagues",
                    "Sondes" => "Sondes",
                    "Rechauffage" => "Rechauffage",
                    "Couronne porte balais" => "Couronne porte balais",
                    "induit" => "induit",
                    "Carcasse" => "Carcasse",
                ]
            ])
            ;
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LMesureResistance::class,
        ]);
    }
}
