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

    #[ORM\Column]
    private ?float $puissance = null;

    #[ORM\Column(length: 255)]
    private ?string $montage = null;

    #[ORM\Column(length: 255)]
    private ?string $fabricant = null;

    #[ORM\Column]
    private ?bool $presence_balais = null;

    #[ORM\ManyToOne(inversedBy: 'parametres')]
    private ?Type $type = null;

    #[ORM\Column]
    private ?float $vitesse = null;

    #[ORM\Column]
    private ?float $masse = null;

    #[ORM\Column(length: 255)]
    private ?string $type_palier = null;

    #[ORM\Column]
    private ?bool $presence_balais_masse = null;

    #[ORM\Column]
    private ?float $stator_tension = null;

    #[ORM\Column]
    private ?float $stator_frequence = null;

    #[ORM\Column(nullable: true)]
    private ?float $stator_courant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stator_couplage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_arrivee = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_tension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rotor_expertise_refrigeant = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_courant = null;

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

    #[ORM\OneToOne(inversedBy: 'parametre', cascade: ['persist', 'remove'])]
    private ?ControleGeometrique $controle_geometrique = null;

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

    public function __construct()
    {
        $this->appareilMesures = new ArrayCollection();
        $this->pointFonctionnements = new ArrayCollection();
        $this->constatElectriques = new ArrayCollection();
        $this->appareilMesureMecaniques = new ArrayCollection();
        $this->photoExpertiseMecaniques = new ArrayCollection();
        $this->constatMecaniques = new ArrayCollection();
        $this->releveDimmensionnels = new ArrayCollection();
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

    public function getPuissance(): ?float
    {
        return $this->puissance;
    }

    public function setPuissance(float $puissance): self
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

    public function getVitesse(): ?float
    {
        return $this->vitesse;
    }

    public function setVitesse(float $vitesse): self
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

    public function getStatorCourant(): ?float
    {
        return $this->stator_courant;
    }

    public function setStatorCourant(?float $stator_courant): self
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

    public function getRotorCourant(): ?float
    {
        return $this->rotor_courant;
    }

    public function setRotorCourant(?float $rotor_courant): self
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

    public function getControleGeometrique(): ?ControleGeometrique
    {
        return $this->controle_geometrique;
    }

    public function setControleGeometrique(?ControleGeometrique $controle_geometrique): self
    {
        $this->controle_geometrique = $controle_geometrique;

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

}
