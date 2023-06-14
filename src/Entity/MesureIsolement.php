<?php

namespace App\Entity;

use App\Repository\MesureIsolementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesureIsolementRepository::class)]
class MesureIsolement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $temp_ambiante = null;

    #[ORM\Column(nullable: true)]
    private ?int $temp_tolerie = null;

    #[ORM\Column(nullable: true)]
    private ?float $hygrometrie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_essais = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'mesure_isolement', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'mesure_isolement', targetEntity: LMesureIsolement::class)]
    private Collection $lMesureIsolements;

    public function __construct()
    {
        $this->lMesureIsolements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempAmbiante(): ?int
    {
        return $this->temp_ambiante;
    }

    public function setTempAmbiante(?int $temp_ambiante): self
    {
        $this->temp_ambiante = $temp_ambiante;

        return $this;
    }

    public function getTempTolerie(): ?int
    {
        return $this->temp_tolerie;
    }

    public function setTempTolerie(?int $temp_tolerie): self
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
            $this->parametre->setMesureIsolement(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureIsolement() !== $this) {
            $parametre->setMesureIsolement($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, LMesureIsolement>
     */
    public function getLMesureIsolements(): Collection
    {
        return $this->lMesureIsolements;
    }

    public function addLMesureIsolement(LMesureIsolement $lMesureIsolement): self
    {
        if (!$this->lMesureIsolements->contains($lMesureIsolement)) {
            $this->lMesureIsolements->add($lMesureIsolement);
            $lMesureIsolement->setMesureIsolement($this);
        }

        return $this;
    }

    public function removeLMesureIsolement(LMesureIsolement $lMesureIsolement): self
    {
        if ($this->lMesureIsolements->removeElement($lMesureIsolement)) {
            // set the owning side to null (unless already changed)
            if ($lMesureIsolement->getMesureIsolement() === $this) {
                $lMesureIsolement->setMesureIsolement(null);
            }
        }

        return $this;
    }
}
