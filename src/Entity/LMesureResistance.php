<?php

namespace App\Entity;

use App\Repository\LMesureResistanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LMesureResistanceRepository::class)]
class LMesureResistance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $controle = null;

    #[ORM\Column]
    private ?float $critere = null;

    #[ORM\Column]
    private ?string $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\ManyToOne(inversedBy: 'lMesureResistances')]
    private ?MesureResistance $mesure_resistance = null;

    #[ORM\Column]
    private ?float $temp_correction = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getControle(): ?string
    {
        return $this->controle;
    }

    public function setControle(string $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function getCritere(): ?float
    {
        return $this->critere;
    }

    public function setCritere(float $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getConformite(): ?string
    {
        return $this->conformite;
    }

    public function setConformite(string $conformite): self
    {
        $this->conformite = $conformite;

        return $this;
    }

    public function getLig(): ?int
    {
        return $this->lig;
    }

    public function setLig(?int $lig): self
    {
        $this->lig = $lig;

        return $this;
    }

    public function getMesureResistance(): ?MesureResistance
    {
        return $this->mesure_resistance;
    }

    public function setMesureResistance(?MesureResistance $mesure_resistance): self
    {
        $this->mesure_resistance = $mesure_resistance;

        return $this;
    }

    public function getTempCorrection(): ?float
    {
        return $this->temp_correction;
    }

    public function setTempCorrection(float $temp_correction): static
    {
        $this->temp_correction = $temp_correction;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
