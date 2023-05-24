<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
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

}
