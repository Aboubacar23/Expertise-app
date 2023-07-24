<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Machine;
use App\Entity\Parametre;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ParametreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_machine', ChoiceType::class, [
                'choices' => [
                    'Moteur' => 'Moteur',
                    'Alternateur' => 'Alternateur',
                    'Génératrice' => 'Génératrice'
                ],
                'placeholder' => 'Choisir le type de machine'
            ])
            ->add('puissance')
            ->add('montage')
            ->add('fabricant')
            ->add('presence_balais')
            ->add('vitesse')
            ->add('masse')
            ->add('type_palier', ChoiceType::class, [
                'choices' => [
                    'Roulements' => 'Roulements',
                    'Coussinets' => 'Coussinets'
                ],
                'placeholder' => 'Choisir un type de palier'
            ])
            ->add('presence_balais_masse')
            ->add('stator_tension')
            ->add('stator_frequence')
            ->add('stator_courant')
            ->add('stator_couplage', ChoiceType::class, [
                'choices' => [
                    'Etoile' => 'Etoile'
                ],
                'placeholder' => 'Choisir couplage'
            ])
            ->add('date_arrivee', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('rotor_tension')
            ->add('rotor_expertise_refrigeant',ChoiceType::class, [
                'choices' => [
                    'Hydro' => 'Hydro',
                    'Aéro' => 'Aéro',
                    'Aucun' => 'Aucun'
                ],
                'placeholder' => 'Choisir expertise'
            ])
            ->add('rotor_courant')
            ->add('presence_plans')
            ->add('critere')
            ->add('temp_correction')
            ->add('type', EntityType::class, [
                //'mapped' => false,
                'class' => Type::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir un Type',
                'required' => false
            ]);
          /*  ->add('machine', ChoiceType::class, [
                'placeholder' => 'Choisir une Machine',
                'required' => false
            ]);
*/
            $formModifier = function (FormInterface $form, Type $type = null) {
                    $machines = (null === $type) ? [] : $type->getMachines();
                    $form->add('machine', EntityType::class, [
                        'class' => Machine::class,
                        'choices' => $machines,
                        'required' => false,
                        'disabled' => $machines === null,
                        'placeholder' => 'Choisir une Machine',
                            'attr' => ['class' => 'custom-select'],
                        ]);
                };  

            $builder->addEventListener(
                    FormEvents::PRE_SET_DATA,
                    function (FormEvent $event) use ($formModifier) {
                        $data = $event->getData();
                        $formModifier($event->getForm(), $data->getType());
                    }
                );

            $builder->get('type')->addEventListener(
                    FormEvents::POST_SUBMIT,
                    function (FormEvent $event) use ($formModifier) {
                        $type = $event->getForm()->getData();
                        $formModifier($event->getForm()->getParent(), $type);
                    }
                );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametre::class,
        ]);
    }
}
