<?php

namespace App\Entity;

use App\Repository\LMesureResistanceEssaiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LMesureResistanceEssaiRepository::class)]
class LMesureResistanceEssai
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
    private ?float $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\Column]
    private ?float $temp_correction = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    #[ORM\ManyToOne(inversedBy: 'lMesureResistanceEssais')]
    private ?MesureResistanceEssai $mesure_reistance_essai = null;

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

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
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

    public function getMesureReistanceEssai(): ?MesureResistanceEssai
    {
        return $this->mesure_reistance_essai;
    }

    public function setMesureReistanceEssai(?MesureResistanceEssai $mesure_reistance_essai): static
    {
        $this->mesure_reistance_essai = $mesure_reistance_essai;

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