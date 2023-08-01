<?php

namespace App\Entity;

use App\Repository\SondeBobinageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SondeBobinageRepository::class)]
class SondeBobinage
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

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'sonde_bobinage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'sonde_bobinage', targetEntity: LSondeBobinage::class)]
    private Collection $lSondeBobinages;

    public function __construct()
    {
        $this->lSondeBobinages = new ArrayCollection();
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
            $this->parametre->setSondeBobinage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getSondeBobinage() !== $this) {
            $parametre->setSondeBobinage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, LSondeBobinage>
     */
    public function getLSondeBobinages(): Collection
    {
        return $this->lSondeBobinages;
    }

    public function addLSondeBobinage(LSondeBobinage $lSondeBobinage): self
    {
        if (!$this->lSondeBobinages->contains($lSondeBobinage)) {
            $this->lSondeBobinages->add($lSondeBobinage);
            $lSondeBobinage->setSondeBobinage($this);
        }

        return $this;
    }

    public function removeLSondeBobinage(LSondeBobinage $lSondeBobinage): self
    {
        if ($this->lSondeBobinages->removeElement($lSondeBobinage)) {
            // set the owning side to null (unless already changed)
            if ($lSondeBobinage->getSondeBobinage() === $this) {
                $lSondeBobinage->setSondeBobinage(null);
            }
        }

        return $this;
    }
}
