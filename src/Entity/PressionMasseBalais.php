<?php

namespace App\Entity;

use App\Repository\PressionMasseBalaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PressionMasseBalaisRepository::class)]
class PressionMasseBalais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $critere = null;

    #[ORM\Column(length: 255)]
    private ?string $preconisation = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\ManyToOne(inversedBy: 'pressionMasseBalais')]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(string $critere): static
    {
        $this->critere = $critere;

        return $this;
    }

    public function getPreconisation(): ?string
    {
        return $this->preconisation;
    }

    public function setPreconisation(string $preconisation): static
    {
        $this->preconisation = $preconisation;

        return $this;
    }

    public function getConformite(): ?string
    {
        return $this->conformite;
    }

    public function setConformite(string $conformite): static
    {
        $this->conformite = $conformite;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }
}
