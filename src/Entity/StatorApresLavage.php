<?php

namespace App\Entity;

use App\Repository\StatorApresLavageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatorApresLavageRepository::class)]
class StatorApresLavage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_ambiante = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_tolerie = null;

    #[ORM\Column(nullable: true)]
    private ?float $hygrometrie = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'stator_apres_lavage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'stator_apres_lavage', targetEntity: LStatorApresLavage::class)]
    private Collection $lStatorApresLavages;

    public function __construct()
    {
        $this->lStatorApresLavages = new ArrayCollection();
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
            $this->parametre->setStatorApresLavage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getStatorApresLavage() !== $this) {
            $parametre->setStatorApresLavage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, LStatorApresLavage>
     */
    public function getLStatorApresLavages(): Collection
    {
        return $this->lStatorApresLavages;
    }

    public function addLStatorApresLavage(LStatorApresLavage $lStatorApresLavage): self
    {
        if (!$this->lStatorApresLavages->contains($lStatorApresLavage)) {
            $this->lStatorApresLavages->add($lStatorApresLavage);
            $lStatorApresLavage->setStatorApresLavage($this);
        }

        return $this;
    }

    public function removeLStatorApresLavage(LStatorApresLavage $lStatorApresLavage): self
    {
        if ($this->lStatorApresLavages->removeElement($lStatorApresLavage)) {
            // set the owning side to null (unless already changed)
            if ($lStatorApresLavage->getStatorApresLavage() === $this) {
                $lStatorApresLavage->setStatorApresLavage(null);
            }
        }

        return $this;
    }
}
