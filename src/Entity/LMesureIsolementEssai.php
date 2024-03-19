<?php

namespace App\Entity;

use App\Repository\LMesureIsolementEssaiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LMesureIsolementEssaiRepository::class)]
class LMesureIsolementEssai
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle = null;

    #[ORM\Column(nullable: true)]
    private ?string $critere = null;

    #[ORM\Column(nullable: true)]
    private ?float $tension = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_correction = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    #[ORM\ManyToOne(inversedBy: 'lMesureIsolementEssais')]
    private ?MesureIsolementEssai $mesure_isolement_essai = null;

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

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(?string $critere): self
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

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }
    

    public function getMesureIsolementEssai(): ?MesureIsolementEssai
    {
        return $this->mesure_isolement_essai;
    }

    public function setMesureIsolementEssai(?MesureIsolementEssai $mesure_isolement_essai): static
    {
        $this->mesure_isolement_essai = $mesure_isolement_essai;

        return $this;
    }
}
