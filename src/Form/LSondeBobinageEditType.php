<?php

namespace App\Form;

use App\Entity\LSondeBobinage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LSondeBobinageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        /*->add('controle',EntityType::class, [
            'class' => ControleResistance::class,
            'query_builder' => function(ControleResistanceRepository $em){
                $query = $em->createQueryBuilder('a');
                return  $query;
            }
        ])*/
        ->add('critere', TextType::class,[
            'required' => true,
            'label' => 'Critère'
        ])
        //->add('valeur_relevee')
        ->add('valeur')   
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
        ->add('temp_correction')
        ->add('conformite', ChoiceType::class, [
            'required' => true,
            'choices' => [
                '' => '',
                'Sans Objet' => 'Sans Objet',
                'Conforme' => 'Conforme',
                'Non Conforme' => 'Non Conforme'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LSondeBobinage::class,
        ]);
    }
}
