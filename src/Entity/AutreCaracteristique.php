<?php

namespace App\Entity;

use App\Repository\AutreCaracteristiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutreCaracteristiqueRepository::class)]
class AutreCaracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column]
    private ?float $resistance = null;

    #[ORM\Column]
    private ?float $perte1 = null;

    #[ORM\Column]
    private ?float $perte2 = null;

    #[ORM\Column]
    private ?float $perte_fer1 = null;

    #[ORM\Column]
    private ?float $perte_fer2 = null;

    #[ORM\OneToOne(mappedBy: 'autre_caracteristique', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getResistance(): ?float
    {
        return $this->resistance;
    }

    public function setResistance(float $resistance): self
    {
        $this->resistance = $resistance;

        return $this;
    }

    public function getPerte1(): ?float
    {
        return $this->perte1;
    }

    public function setPerte1(float $perte1): self
    {
        $this->perte1 = $perte1;

        return $this;
    }

    public function getPerte2(): ?float
    {
        return $this->perte2;
    }

    public function setPerte2(float $perte2): self
    {
        $this->perte2 = $perte2;

        return $this;
    }

    public function getPerteFer1(): ?float
    {
        return $this->perte_fer1;
    }

    public function setPerteFer1(float $perte_fer1): self
    {
        $this->perte_fer1 = $perte_fer1;

        return $this;
    }

    public function getPerteFer2(): ?float
    {
        return $this->perte_fer2;
    }

    public function setPerteFer2(float $perte_fer2): self
    {
        $this->perte_fer2 = $perte_fer2;

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
            $this->parametre->setAutreCaracteristique(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getAutreCaracteristique() !== $this) {
            $parametre->setAutreCaracteristique($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
