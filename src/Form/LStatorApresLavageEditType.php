<?php

namespace App\Form;

use App\Entity\LStatorApresLavage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LStatorApresLavageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tension_essai')
            /*->add('controle', EntityType::class,  [
                'class' => ControleIsolement::class,
                'query_builder' => function(ControleIsolementRepository $em){
                    $query = $em->createQueryBuilder('a');
                    return  $query;
                }
            ])*/
            ->add('critere', NumberType::class,[
                'required' => true,
                'label' => 'Critère'
            ])
            ->add('temp_correction')
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
            ->add('valeur', NumberType::class, [
                'required' => true,
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
            ->add('conformite', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    '' => '',
                    'Sans Objet' => 'Sans Objet',
                    'Conforme' => 'Conforme',
                    'Non Conforme' => 'Non Conforme'
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LStatorApresLavage::class,
        ]);
    }
}
