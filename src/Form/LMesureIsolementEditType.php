<?php

namespace App\Form;

use App\Entity\LMesureIsolement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LMesureIsolementEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('controle')
            ->add('critere', NumberType::class,[
                'required' => true
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
                    ' ' => ' ',
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
                    "Stator PV" => "Stator PV",
                    "Stator GV" => "Stator GV",
                    "Stator 2" => "Stator 2",
                    "Rotor 2" => "Rotor 2",
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
            'data_class' => LMesureIsolement::class,
        ]);
    }
}
