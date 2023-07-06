<?php

namespace App\Entity;

use App\Repository\LPlaqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LPlaqueRepository::class)]
class LPlaque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $classe_isolation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $indice_protection = null;

    #[ORM\OneToOne(mappedBy: 'lplaque', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getClasseIsolation(): ?string
    {
        return $this->classe_isolation;
    }

    public function setClasseIsolation(?string $classe_isolation): self
    {
        $this->classe_isolation = $classe_isolation;

        return $this;
    }

    public function getIndiceProtection(): ?string
    {
        return $this->indice_protection;
    }

    public function setIndiceProtection(?string $indice_protection): self
    {
        $this->indice_protection = $indice_protection;

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
            $this->parametre->setLplaque(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getLplaque() !== $this) {
            $parametre->setLplaque($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
