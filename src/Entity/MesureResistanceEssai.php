<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\MesureResistanceEssaiRepository;

#[ORM\Entity(repositoryClass: MesureResistanceEssaiRepository::class)]
class MesureResistanceEssai
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;  
    
    #[ORM\Column]
    private ?float $temp_ambiante = null;

    #[ORM\Column]
    private ?float $temp_tolerie = null;

    #[ORM\Column]
    private ?float $hygrometrie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_essais = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null; 

    #[ORM\OneToMany(mappedBy: 'mesure_reistance_essai', targetEntity: LMesureResistanceEssai::class)]
    private Collection $lMesureResistanceEssais;

    #[ORM\OneToOne(mappedBy: 'mesure_resistance_essai', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function __construct()
    {
        $this->lMesureResistanceEssais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTempAmbiante(): ?float
    {
        return $this->temp_ambiante;
    }

    public function setTempAmbiante(?float $temp_ambiante): self
    {
        $this->temp_ambiante = $temp_ambiante;

        return $this;
    }

    public function getTempTolerie(): ?float
    {
        return $this->temp_tolerie;
    }

    public function setTempTolerie(?float $temp_tolerie): self
    {
        $this->temp_tolerie = $temp_tolerie;

        return $this;
    }

    public function getHygrometrie(): ?float
    {
        return $this->hygrometrie;
    }

    public function setHygrometrie(?float $hygrometrie): self
    {
        $this->hygrometrie = $hygrometrie;

        return $this;
    }

    public function getDateEssais(): ?\DateTimeInterface
    {
        return $this->date_essais;
    }

    public function setDateEssais(?\DateTimeInterface $date_essais): self
    {
        $this->date_essais = $date_essais;

        return $this;
    }
    
    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, LMesureResistanceEssai>
     */
    public function getLMesureResistanceEssais(): Collection
    {
        return $this->lMesureResistanceEssais;
    }

    public function addLMesureResistanceEssai(LMesureResistanceEssai $lMesureResistanceEssai): static
    {
        if (!$this->lMesureResistanceEssais->contains($lMesureResistanceEssai)) {
            $this->lMesureResistanceEssais->add($lMesureResistanceEssai);
            $lMesureResistanceEssai->setMesureReistanceEssai($this);
        }

        return $this;
    }

    public function removeLMesureResistanceEssai(LMesureResistanceEssai $lMesureResistanceEssai): static
    {
        if ($this->lMesureResistanceEssais->removeElement($lMesureResistanceEssai)) {
            // set the owning side to null (unless already changed)
            if ($lMesureResistanceEssai->getMesureReistanceEssai() === $this) {
                $lMesureResistanceEssai->setMesureReistanceEssai(null);
            }
        }

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setMesureResistanceEssai(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureResistanceEssai() !== $this) {
            $parametre->setMesureResistanceEssai($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
