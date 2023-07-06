<?php

namespace App\Entity;

use App\Repository\RoulementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoulementRepository::class)]
class Roulement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_ca = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_coa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $graisse_ca = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $graisse_coa = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'roulement', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCa(): ?string
    {
        return $this->type_ca;
    }

    public function setTypeCa(?string $type_ca): self
    {
        $this->type_ca = $type_ca;

        return $this;
    }

    public function getTypeCoa(): ?string
    {
        return $this->type_coa;
    }

    public function setTypeCoa(?string $type_coa): self
    {
        $this->type_coa = $type_coa;

        return $this;
    }

    public function getGraisseCa(): ?string
    {
        return $this->graisse_ca;
    }

    public function setGraisseCa(?string $graisse_ca): self
    {
        $this->graisse_ca = $graisse_ca;

        return $this;
    }

    public function getGraisseCoa(): ?string
    {
        return $this->graisse_coa;
    }

    public function setGraisseCoa(?string $graisse_coa): self
    {
        $this->graisse_coa = $graisse_coa;

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
            $this->parametre->setRoulement(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getRoulement() !== $this) {
            $parametre->setRoulement($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
