<?php

namespace App\Entity;

use App\Repository\PontDiodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PontDiodeRepository::class)]
class PontDiode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $diode = null;

    #[ORM\Column]
    private ?float $tension = null;

    #[ORM\ManyToOne(inversedBy: 'pontDiodes')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conforme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiode(): ?string
    {
        return $this->diode;
    }

    public function setDiode(string $diode): static
    {
        $this->diode = $diode;

        return $this;
    }

    public function getTension(): ?float
    {
        return $this->tension;
    }

    public function setTension(float $tension): static
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
