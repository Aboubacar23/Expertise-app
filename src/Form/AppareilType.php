<?php

namespace App\Form;

use App\Entity\Appareil;
use App\Entity\ServiceResponsable;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AppareilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', ChoiceType::class, [
                'label' => 'Désignation du moyen de contrôle',
                'required' => false,
                'placeholder' => 'Choisissez',
                'choices' => [
                    'ACCELEROMETRE' => 'ACCELEROMETRE',
                    'AMPEREMETRES' => 'AMPEREMETRES',
                    'ANEMOMETRE-THE ET HYDRO' => 'ANEMOMETRE-THE ET HYDRO',
                    'APPAREILS DIVERS' => 'APPAREILS DIVERS',
                    'BOITES À DECADES' => 'BOITES À DECADES',
                    'CALIB. DECH. PARTIE' => 'CALIB. DECH. PARTIE',
                    'CAPACIMETRE' => 'CAPACIMETRE',
                    'CAPACITE ETALON ' => 'CAPACITE ETALON ',
                    'COM. DECH. PARTIEL' => 'COM. DECH. PARTIEL',
                    'CONVERTISSEUE DE MESURE POUR DEBIMETRE' => 'CONVERTISSEUE DE MESURE POUR DEBIMETRE',
                    'CONTROLEURS NUMERIQUES' => 'CONTROLEURS NUMERIQUES',
                    'CONTROLEUR' => 'CONTROLEUR',
                    'COND. DECH. PARTIEL' => 'COND. DECH. PARTIEL',
                    'PINCE AMPEREMETRIQUE' => 'PINCE AMPEREMETRIQUE',
                    'PINCE AMPEREMETRIQUE' => 'PINCE AMPEREMETRIQUE',
                    'MULTIMETRE' => 'MULTIMETRE',
                    'OHMMETRES ET MICROHMMETRES ' => 'OHMMETRES ET MICROHMMETRES ',
                    "POSTE D'EPREUVE DIELECTRIQUE" => "POSTE D'EPREUVE DIELECTRIQUE",
                    'ENREGISTREURS' => 'ENREGISTREURS',
                    'CHARGEUR' => 'CHARGEUR',
                    'THERMO-HYGROMETRE' => 'THERMO-HYGROMETRE',
                    'CHRONOMÈTRE' => 'CHRONOMÈTRE',
                    'PERCHE DETECTEUR DE TENSION' => 'PERCHE DETECTEUR DE TENSION',
                    'PONT DE SCHERING' => 'PONT DE SCHERING',
                    'VAT' => 'VAT',
                    'LASER LIGNAGE ET CONTRÔLE' => 'LASER LIGNAGE ET CONTRÔLE',
                    'LASER DE LIGNAGE' => 'LASER DE LIGNAGE',
                    'VOLTMETRES' => 'VOLTMETRES',
                    'ENDOSCOPE' => 'ENDOSCOPE',
                    'EMETTEUR' => 'EMETTEUR',
                    'RECEPTEUR' => 'RECEPTEUR',
                    'DETECTEUR GAZ' => 'DETECTEUR GAZ',
                    'ENDOSCOPE' => 'ENDOSCOPE',
                    'MARTEAU DE CHOCS' => 'MARTEAU DE CHOCS',
                    'MASSE 10 KG' => 'MASSE 10 KG',
                    'MASSE 20 KG' => 'MASSE 20 KG',
                    'MEGOHMMETRE' => 'MEGOHMMETRE',
                    'MILLIVOLTMETRES' => 'MILLIVOLTMETRES',
                    'OSCILLOSCOPES' => 'OSCILLOSCOPES',
                    'OXYGÉNOMÈTRE' => 'OXYGÉNOMÈTRE',
                    'HUNTES' => 'HUNTES',
                    'TACHYMETRES' => 'TACHYMETRES',
                    'TACHYMETRES DIGITAL' => 'TACHYMETRES DIGITAL',
                    'PINCE AMPEREMETRIQUE FLEXIBLE' => 'PINCE AMPEREMETRIQUE FLEXIBLE',
                    'TRANSFORMATEURS DE COURANT' => 'TRANSFORMATEURS DE COURANT',
                    'TRANSFORMATEURS DE POTENTIEL' => 'TRANSFORMATEURS DE POTENTIEL',
                    'THERMOMETRE DE PRECISION ' => 'THERMOMETRE DE PRECISION ',
                    'THERMOMETRE DIGITAL INDICATEUR' => 'THERMOMETRE DIGITAL INDICATEUR',
                    'TERMO-INFAROUGE' => 'TERMO-INFAROUGE',
                    'SONDES DE TEMPERATURE' => 'SONDES DE TEMPERATURE',
                    'VIBROMETRES' => 'VIBROMETRES',
                    'PLOT VIBRANT' => 'PLOT VIBRANT',
                    'WATTMETRES' => 'WATTMETRES',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La désignation est obligatoire'
                    ]) 
                ]
            ]) 
            ->add('num_appareil', TextType::class,[
                'label' => 'Repère',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Repère appareil'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro est obligatoire'
                    ])
                ]
            ])
            ->add('date_validite', DateType::class, [
                'label' => 'Date validitée',
                'required' => true,
                'widget' => 'single_text',

            ])
            ->add('numero_serie',TextType::class, [
                'label' =>'Numéro de serie'
            ])
            ->add('type')
            ->add('marque')
            ->add('service_responsable', EntityType::class, [
                'label' => 'Service Responsable',
                'class' => ServiceResponsable::class,
                'placeholder' => 'Choisissez un Service'
            ])
            ->add('periodicite',ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    '0' => '0',
                    '3' => '3',
                    '6' => '6',
                    '9' => '9',
                    '12' => '12',
                    '18' => '18',
                    '24' => '24',
                    '36' => '36',
                    '48' => '48',
                    '60' => '60',
                ]
            ])
            ->add('affectation',ChoiceType::class, [
                'label' => 'Affectation',
                'placeholder' => 'Choisissez',
                'choices' => [
                    'S/T' => 'S/T',
                    'Chantier' => 'Chantier',
                    'Local Métrologie' => 'Local Métrologie',
                    'Réserve' => 'Réserve',
                ]
            ])
            ->add('unite_mesure',TextType::class, [
                'label' =>'Unité de Mesure'
            ])
            ->add('classe_ap',TextType::class, [
                'label' =>'Classe'
            ])
            ->add('date_achat',DateType::class, [
                'label' => "Date d'âchat",
                'required' => true,
                'widget' => 'single_text',

            ])
            ->add('prix_achat',MoneyType::class, [
                'currency' => 'EUR'
            ])
            ->add('numero_da', TextType::class, [
                'label'=> "N° d'achat( IFS ou autre )",
            ])
            ->add('nom_fournisseur')
            ->add('numero_certificat')
            ->add('classe_definition')
            ->add('en_tendance')
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat',
                'placeholder' => 'Choisissez un état',
                'choices' => [
                    'Fonctionnel' => 'Fonctionnel',
                    'Hors Validite' => 'Hors Validite',
                    'Perdu' => 'Perdu',
                    'HS' => 'HS',
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'placeholder' => 'Choisissez un statut',
                'choices' => [
                    'Conforme' => 'Conforme',
                    'NC' => 'NC',
                    'Tendance' => 'Tendance',
                ]
            ])
            ->add('date_etat',DateType::class, [
                'label' => 'Depuis le',
                'required' => true,
                'widget' => 'single_text',

            ])
            ->add('observation', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appareil::class,
        ]);
    }
}
