<?php

namespace App\Entity;

use App\Repository\LMesureIsolementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LMesureIsolementRepository::class)]
class LMesureIsolement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle = null;

    #[ORM\Column(nullable: true)]
    private ?float $critere = null;

    #[ORM\Column(nullable: true)]
    private ?float $tension = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur = null;
    
    #[ORM\ManyToOne(inversedBy: 'lMesureIsolements')]
    private ?MesureIsolement $mesure_isolement = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_correction = null;

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

    public function setControle(?string $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function getCritere(): ?float
    {
        return $this->critere;
    }

    public function setCritere(?float $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function getTension(): ?float
    {
        return $this->tension;
    }

    public function setTension(?float $tension): self
    {
        $this->tension = $tension;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(?float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getMesureIsolement(): ?MesureIsolement
    {
        return $this->mesure_isolement;
    }

    public function setMesureIsolement(?MesureIsolement $mesure_isolement): self
    {
        $this->mesure_isolement = $mesure_isolement;

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

    public function getConformite(): ?string
    {
        return $this->conformite;
    }

    public function setConformite(?string $conformite): self
    {
        $this->conformite = $conformite;

        return $this;
    }

    public function getTempCorrection(): ?float
    {
        return $this->temp_correction;
    }

    public function setTempCorrection(?float $temp_correction): static
    {
        $this->temp_correction = $temp_correction;

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
