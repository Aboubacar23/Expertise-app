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
            ->add('essais_plateforme', ChoiceType::class, [
                'label' => 'Essais Plate-forme à reception',
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ]
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
            ->add('stator_tension2')
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
            ->add('rotor_tension2')
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
            ->add('machine', EntityType::class, [
                'class' => Machine::class,
                'placeholder' => 'Choisir une machine',
            ])
            //On affiche tous les types de machines de la machine
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir un Type',
            ]);

            /**
             * Par défaut, on retourne un tableau de machine vide
             * et on attend un clic sur la liste déroulante de type de machine voir (2)
             * si y'a le clic sur la liste on cherche dans la liste des machines les types liés par rélation de table (n..1)
             * et affiche le resultat sous forme de tableau
             */
      /*      $formModifier = function (FormInterface $form, Type $type = null) {
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
            
                //pour le premier clic on récupere le type et on l'envoi pour le filtre
            $builder->addEventListener(
                    FormEvents::PRE_SET_DATA,
                    function (FormEvent $event) use ($formModifier) {
                        $data = $event->getData();
                        $formModifier($event->getForm(), $data->getType());
                    }
                );

            //et le type envoyer récupere tous les éléments parent du type de machine 
            $builder->get('type')->addEventListener(
                    FormEvents::POST_SUBMIT,
                    function (FormEvent $event) use ($formModifier) {
                        $type = $event->getForm()->getData();
                        $formModifier($event->getForm()->getParent(), $type);
                    }
                );
                */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametre::class,
        ]);
    }
}
