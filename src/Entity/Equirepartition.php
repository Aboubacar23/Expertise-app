<?php

namespace App\Entity;

use App\Repository\EquirepartitionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquirepartitionRepository::class)]
class Equirepartition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pole = null;

    #[ORM\Column(nullable: true)]
    private ?float $tension = null;

    #[ORM\ManyToOne(inversedBy: 'equirepartitions')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conforme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPole(): ?string
    {
        return $this->pole;
    }

    public function setPole(string $pole): static
    {
        $this->pole = $pole;

        return $this;
    }

    public function getTension(): ?float
    {
        return $this->tension;
    }

    public function setTension(?float $tension): static
    {
        $this->tension = $tension;

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

    public function getConforme(): ?string
    {
        return $this->conforme;
    }

    public function setConforme(?string $conforme): static
    {
        $this->conforme = $conforme;

        return $this;
    }
}
