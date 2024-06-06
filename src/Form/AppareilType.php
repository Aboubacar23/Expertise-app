<?php

namespace App\Form;

use App\Entity\Appareil;
use App\Entity\ServiceResponsable;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AppareilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', ChoiceType::class, [
                'label' => 'Désignation du moyen de contrôle',
                'required' => true,
                'placeholder' => 'Choisissez',
                'choices' => [
                    'ÉLECTRIQUE' => [
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
                    'MÉCANIQUE' => [
                        'ALESOMETRE' => 'ALESOMETRE',
                        'ANEMOMETRE' => 'ANEMOMETRE',
                        'BAGUE FILETEE' => 'BAGUE FILETEE',
                        'BAGUE LISSE ETALON' => 'BAGUE LISSE ETALON',
                        'BALANCE' => 'BALANCE',
                        'BALANCE 12KG / 1G' => 'BALANCE 12KG / 1G',
                        'BROCHE ETALON' => 'BROCHE ETALON',
                        'BROCHE A BOUTS PLANS 100 mm' => 'BROCHE A BOUTS PLANS 100 mm',
                        'BROCHE A BOUTS PLANS 125 mm' => 'BROCHE A BOUTS PLANS 125 mm',
                        'BROCHE A BOUTS PLANS 150 mm' => 'BROCHE A BOUTS PLANS 150 mm',
                        'BROCHE A BOUTS PLANS 175 mm' => 'BROCHE A BOUTS PLANS 175 mm',
                        'BROCHE A BOUTS PLANS 200 mm' => 'BROCHE A BOUTS PLANS 200 mm',
                        'BROCHE A BOUTS PLANS 225 mm' => 'BROCHE A BOUTS PLANS 225 mm',
                        'BROCHE A BOUTS PLANS 25 mm' => 'BROCHE A BOUTS PLANS 25 mm',
                        'BROCHE A BOUTS PLANS 250 mm' => 'BROCHE A BOUTS PLANS 250 mm',
                        'BROCHE A BOUTS PLANS 50 mm' => 'BROCHE A BOUTS PLANS 50 mm',
                        'BROCHE A BOUTS PLANS 75 mm' => 'BROCHE A BOUTS PLANS 75 mm',
                        "CALES D'ETALONNAGE" => "CALES D'ETALONNAGE",
                        'CALES ETALONS' => 'CALES ETALONS',
                        'CALIBRE' => 'CALIBRE',
                        'CAPTEUR DE PRESION' => 'CAPTEUR DE PRESION',
                        'CLE DYNAMOMETRIQUE' => 'CLE DYNAMOMETRIQUE',
                        'COMPARATEUR MECANIQUE A LEVIER' => 'COMPARATEUR MECANIQUE A LEVIER',
                        'COMPARATEUR A CARDAN' => 'COMPARATEUR A CARDAN',
                        'COMPARATEUR NUMÉRIQUE' => 'COMPARATEUR NUMÉRIQUE',
                        'COMPAS A VERGES' => 'COMPAS A VERGES',
                        'CONVERTISSEUR DE PRESSION' => 'CONVERTISSEUR DE PRESSION',
                        'DÉTECTEUR MULTI-GAZ' => 'DÉTECTEUR MULTI-GAZ',
                        'DYNAMOMETRE' => 'DYNAMOMETRE',
                        'EQUILIBREUSE' => 'EQUILIBREUSE',
                        'JAUGE DE PROFONDEUR' => 'JAUGE DE PROFONDEUR',
                        'JAUGE MICROMETRIQUE' => 'JAUGE MICROMETRIQUE',
                        'MACHINE A BILLER' => 'MACHINE A BILLER',
                        'MANOMETRE' => 'MANOMETRE',
                        'MASSE 1 KG' => 'MASSE 1 KG',
                        'MASSE 50 g' => 'MASSE 50 g',
                        'MASSE 200 g' => 'MASSE 200 g',
                        'MASSE 500 g' => 'MASSE 500 g',
                        "MESUREUR D'EPAISSEUR" => "MESUREUR D'EPAISSEUR",
                        "MESUREUR INTERIEUR" => "MESUREUR INTERIEUR",
                        "MESUREUR EXTERIEUR" => "MESUREUR EXTERIEUR",
                        'MICROMETRE EXTERIEUR' => 'MICROMETRE EXTERIEUR',
                        'NIVEAU A CADRE' => 'NIVEAU A CADRE',
                        'PESON ELECTRIQUE' => 'PESON ELECTRIQUE',
                        'PESON MULTI-FONCTION' => 'PESON MULTI-FONCTION',
                        'PIED A COULISSE' => 'PIED A COULISSE',
                        'PIED A COULISSE 200 mm' => 'PIED A COULISSE 200 mm',
                        'PIED A COULISSE 300 mm' => 'PIED A COULISSE 300 mm',
                        'PIED A COULISSE 500 mm' => 'PIED A COULISSE 500 mm',
                        'PINCE A SERTIR' => 'PINCE A SERTIR',
                        'PINCE A SERTIR HYDRAULIQUE' => 'PINCE A SERTIR HYDRAULIQUE',
                        'PINCE A SERTIR MANUELLE' => 'PINCE A SERTIR MANUELLE',
                        'PINCE MANUELLE' => 'PINCE MANUELLE',
                        'POMPE A GRAISSE' => 'POMPE A GRAISSE',
                        'RALLONGE DE JAUNE MICROMETRIQUE' => 'RALLONGE DE JAUNE MICROMETRIQUE',
                        "RAPPORTEUR D'ANGLAIS" => "RAPPORTEUR D'ANGLAIS",
                        'RUGOSIMETRE' => 'RUGOSIMETRE',
                        'TAMPON FILETE' => 'TAMPON FILETE',
                        'TRUSQUIN' => 'TRUSQUIN',
                        'VERIFICATEUR ALESAGE' => 'VERIFICATEUR ALESAGE',
                        'VISCOSIMETRE' => 'VISCOSIMETRE',
                        'VISSEUSE' => 'VISSEUSE',                        
                    ],
                    'AUTRES' => [
                        'autres' => 'autres'
                    ]
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
           /* ->add('date_validite', DateType::class, [
                'label' => 'Date validitée',
                'required' => true,
                'widget' => 'single_text',

            ])*/
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
                    'Usine' => 'Usine'
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
            ->add('prix_achat',TextType::class, [
                'label' => 'Prix Achat (Euro)'
            ])
            ->add('numero_da', TextType::class, [
                'label'=> "N° d'achat( IFS ou autre )",
            ])
            ->add('nom_fournisseur')
            ->add('numero_certificat')
            ->add('classe_definition', CheckboxType::class, [
                'required' => false,
                'label' => 'Classe Définition'
            ])
            ->add('en_tendance', CheckboxType::class, [
                'required' => false,
                'label' => 'En tendance'
            ])
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
            ->add('type_service', ChoiceType::class, [
                'label' => 'Type Service',
                'placeholder' => 'Choisissez',
                'choices' => [
                    'electrique' => 'electrique',
                    'mecanique' => 'mecanique',
                    'autres' => 'autres',
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
                'required' => false,
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
