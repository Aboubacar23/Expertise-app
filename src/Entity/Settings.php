<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_qualite = null;

    #[ORM\Column(nullable: true)]
    private ?float $critere = null;

    #[ORM\Column(nullable: true)]
    private ?float $temperature = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroQualite(): ?string
    {
        return $this->numero_qualite;
    }

    public function setNumeroQualite(string $numero_qualite): static
    {
        $this->numero_qualite = $numero_qualite;

        return $this;
    }

    public function getCritere(): ?float
    {
        return $this->critere;
    }

    public function setCritere(?float $critere): static
    {
        $this->critere = $critere;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }
}
