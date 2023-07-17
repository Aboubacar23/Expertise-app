<?php

namespace App\Entity;

use App\Repository\ControleVisuelMecaniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleVisuelMecaniqueRepository::class)]
class ControleVisuelMecanique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $bridage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $chassis = null;

    #[ORM\Column(nullable: true)]
    private ?bool $boite_borne = null;

    #[ORM\Column(nullable: true)]
    private ?bool $barrette_neutre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_rotor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference_stator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $peinture = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vis_verins = null;

    #[ORM\Column(nullable: true)]
    private ?bool $tresse_masse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $clavette = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sonde_palier_ca = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sonde_palier_coa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $autres_sondes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_serie = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_accessoire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position_accouplement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controle_visuel_mecanique', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'controle_visuel_mecanique', targetEntity: AccessoireSupplementaire::class)]
    private Collection $accessoireSupplementaires;

    #[ORM\Column(nullable: true)]
    private ?bool $phase_neutre = null;

    public function __construct()
    {
        $this->accessoireSupplementaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isBridage(): ?bool
    {
        return $this->bridage;
    }

    public function setBridage(bool $bridage): self
    {
        $this->bridage = $bridage;

        return $this;
    }

    public function isChassis(): ?bool
    {
        return $this->chassis;
    }

    public function setChassis(?bool $chassis): self
    {
        $this->chassis = $chassis;

        return $this;
    }

    public function isBoiteBorne(): ?bool
    {
        return $this->boite_borne;
    }

    public function setBoiteBorne(?bool $boite_borne): self
    {
        $this->boite_borne = $boite_borne;

        return $this;
    }

    public function isBarretteNeutre(): ?bool
    {
        return $this->barrette_neutre;
    }

    public function setBarretteNeutre(?bool $barrette_neutre): self
    {
        $this->barrette_neutre = $barrette_neutre;

        return $this;
    }

    public function getReferenceRotor(): ?string
    {
        return $this->reference_rotor;
    }

    public function setReferenceRotor(?string $reference_rotor): self
    {
        $this->reference_rotor = $reference_rotor;

        return $this;
    }

    public function getReferenceStator(): ?string
    {
        return $this->reference_stator;
    }

    public function setReferenceStator(?string $reference_stator): self
    {
        $this->reference_stator = $reference_stator;

        return $this;
    }

    public function getPeinture(): ?string
    {
        return $this->peinture;
    }

    public function setPeinture(?string $peinture): self
    {
        $this->peinture = $peinture;

        return $this;
    }

    public function isVisVerins(): ?bool
    {
        return $this->vis_verins;
    }

    public function setVisVerins(?bool $vis_verins): self
    {
        $this->vis_verins = $vis_verins;

        return $this;
    }

    public function isTresseMasse(): ?bool
    {
        return $this->tresse_masse;
    }

    public function setTresseMasse(?bool $tresse_masse): self
    {
        $this->tresse_masse = $tresse_masse;

        return $this;
    }

    public function isClavette(): ?bool
    {
        return $this->clavette;
    }

    public function setClavette(?bool $clavette): self
    {
        $this->clavette = $clavette;

        return $this;
    }

    public function getSondePalierCa(): ?string
    {
        return $this->sonde_palier_ca;
    }

    public function setSondePalierCa(?string $sonde_palier_ca): self
    {
        $this->sonde_palier_ca = $sonde_palier_ca;

        return $this;
    }

    public function getSondePalierCoa(): ?string
    {
        return $this->sonde_palier_coa;
    }

    public function setSondePalierCoa(?string $sonde_palier_coa): self
    {
        $this->sonde_palier_coa = $sonde_palier_coa;

        return $this;
    }

    public function getAutresSondes(): ?string
    {
        return $this->autres_sondes;
    }

    public function setAutresSondes(?string $autres_sondes): self
    {
        $this->autres_sondes = $autres_sondes;

        return $this;
    }

    public function getNumeroSerie(): ?string
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie(?string $numero_serie): self
    {
        $this->numero_serie = $numero_serie;

        return $this;
    }

    public function getNombreAccessoire(): ?int
    {
        return $this->nombre_accessoire;
    }

    public function setNombreAccessoire(?int $nombre_accessoire): self
    {
        $this->nombre_accessoire = $nombre_accessoire;

        return $this;
    }

    public function getAccouplement(): ?string
    {
        return $this->accouplement;
    }

    public function setAccouplement(?string $accouplement): self
    {
        $this->accouplement = $accouplement;

        return $this;
    }

    public function getPositionAccouplement(): ?string
    {
        return $this->position_accouplement;
    }

    public function setPositionAccouplement(?string $position_accouplement): self
    {
        $this->position_accouplement = $position_accouplement;

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

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setControleVisuelMecanique(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleVisuelMecanique() !== $this) {
            $parametre->setControleVisuelMecanique($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, AccessoireSupplementaire>
     */
    public function getAccessoireSupplementaires(): Collection
    {
        return $this->accessoireSupplementaires;
    }

    public function addAccessoireSupplementaire(AccessoireSupplementaire $accessoireSupplementaire): self
    {
        if (!$this->accessoireSupplementaires->contains($accessoireSupplementaire)) {
            $this->accessoireSupplementaires->add($accessoireSupplementaire);
            $accessoireSupplementaire->setControleVisuelMecanique($this);
        }

        return $this;
    }

    public function removeAccessoireSupplementaire(AccessoireSupplementaire $accessoireSupplementaire): self
    {
        if ($this->accessoireSupplementaires->removeElement($accessoireSupplementaire)) {
            // set the owning side to null (unless already changed)
            if ($accessoireSupplementaire->getControleVisuelMecanique() === $this) {
                $accessoireSupplementaire->setControleVisuelMecanique(null);
            }
        }

        return $this;
    }

    public function isPhaseNeutre(): ?bool
    {
        return $this->phase_neutre;
    }

    public function setPhaseNeutre(?bool $phase_neutre): static
    {
        $this->phase_neutre = $phase_neutre;

        return $this;
    }
}
