<?php

namespace App\Form;

use App\Entity\RevueEnclenchement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RevueEnclenchementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_contrat')
            ->add('cahier_charge')
            ->add('numero_pcq')
            ->add('amiante', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                    'Peut être' => 'Peut être'
                ]
            ])
            ->add('libelle', ChoiceType::class, [
                'choices' => [
                    'Pour travaux de base' => 'Pour travaux de base',
                    'Pour travaux complémentaires' => 'Pour travaux complémentaires'
                ]
            ])
            ->add('plan')
            ->add('description_prestation')
            ->add('contre_expertise')
            ->add('re7_client', DateType::class,[
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('observation')
            ->add('clarification')
            ->add('delai_demande_client',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('point_arret', ChoiceType::class,[
                'choices' => [
                    'Sans' => 'Sans',
                    'Avec Client' => 'Avec Client',
                    'Sans Client' => 'Sans Client'
                ]
            ])
            ->add('arrive_commande', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('arc', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('revue_enclenchement', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('arrivee_machine', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('objectif_rapport_expertise')
            ->add('objectif_mise_dispo')
            ->add('date_rapport_expertise_finalise', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('date_machine_prete', DateType::class,[
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RevueEnclenchement::class,
        ]);
    }
}
