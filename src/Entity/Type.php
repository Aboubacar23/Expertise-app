<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[UniqueEntity(fields: ['libelle'], message: "Il existe déjà ce type dans la base")]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

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

    #[ORM\Column]
    private ?float $stator_frequence = null;

    #[ORM\Column(nullable: true)]
    private ?string $stator_courant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stator_couplage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_arrivee = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_tension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rotor_expertise_refrigeant = null;

    #[ORM\Column(nullable: true)]
    private ?string $rotor_courant = null;
 
    #[ORM\Column(nullable: true)]
    private ?bool $presence_plans = null;

    #[ORM\Column(nullable: true)]
    private ?float $stator_tension2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $rotor_tension2 = null;
    
    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Parametre::class)]
    private Collection $parametres;

    #[ORM\ManyToOne(inversedBy: 'types')]
    private ?Machine $machine = null;

    public function __construct()
    {
        $this->parametres = new ArrayCollection(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Parametre>
     */
    public function getParametres(): Collection
    {
        return $this->parametres;
    }

    public function addParametre(Parametre $parametre): self
    {
        if (!$this->parametres->contains($parametre)) {
            $this->parametres->add($parametre);
            $parametre->setType($this);
        }

        return $this;
    }

    public function removeParametre(Parametre $parametre): self
    {
        if ($this->parametres->removeElement($parametre)) {
            // set the owning side to null (unless already changed)
            if ($parametre->getType() === $this) {
                $parametre->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
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

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): static
    {
        $this->machine = $machine;

        return $this;
    }

}
