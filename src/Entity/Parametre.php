<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
class Parametre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'parametres')]
    private ?Machine $machine = null;

    #[ORM\Column(length: 255)]
    private ?string $type_machine = null;

    #[ORM\Column(length: 255)]
    private ?string $puissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $montage = null;

    #[ORM\Column(length: 255)]
    private ?string $fabricant = null;

    #[ORM\Column]
    private ?bool $presence_balais = null;

    #[ORM\ManyToOne(inversedBy: 'parametres')]
    private ?Type $type = null;

    #[ORM\Column(length: 255)]
    private ?string $vitesse = null;

    #[ORM\Column(nullable: true)]
    private ?float $masse = null;

    #[ORM\Column(length: 255)]
    private ?string $type_palier = null;

    #[ORM\Column]
    private ?bool $presence_balais_masse = null;

    #[ORM\Column]
    private ?float $stator_tension = null;

    #[ORM\Column(nullable: true)]
    private ?float $stator_frequence = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $stator_courant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stator_couplage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_arrivee = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_tension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rotor_expertise_refrigeant = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $rotor_courant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $presence_plans = null;

    #[ORM\ManyToOne(inversedBy: 'parametres')]
    private ?Affaire $affaire = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleVisuelElectrique $controleVisuelElectrique = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureVibratoire $mesure_vibratoire = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleBobinage $controleBobinage = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?AutreControle $autre_controle = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?Photo $photo = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: AppareilMesure::class)]
    private Collection $appareilMesures;
 
    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureIsolement $mesure_isolement = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureResistance $mesure_resistance = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PointFonctionnement::class)]
    private Collection $pointFonctionnements;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ConstatElectrique::class)]
    private Collection $constatElectriques;

    #[ORM\Column(nullable: true)]
    private ?bool $expertise_electique_avant_lavage = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleVisuelMecanique $controle_visuel_mecanique = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleMontageRoulement $controle_montage_roulement = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleMontageConssinet $controle_montage_coussinet = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: AppareilMesureMecanique::class)]
    private Collection $appareilMesureMecaniques;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?HydroAero $hydro_aero = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PhotoExpertiseMecanique::class)]
    private Collection $photoExpertiseMecaniques;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ConstatMecanique::class)]
    private Collection $constatMecaniques;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ReleveDimmensionnel::class)]
    private Collection $releveDimmensionnels;

    #[ORM\Column(nullable: true)]
    private ?bool $expertise_mecanique = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?StatorApresLavage $stator_apres_lavage = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?SondeBobinage $sonde_bobinage = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: Caracteristique::class)]
    private Collection $caracteristiques;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?AutreCaracteristique $autre_caracteristique = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PointFonctionnementRotor::class)]
    private Collection $pointFonctionnementRotors;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?AutrePointFonctionnementRotor $autre_point_fonctionnement_rotor = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: AppareilMesureElectrique::class)]
    private Collection $appareilMesureElectriques;

    #[ORM\Column(nullable: true)]
    private ?bool $expertise_electique_apres_lavage = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ConstatElectriqueApresLavage::class)]
    private Collection $constatElectriqueApresLavages;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?RemontagePalier $remontage_palier = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?RemontageEquilibrage $remontage_equilibrage = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: RemontagePhoto::class)]
    private Collection $remontagePhotos;

    #[ORM\Column(nullable: true)]
    private ?bool $remontage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?RemontageFinition $remontage_finition = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut_final = null;

    #[ORM\Column(nullable: true)]
    private ?float $critere = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $corbeille = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ControleRecensement::class)]
    private Collection $controleRecensements;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: Plaque::class)]
    private Collection $plaques;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?Coussinet $coussinet = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ContreExpertise $contre_expertise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $user = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: Phototheque::class)]
    private Collection $phototheques;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?LPlaque $lplaque = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?Roulement $roulement = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: Synoptique::class)]
    private Collection $synoptiques;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: ControleGeometrique::class)]
    private Collection $controleGeometriques;

    #[ORM\Column(nullable: true)]
    private ?float $temp_correction = null;

    #[ORM\Column(nullable: true)]
    private ?bool $essais_finaux = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: AppareilMesureEssais::class)]
    private Collection $appareilMesureEssais;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureVibratoireEssais $mesure_vibratoire_essais = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PointFonctionnementVide::class)]
    private Collection $pointFonctionnementVides;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureIsolementEssai $mesure_isolement_essai = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?MesureResistanceEssai $mesure_resistance_essai = null;

    #[ORM\Column(nullable: true)]
    private ?float $stator_tension2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_tension2 = null;

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?InfoGenerale $info_generale = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PhotoRotor::class)]
    private Collection $photoRotors;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $essais_plateforme = null;

    #[ORM\Column(nullable: true)]
    private ?float $stator_courant_excitation = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: Equirepartition::class)]
    private Collection $equirepartitions;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PontDiode::class)]
    private Collection $pontDiodes;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: BoiteBorne::class)]
    private Collection $boiteBornes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_qualite = null;

    #[ORM\OneToOne(mappedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ImagePlan $imagePlan = null;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PressionBalais::class)]
    private Collection $pressionBalais;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PressionMasseBalais::class)]
    private Collection $pressionMasseBalais;

    #[ORM\OneToMany(mappedBy: 'parametre', targetEntity: PressionPorteBalais::class)]
    private Collection $pressionPorteBalais;

    #[ORM\OneToOne(mappedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?Signature $signature = null;

    public function __construct()
    {
        $this->appareilMesures = new ArrayCollection();
        $this->pointFonctionnements = new ArrayCollection();
        $this->constatElectriques = new ArrayCollection();
        $this->appareilMesureMecaniques = new ArrayCollection();
        $this->photoExpertiseMecaniques = new ArrayCollection();
        $this->constatMecaniques = new ArrayCollection();
        $this->releveDimmensionnels = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
        $this->pointFonctionnementRotors = new ArrayCollection();
        $this->appareilMesureElectriques = new ArrayCollection();
        $this->constatElectriqueApresLavages = new ArrayCollection();
        $this->remontagePhotos = new ArrayCollection();
        $this->controleRecensements = new ArrayCollection();
        $this->plaques = new ArrayCollection();
        $this->phototheques = new ArrayCollection();
        $this->synoptiques = new ArrayCollection();
        $this->controleGeometriques = new ArrayCollection();
        $this->appareilMesureEssais = new ArrayCollection();
        $this->pointFonctionnementVides = new ArrayCollection();
        $this->photoRotors = new ArrayCollection();
        $this->equirepartitions = new ArrayCollection();
        $this->pontDiodes = new ArrayCollection();
        $this->boiteBornes = new ArrayCollection();
        $this->pressionBalais = new ArrayCollection();
        $this->pressionMasseBalais = new ArrayCollection();
        $this->pressionPorteBalais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): self
    {
        $this->machine = $machine;

        return $this;
    }

    public function getTypeMachine(): ?string
    {
        return $this->type_machine;
    }

    public function setTypeMachine(string $type_machine): self
    {
        $this->type_machine = $type_machine;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(string $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getMontage(): ?string
    {
        return $this->montage;
    }

    public function setMontage(string $montage): self
    {
        $this->montage = $montage;

        return $this;
    }

    public function getFabricant(): ?string
    {
        return $this->fabricant;
    }

    public function setFabricant(string $fabricant): self
    {
        $this->fabricant = $fabricant;

        return $this;
    }

    public function isPresenceBalais(): ?bool
    {
        return $this->presence_balais;
    }

    public function setPresenceBalais(bool $presence_balais): self
    {
        $this->presence_balais = $presence_balais;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVitesse(): ?string
    {
        return $this->vitesse;
    }

    public function setVitesse(string $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getMasse(): ?float
    {
        return $this->masse;
    }

    public function setMasse(float $masse): self
    {
        $this->masse = $masse;

        return $this;
    }

    public function getTypePalier(): ?string
    {
        return $this->type_palier;
    }

    public function setTypePalier(string $type_palier): self
    {
        $this->type_palier = $type_palier;

        return $this;
    }

    public function isPresenceBalaisMasse(): ?bool
    {
        return $this->presence_balais_masse;
    }

    public function setPresenceBalaisMasse(bool $presence_balais_masse): self
    {
        $this->presence_balais_masse = $presence_balais_masse;

        return $this;
    }

    public function getStatorTension(): ?float
    {
        return $this->stator_tension;
    }

    public function setStatorTension(float $stator_tension): self
    {
        $this->stator_tension = $stator_tension;

        return $this;
    }

    public function getStatorFrequence(): ?float
    {
        return $this->stator_frequence;
    }

    public function setStatorFrequence(float $stator_frequence): self
    {
        $this->stator_frequence = $stator_frequence;

        return $this;
    }

    public function getStatorCourant(): ?string
    {
        return $this->stator_courant;
    }

    public function setStatorCourant(?string $stator_courant): self
    {
        $this->stator_courant = $stator_courant;

        return $this;
    }

    public function getStatorCouplage(): ?string
    {
        return $this->stator_couplage;
    }

    public function setStatorCouplage(?string $stator_couplage): self
    {
        $this->stator_couplage = $stator_couplage;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->date_arrivee;
    }

    public function setDateArrivee(?\DateTimeInterface $date_arrivee): self
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
    }

    public function getRotorTension(): ?float
    {
        return $this->rotor_tension;
    }

    public function setRotorTension(?float $rotor_tension): self
    {
        $this->rotor_tension = $rotor_tension;

        return $this;
    }

    public function getRotorExpertiseRefrigeant(): ?string
    {
        return $this->rotor_expertise_refrigeant;
    }

    public function setRotorExpertiseRefrigeant(?string $rotor_expertise_refrigeant): self
    {
        $this->rotor_expertise_refrigeant = $rotor_expertise_refrigeant;

        return $this;
    }

    public function getRotorCourant(): ?string
    {
        return $this->rotor_courant;
    }

    public function setRotorCourant(?string $rotor_courant): self
    {
        $this->rotor_courant = $rotor_courant;

        return $this;
    }

    public function isPresencePlans(): ?bool
    {
        return $this->presence_plans;
    }

    public function setPresencePlans(?bool $presence_plans): self
    {
        $this->presence_plans = $presence_plans;

        return $this;
    }

    public function getAffaire(): ?Affaire
    {
        return $this->affaire;
    }

    public function setAffaire(?Affaire $affaire): self
    {
        $this->affaire = $affaire;

        return $this;
    }

    public function getControleVisuelElectrique(): ?ControleVisuelElectrique
    {
        return $this->controleVisuelElectrique;
    }

    public function setControleVisuelElectrique(?ControleVisuelElectrique $controleVisuelElectrique): self
    {
        $this->controleVisuelElectrique = $controleVisuelElectrique;

        return $this;
    }

    public function getMesureVibratoire(): ?MesureVibratoire
    {
        return $this->mesure_vibratoire;
    }

    public function setMesureVibratoire(?MesureVibratoire $mesure_vibratoire): self
    {
        $this->mesure_vibratoire = $mesure_vibratoire;

        return $this;
    }

    public function getControleBobinage(): ?ControleBobinage
    {
        return $this->controleBobinage;
    }

    public function setControleBobinage(?ControleBobinage $controleBobinage): self
    {
        $this->controleBobinage = $controleBobinage;

        return $this;
    }

    public function getAutreControle(): ?AutreControle
    {
        return $this->autre_controle;
    }

    public function setAutreControle(?AutreControle $autre_controle): self
    {
        $this->autre_controle = $autre_controle;

        return $this;
    }

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesure>
     */
    public function getAppareilMesures(): Collection
    {
        return $this->appareilMesures;
    }

    public function addAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if (!$this->appareilMesures->contains($appareilMesure)) {
            $this->appareilMesures->add($appareilMesure);
            $appareilMesure->setParametre($this);
        }

        return $this;
    }

    public function removeAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if ($this->appareilMesures->removeElement($appareilMesure)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesure->getParametre() === $this) {
                $appareilMesure->setParametre(null);
            }
        }

        return $this;
    }

    public function getMesureIsolement(): ?MesureIsolement
    {
        return $this->mesure_isolement;
    }

    public function setMesureIsolement(?MesureIsolement $mesure_isolement): self
    {
        $this->mesure_isolement = $mesure_isolement;

        return $this;
    }

    public function getMesureResistance(): ?MesureResistance
    {
        return $this->mesure_resistance;
    }

    public function setMesureResistance(?MesureResistance $mesure_resistance): self
    {
        $this->mesure_resistance = $mesure_resistance;

        return $this;
    }

    /**
     * @return Collection<int, PointFonctionnement>
     */
    public function getPointFonctionnements(): Collection
    {
        return $this->pointFonctionnements;
    }

    public function addPointFonctionnement(PointFonctionnement $pointFonctionnement): self
    {
        if (!$this->pointFonctionnements->contains($pointFonctionnement)) {
            $this->pointFonctionnements->add($pointFonctionnement);
            $pointFonctionnement->setParametre($this);
        }

        return $this;
    }

    public function removePointFonctionnement(PointFonctionnement $pointFonctionnement): self
    {
        if ($this->pointFonctionnements->removeElement($pointFonctionnement)) {
            // set the owning side to null (unless already changed)
            if ($pointFonctionnement->getParametre() === $this) {
                $pointFonctionnement->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConstatElectrique>
     */
    public function getConstatElectriques(): Collection
    {
        return $this->constatElectriques;
    }

    public function addConstatElectrique(ConstatElectrique $constatElectrique): self
    {
        if (!$this->constatElectriques->contains($constatElectrique)) {
            $this->constatElectriques->add($constatElectrique);
            $constatElectrique->setParametre($this);
        }

        return $this;
    }

    public function removeConstatElectrique(ConstatElectrique $constatElectrique): self
    {
        if ($this->constatElectriques->removeElement($constatElectrique)) {
            // set the owning side to null (unless already changed)
            if ($constatElectrique->getParametre() === $this) {
                $constatElectrique->setParametre(null);
            }
        }

        return $this;
    }

    public function isExpertiseElectiqueAvantLavage(): ?bool
    {
        return $this->expertise_electique_avant_lavage;
    }

    public function setExpertiseElectiqueAvantLavage(?bool $expertise_electique_avant_lavage): self
    {
        $this->expertise_electique_avant_lavage = $expertise_electique_avant_lavage;

        return $this;
    }

    public function getControleVisuelMecanique(): ?ControleVisuelMecanique
    {
        return $this->controle_visuel_mecanique;
    }

    public function setControleVisuelMecanique(?ControleVisuelMecanique $controle_visuel_mecanique): self
    {
        $this->controle_visuel_mecanique = $controle_visuel_mecanique;

        return $this;
    }

    public function getControleMontageRoulement(): ?ControleMontageRoulement
    {
        return $this->controle_montage_roulement;
    }

    public function setControleMontageRoulement(?ControleMontageRoulement $controle_montage_roulement): self
    {
        $this->controle_montage_roulement = $controle_montage_roulement;

        return $this;
    }

    public function getControleMontageCoussinet(): ?ControleMontageConssinet
    {
        return $this->controle_montage_coussinet;
    }

    public function setControleMontageCoussinet(?ControleMontageConssinet $controle_montage_coussinet): self
    {
        $this->controle_montage_coussinet = $controle_montage_coussinet;

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureMecanique>
     */
    public function getAppareilMesureMecaniques(): Collection
    {
        return $this->appareilMesureMecaniques;
    }

    public function addAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if (!$this->appareilMesureMecaniques->contains($appareilMesureMecanique)) {
            $this->appareilMesureMecaniques->add($appareilMesureMecanique);
            $appareilMesureMecanique->setParametre($this);
        }

        return $this;
    }

    public function removeAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if ($this->appareilMesureMecaniques->removeElement($appareilMesureMecanique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureMecanique->getParametre() === $this) {
                $appareilMesureMecanique->setParametre(null);
            }
        }

        return $this;
    }

    public function getHydroAero(): ?HydroAero
    {
        return $this->hydro_aero;
    }

    public function setHydroAero(?HydroAero $hydro_aero): self
    {
        $this->hydro_aero = $hydro_aero;

        return $this;
    }

    /**
     * @return Collection<int, PhotoExpertiseMecanique>
     */
    public function getPhotoExpertiseMecaniques(): Collection
    {
        return $this->photoExpertiseMecaniques;
    }

    public function addPhotoExpertiseMecanique(PhotoExpertiseMecanique $photoExpertiseMecanique): self
    {
        if (!$this->photoExpertiseMecaniques->contains($photoExpertiseMecanique)) {
            $this->photoExpertiseMecaniques->add($photoExpertiseMecanique);
            $photoExpertiseMecanique->setParametre($this);
        }

        return $this;
    }

    public function removePhotoExpertiseMecanique(PhotoExpertiseMecanique $photoExpertiseMecanique): self
    {
        if ($this->photoExpertiseMecaniques->removeElement($photoExpertiseMecanique)) {
            // set the owning side to null (unless already changed)
            if ($photoExpertiseMecanique->getParametre() === $this) {
                $photoExpertiseMecanique->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConstatMecanique>
     */
    public function getConstatMecaniques(): Collection
    {
        return $this->constatMecaniques;
    }

    public function addConstatMecanique(ConstatMecanique $constatMecanique): self
    {
        if (!$this->constatMecaniques->contains($constatMecanique)) {
            $this->constatMecaniques->add($constatMecanique);
            $constatMecanique->setParametre($this);
        }

        return $this;
    }

    public function removeConstatMecanique(ConstatMecanique $constatMecanique): self
    {
        if ($this->constatMecaniques->removeElement($constatMecanique)) {
            // set the owning side to null (unless already changed)
            if ($constatMecanique->getParametre() === $this) {
                $constatMecanique->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReleveDimmensionnel>
     */
    public function getReleveDimmensionnels(): Collection
    {
        return $this->releveDimmensionnels;
    }

    public function addReleveDimmensionnel(ReleveDimmensionnel $releveDimmensionnel): self
    {
        if (!$this->releveDimmensionnels->contains($releveDimmensionnel)) {
            $this->releveDimmensionnels->add($releveDimmensionnel);
            $releveDimmensionnel->setParametre($this);
        }

        return $this;
    }

    public function removeReleveDimmensionnel(ReleveDimmensionnel $releveDimmensionnel): self
    {
        if ($this->releveDimmensionnels->removeElement($releveDimmensionnel)) {
            // set the owning side to null (unless already changed)
            if ($releveDimmensionnel->getParametre() === $this) {
                $releveDimmensionnel->setParametre(null);
            }
        }

        return $this;
    }

    public function isExpertiseMecanique(): ?bool
    {
        return $this->expertise_mecanique;
    }

    public function setExpertiseMecanique(?bool $expertise_mecanique): self
    {
        $this->expertise_mecanique = $expertise_mecanique;

        return $this;
    }

    public function getStatorApresLavage(): ?StatorApresLavage
    {
        return $this->stator_apres_lavage;
    }

    public function setStatorApresLavage(?StatorApresLavage $stator_apres_lavage): self
    {
        $this->stator_apres_lavage = $stator_apres_lavage;

        return $this;
    }

    public function getSondeBobinage(): ?SondeBobinage
    {
        return $this->sonde_bobinage;
    }

    public function setSondeBobinage(?SondeBobinage $sonde_bobinage): self
    {
        $this->sonde_bobinage = $sonde_bobinage;

        return $this;
    }

    /**
     * @return Collection<int, Caracteristique>
     */
    public function getCaracteristiques(): Collection
    {
        return $this->caracteristiques;
    }

    public function addCaracteristique(Caracteristique $caracteristique): self
    {
        if (!$this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques->add($caracteristique);
            $caracteristique->setParametre($this);
        }

        return $this;
    }

    public function removeCaracteristique(Caracteristique $caracteristique): self
    {
        if ($this->caracteristiques->removeElement($caracteristique)) {
            // set the owning side to null (unless already changed)
            if ($caracteristique->getParametre() === $this) {
                $caracteristique->setParametre(null);
            }
        }

        return $this;
    }

    public function getAutreCaracteristique(): ?AutreCaracteristique
    {
        return $this->autre_caracteristique;
    }

    public function setAutreCaracteristique(?AutreCaracteristique $autre_caracteristique): self
    {
        $this->autre_caracteristique = $autre_caracteristique;

        return $this;
    }

    /**
     * @return Collection<int, PointFonctionnementRotor>
     */
    public function getPointFonctionnementRotors(): Collection
    {
        return $this->pointFonctionnementRotors;
    }

    public function addPointFonctionnementRotor(PointFonctionnementRotor $pointFonctionnementRotor): self
    {
        if (!$this->pointFonctionnementRotors->contains($pointFonctionnementRotor)) {
            $this->pointFonctionnementRotors->add($pointFonctionnementRotor);
            $pointFonctionnementRotor->setParametre($this);
        }

        return $this;
    }

    public function removePointFonctionnementRotor(PointFonctionnementRotor $pointFonctionnementRotor): self
    {
        if ($this->pointFonctionnementRotors->removeElement($pointFonctionnementRotor)) {
            // set the owning side to null (unless already changed)
            if ($pointFonctionnementRotor->getParametre() === $this) {
                $pointFonctionnementRotor->setParametre(null);
            }
        }

        return $this;
    }

    public function getAutrePointFonctionnementRotor(): ?AutrePointFonctionnementRotor
    {
        return $this->autre_point_fonctionnement_rotor;
    }

    public function setAutrePointFonctionnementRotor(?AutrePointFonctionnementRotor $autre_point_fonctionnement_rotor): self
    {
        $this->autre_point_fonctionnement_rotor = $autre_point_fonctionnement_rotor;

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureElectrique>
     */
    public function getAppareilMesureElectriques(): Collection
    {
        return $this->appareilMesureElectriques;
    }

    public function addAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if (!$this->appareilMesureElectriques->contains($appareilMesureElectrique)) {
            $this->appareilMesureElectriques->add($appareilMesureElectrique);
            $appareilMesureElectrique->setParametre($this);
        }

        return $this;
    }

    public function removeAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if ($this->appareilMesureElectriques->removeElement($appareilMesureElectrique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureElectrique->getParametre() === $this) {
                $appareilMesureElectrique->setParametre(null);
            }
        }

        return $this;
    }

    public function isExpertiseElectiqueApresLavage(): ?bool
    {
        return $this->expertise_electique_apres_lavage;
    }

    public function setExpertiseElectiqueApresLavage(?bool $expertise_electique_apres_lavage): self
    {
        $this->expertise_electique_apres_lavage = $expertise_electique_apres_lavage;

        return $this;
    }

    /**
     * @return Collection<int, ConstatElectriqueApresLavage>
     */
    public function getConstatElectriqueApresLavages(): Collection
    {
        return $this->constatElectriqueApresLavages;
    }

    public function addConstatElectriqueApresLavage(ConstatElectriqueApresLavage $constatElectriqueApresLavage): self
    {
        if (!$this->constatElectriqueApresLavages->contains($constatElectriqueApresLavage)) {
            $this->constatElectriqueApresLavages->add($constatElectriqueApresLavage);
            $constatElectriqueApresLavage->setParametre($this);
        }

        return $this;
    }

    public function removeConstatElectriqueApresLavage(ConstatElectriqueApresLavage $constatElectriqueApresLavage): self
    {
        if ($this->constatElectriqueApresLavages->removeElement($constatElectriqueApresLavage)) {
            // set the owning side to null (unless already changed)
            if ($constatElectriqueApresLavage->getParametre() === $this) {
                $constatElectriqueApresLavage->setParametre(null);
            }
        }

        return $this;
    }

    public function getRemontagePalier(): ?RemontagePalier
    {
        return $this->remontage_palier;
    }

    public function setRemontagePalier(?RemontagePalier $remontage_palier): self
    {
        $this->remontage_palier = $remontage_palier;

        return $this;
    }

    public function getRemontageEquilibrage(): ?RemontageEquilibrage
    {
        return $this->remontage_equilibrage;
    }

    public function setRemontageEquilibrage(?RemontageEquilibrage $remontage_equilibrage): self
    {
        $this->remontage_equilibrage = $remontage_equilibrage;

        return $this;
    }

    /**
     * @return Collection<int, RemontagePhoto>
     */
    public function getRemontagePhotos(): Collection
    {
        return $this->remontagePhotos;
    }

    public function addRemontagePhoto(RemontagePhoto $remontagePhoto): self
    {
        if (!$this->remontagePhotos->contains($remontagePhoto)) {
            $this->remontagePhotos->add($remontagePhoto);
            $remontagePhoto->setParametre($this);
        }

        return $this;
    }

    public function removeRemontagePhoto(RemontagePhoto $remontagePhoto): self
    {
        if ($this->remontagePhotos->removeElement($remontagePhoto)) {
            // set the owning side to null (unless already changed)
            if ($remontagePhoto->getParametre() === $this) {
                $remontagePhoto->setParametre(null);
            }
        }

        return $this;
    }

    public function isRemontage(): ?bool
    {
        return $this->remontage;
    }

    public function setRemontage(?bool $remontage): self
    {
        $this->remontage = $remontage;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getRemontageFinition(): ?RemontageFinition
    {
        return $this->remontage_finition;
    }

    public function setRemontageFinition(?RemontageFinition $remontage_finition): self
    {
        $this->remontage_finition = $remontage_finition;

        return $this;
    }

    public function isStatutFinal(): ?bool
    {
        return $this->statut_final;
    }

    public function setStatutFinal(?bool $statut_final): self
    {
        $this->statut_final = $statut_final;

        return $this;
    }

    public function getCritere(): ?float
    {
        return $this->critere;
    }

    public function setCritere(?float $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function isCorbeille(): ?bool
    {
        return $this->corbeille;
    }

    public function setCorbeille(?bool $corbeille): self
    {
        $this->corbeille = $corbeille;

        return $this;
    }

    /**
     * @return Collection<int, ControleRecensement>
     */
    public function getControleRecensements(): Collection
    {
        return $this->controleRecensements;
    }

    public function addControleRecensement(ControleRecensement $controleRecensement): self
    {
        if (!$this->controleRecensements->contains($controleRecensement)) {
            $this->controleRecensements->add($controleRecensement);
            $controleRecensement->setParametre($this);
        }

        return $this;
    }

    public function removeControleRecensement(ControleRecensement $controleRecensement): self
    {
        if ($this->controleRecensements->removeElement($controleRecensement)) {
            // set the owning side to null (unless already changed)
            if ($controleRecensement->getParametre() === $this) {
                $controleRecensement->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plaque>
     */
    public function getPlaques(): Collection
    {
        return $this->plaques;
    }

    public function addPlaque(Plaque $plaque): self
    {
        if (!$this->plaques->contains($plaque)) {
            $this->plaques->add($plaque);
            $plaque->setParametre($this);
        }

        return $this;
    }

    public function removePlaque(Plaque $plaque): self
    {
        if ($this->plaques->removeElement($plaque)) {
            // set the owning side to null (unless already changed)
            if ($plaque->getParametre() === $this) {
                $plaque->setParametre(null);
            }
        }

        return $this;
    }

    public function getCoussinet(): ?Coussinet
    {
        return $this->coussinet;
    }

    public function setCoussinet(?Coussinet $coussinet): self
    {
        $this->coussinet = $coussinet;

        return $this;
    }

    public function getContreExpertise(): ?ContreExpertise
    {
        return $this->contre_expertise;
    }

    public function setContreExpertise(?ContreExpertise $contre_expertise): self
    {
        $this->contre_expertise = $contre_expertise;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Phototheque>
     */
    public function getPhototheques(): Collection
    {
        return $this->phototheques;
    }

    public function addPhototheque(Phototheque $phototheque): self
    {
        if (!$this->phototheques->contains($phototheque)) {
            $this->phototheques->add($phototheque);
            $phototheque->setParametre($this);
        }

        return $this;
    }

    public function removePhototheque(Phototheque $phototheque): self
    {
        if ($this->phototheques->removeElement($phototheque)) {
            // set the owning side to null (unless already changed)
            if ($phototheque->getParametre() === $this) {
                $phototheque->setParametre(null);
            }
        }

        return $this;
    }

    public function getLplaque(): ?LPlaque
    {
        return $this->lplaque;
    }

    public function setLplaque(?LPlaque $lplaque): self
    {
        $this->lplaque = $lplaque;

        return $this;
    }

    public function getRoulement(): ?Roulement
    {
        return $this->roulement;
    }

    public function setRoulement(?Roulement $roulement): self
    {
        $this->roulement = $roulement;

        return $this;
    }

    /**
     * @return Collection<int, Synoptique>
     */
    public function getSynoptiques(): Collection
    {
        return $this->synoptiques;
    }

    public function addSynoptique(Synoptique $synoptique): self
    {
        if (!$this->synoptiques->contains($synoptique)) {
            $this->synoptiques->add($synoptique);
            $synoptique->setParametre($this);
        }

        return $this;
    }

    public function removeSynoptique(Synoptique $synoptique): self
    {
        if ($this->synoptiques->removeElement($synoptique)) {
            // set the owning side to null (unless already changed)
            if ($synoptique->getParametre() === $this) {
                $synoptique->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ControleGeometrique>
     */
    public function getControleGeometriques(): Collection
    {
        return $this->controleGeometriques;
    }

    public function addControleGeometrique(ControleGeometrique $controleGeometrique): static
    {
        if (!$this->controleGeometriques->contains($controleGeometrique)) {
            $this->controleGeometriques->add($controleGeometrique);
            $controleGeometrique->setParametre($this);
        }

        return $this;
    }

    public function removeControleGeometrique(ControleGeometrique $controleGeometrique): static
    {
        if ($this->controleGeometriques->removeElement($controleGeometrique)) {
            // set the owning side to null (unless already changed)
            if ($controleGeometrique->getParametre() === $this) {
                $controleGeometrique->setParametre(null);
            }
        }

        return $this;
    }

    public function getTempCorrection(): ?float
    {
        return $this->temp_correction;
    }

    public function setTempCorrection(?float $temp_correction): static
    {
        $this->temp_correction = $temp_correction;

        return $this;
    }

    public function isEssaisFinaux(): ?bool
    {
        return $this->essais_finaux;
    }

    public function setEssaisFinaux(?bool $essais_finaux): static
    {
        $this->essais_finaux = $essais_finaux;

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureEssais>
     */
    public function getAppareilMesureEssais(): Collection
    {
        return $this->appareilMesureEssais;
    }

    public function addAppareilMesureEssai(AppareilMesureEssais $appareilMesureEssai): static
    {
        if (!$this->appareilMesureEssais->contains($appareilMesureEssai)) {
            $this->appareilMesureEssais->add($appareilMesureEssai);
            $appareilMesureEssai->setParametre($this);
        }

        return $this;
    }

    public function removeAppareilMesureEssai(AppareilMesureEssais $appareilMesureEssai): static
    {
        if ($this->appareilMesureEssais->removeElement($appareilMesureEssai)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureEssai->getParametre() === $this) {
                $appareilMesureEssai->setParametre(null);
            }
        }

        return $this;
    }

    public function getMesureVibratoireEssais(): ?MesureVibratoireEssais
    {
        return $this->mesure_vibratoire_essais;
    }

    public function setMesureVibratoireEssais(?MesureVibratoireEssais $mesure_vibratoire_essais): static
    {
        $this->mesure_vibratoire_essais = $mesure_vibratoire_essais;

        return $this;
    }

    /**
     * @return Collection<int, PointFonctionnementVide>
     */
    public function getPointFonctionnementVides(): Collection
    {
        return $this->pointFonctionnementVides;
    }

    public function addPointFonctionnementVide(PointFonctionnementVide $pointFonctionnementVide): static
    {
        if (!$this->pointFonctionnementVides->contains($pointFonctionnementVide)) {
            $this->pointFonctionnementVides->add($pointFonctionnementVide);
            $pointFonctionnementVide->setParametre($this);
        }

        return $this;
    }

    public function removePointFonctionnementVide(PointFonctionnementVide $pointFonctionnementVide): static
    {
        if ($this->pointFonctionnementVides->removeElement($pointFonctionnementVide)) {
            // set the owning side to null (unless already changed)
            if ($pointFonctionnementVide->getParametre() === $this) {
                $pointFonctionnementVide->setParametre(null);
            }
        }

        return $this;
    }

    public function getMesureIsolementEssai(): ?MesureIsolementEssai
    {
        return $this->mesure_isolement_essai;
    }

    public function setMesureIsolementEssai(?MesureIsolementEssai $mesure_isolement_essai): static
    {
        $this->mesure_isolement_essai = $mesure_isolement_essai;

        return $this;
    }

    public function getMesureResistanceEssai(): ?MesureResistanceEssai
    {
        return $this->mesure_resistance_essai;
    }

    public function setMesureResistanceEssai(?MesureResistanceEssai $mesure_resistance_essai): static
    {
        $this->mesure_resistance_essai = $mesure_resistance_essai;

        return $this;
    }

    public function getStatorTension2(): ?float
    {
        return $this->stator_tension2;
    }

    public function setStatorTension2(?float $stator_tension2): static
    {
        $this->stator_tension2 = $stator_tension2;

        return $this;
    }

    public function getRotorTension2(): ?float
    {
        return $this->rotor_tension2;
    }

    public function setRotorTension2(?float $rotor_tension2): static
    {
        $this->rotor_tension2 = $rotor_tension2;

        return $this;
    }

    public function getInfoGenerale(): ?InfoGenerale
    {
        return $this->info_generale;
    }

    public function setInfoGenerale(?InfoGenerale $info_generale): static
    {
        $this->info_generale = $info_generale;
        return $this;
    }

    /**
     * @return Collection<int, PhotoRotor>
     */
    public function getPhotoRotors(): Collection
    {
        return $this->photoRotors;
    }

    public function addPhotoRotor(PhotoRotor $photoRotor): static
    {
        if (!$this->photoRotors->contains($photoRotor)) {
            $this->photoRotors->add($photoRotor);
            $photoRotor->setParametre($this);
        }

        return $this;
    }

    public function removePhotoRotor(PhotoRotor $photoRotor): static
    {
        if ($this->photoRotors->removeElement($photoRotor)) {
            // set the owning side to null (unless already changed)
            if ($photoRotor->getParametre() === $this) {
                $photoRotor->setParametre(null);
            }
        }

        return $this;
    }

    public function getEssaisPlateforme(): ?string
    {
        return $this->essais_plateforme;
    }

    public function setEssaisPlateforme(?string $essais_plateforme): static
    {
        $this->essais_plateforme = $essais_plateforme;

        return $this;
    }

    public function getStatorCourantExcitation(): ?float
    {
        return $this->stator_courant_excitation;
    }

    public function setStatorCourantExcitation(?float $stator_courant_excitation): static
    {
        $this->stator_courant_excitation = $stator_courant_excitation;

        return $this;
    }

    /**
     * @return Collection<int, Equirepartition>
     */
    public function getEquirepartitions(): Collection
    {
        return $this->equirepartitions;
    }

    public function addEquirepartition(Equirepartition $equirepartition): static
    {
        if (!$this->equirepartitions->contains($equirepartition)) {
            $this->equirepartitions->add($equirepartition);
            $equirepartition->setParametre($this);
        }

        return $this;
    }

    public function removeEquirepartition(Equirepartition $equirepartition): static
    {
        if ($this->equirepartitions->removeElement($equirepartition)) {
            // set the owning side to null (unless already changed)
            if ($equirepartition->getParametre() === $this) {
                $equirepartition->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PontDiode>
     */
    public function getPontDiodes(): Collection
    {
        return $this->pontDiodes;
    }

    public function addPontDiode(PontDiode $pontDiode): static
    {
        if (!$this->pontDiodes->contains($pontDiode)) {
            $this->pontDiodes->add($pontDiode);
            $pontDiode->setParametre($this);
        }

        return $this;
    }

    public function removePontDiode(PontDiode $pontDiode): static
    {
        if ($this->pontDiodes->removeElement($pontDiode)) {
            // set the owning side to null (unless already changed)
            if ($pontDiode->getParametre() === $this) {
                $pontDiode->setParametre(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    /**
     * @return Collection<int, BoiteBorne>
     */
    public function getBoiteBornes(): Collection
    {
        return $this->boiteBornes;
    }

    public function addBoiteBorne(BoiteBorne $boiteBorne): static
    {
        if (!$this->boiteBornes->contains($boiteBorne)) {
            $this->boiteBornes->add($boiteBorne);
            $boiteBorne->setParametre($this);
        }

        return $this;
    }

    public function removeBoiteBorne(BoiteBorne $boiteBorne): static
    {
        if ($this->boiteBornes->removeElement($boiteBorne)) {
            // set the owning side to null (unless already changed)
            if ($boiteBorne->getParametre() === $this) {
                $boiteBorne->setParametre(null);
            }
        }

        return $this;
    }

    public function getNumeroQualite(): ?string
    {
        return $this->numero_qualite;
    }

    public function setNumeroQualite(?string $numero_qualite): static
    {
        $this->numero_qualite = $numero_qualite;

        return $this;
    }

    public function getImagePlan(): ?ImagePlan
    {
        return $this->imagePlan;
    }

    public function setImagePlan(?ImagePlan $imagePlan): static
    {
        // unset the owning side of the relation if necessary
        if ($imagePlan === null && $this->imagePlan !== null) {
            $this->imagePlan->setParametre(null);
        }

        // set the owning side of the relation if necessary
        if ($imagePlan !== null && $imagePlan->getParametre() !== $this) {
            $imagePlan->setParametre($this);
        }

        $this->imagePlan = $imagePlan;

        return $this;
    }

    /**
     * @return Collection<int, PressionBalais>
     */
    public function getPressionBalais(): Collection
    {
        return $this->pressionBalais;
    }

    public function addPressionBalai(PressionBalais $pressionBalai): static
    {
        if (!$this->pressionBalais->contains($pressionBalai)) {
            $this->pressionBalais->add($pressionBalai);
            $pressionBalai->setParametre($this);
        }

        return $this;
    }

    public function removePressionBalai(PressionBalais $pressionBalai): static
    {
        if ($this->pressionBalais->removeElement($pressionBalai)) {
            // set the owning side to null (unless already changed)
            if ($pressionBalai->getParametre() === $this) {
                $pressionBalai->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PressionMasseBalais>
     */
    public function getPressionMasseBalais(): Collection
    {
        return $this->pressionMasseBalais;
    }

    public function addPressionMasseBalai(PressionMasseBalais $pressionMasseBalai): static
    {
        if (!$this->pressionMasseBalais->contains($pressionMasseBalai)) {
            $this->pressionMasseBalais->add($pressionMasseBalai);
            $pressionMasseBalai->setParametre($this);
        }

        return $this;
    }

    public function removePressionMasseBalai(PressionMasseBalais $pressionMasseBalai): static
    {
        if ($this->pressionMasseBalais->removeElement($pressionMasseBalai)) {
            // set the owning side to null (unless already changed)
            if ($pressionMasseBalai->getParametre() === $this) {
                $pressionMasseBalai->setParametre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PressionPorteBalais>
     */
    public function getPressionPorteBalais(): Collection
    {
        return $this->pressionPorteBalais;
    }

    public function addPressionPorteBalai(PressionPorteBalais $pressionPorteBalai): static
    {
        if (!$this->pressionPorteBalais->contains($pressionPorteBalai)) {
            $this->pressionPorteBalais->add($pressionPorteBalai);
            $pressionPorteBalai->setParametre($this);
        }

        return $this;
    }

    public function removePressionPorteBalai(PressionPorteBalais $pressionPorteBalai): static
    {
        if ($this->pressionPorteBalais->removeElement($pressionPorteBalai)) {
            // set the owning side to null (unless already changed)
            if ($pressionPorteBalai->getParametre() === $this) {
                $pressionPorteBalai->setParametre(null);
            }
        }

        return $this;
    }

    public function getSignature(): ?Signature
    {
        return $this->signature;
    }

    public function setSignature(?Signature $signature): static
    {
        // unset the owning side of the relation if necessary
        if ($signature === null && $this->signature !== null) {
            $this->signature->setParametre(null);
        }

        // set the owning side of the relation if necessary
        if ($signature !== null && $signature->getParametre() !== $this) {
            $signature->setParametre($this);
        }

        $this->signature = $signature;

        return $this;
    }

}
