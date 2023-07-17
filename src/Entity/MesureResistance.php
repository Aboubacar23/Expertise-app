<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MesureResistanceRepository;

#[ORM\Entity(repositoryClass: MesureResistanceRepository::class)]
class MesureResistance
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

    #[ORM\OneToOne(mappedBy: 'mesure_resistance', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'mesure_resistance', targetEntity: LMesureResistance::class)]
    private Collection $lMesureResistances;

    public function __construct()
    {
        $this->lMesureResistances = new ArrayCollection();
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
            $this->parametre->setMesureResistance(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureResistance() !== $this) {
            $parametre->setMesureResistance($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, LMesureResistance>
     */
    public function getLMesureResistances(): Collection
    {
        return $this->lMesureResistances;
    }

    public function addLMesureResistance(LMesureResistance $lMesureResistance): self
    {
        if (!$this->lMesureResistances->contains($lMesureResistance)) {
            $this->lMesureResistances->add($lMesureResistance);
            $lMesureResistance->setMesureResistance($this);
        }

        return $this;
    }

    public function removeLMesureResistance(LMesureResistance $lMesureResistance): self
    {
        if ($this->lMesureResistances->removeElement($lMesureResistance)) {
            // set the owning side to null (unless already changed)
            if ($lMesureResistance->getMesureResistance() === $this) {
                $lMesureResistance->setMesureResistance(null);
            }
        }

        return $this;
    }
}
