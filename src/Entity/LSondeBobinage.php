<?php

namespace App\Entity;

use App\Repository\LSondeBobinageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LSondeBobinageRepository::class)]
class LSondeBobinage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $controle = null;

    #[ORM\Column(nullable: true)]
    private ?string $critere = null;

    #[ORM\Column(nullable: true)]
    private ?string $valeur_relevee = null;

    #[ORM\Column]
    private ?string $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\ManyToOne(inversedBy: 'lSondeBobinages')]
    private ?SondeBobinage $sonde_bobinage = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_correction = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    #[ORM\Column(length: 255, nullable: true)]
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

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(string $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function getValeurRelevee(): ?string
    {
        return $this->valeur_relevee;
    }

    public function setValeurRelevee(?string $valeur_relevee): self
    {
        $this->valeur_relevee = $valeur_relevee;

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

    public function getSondeBobinage(): ?SondeBobinage
    {
        return $this->sonde_bobinage;
    }

    public function setSondeBobinage(?SondeBobinage $sonde_bobinage): self
    {
        $this->sonde_bobinage = $sonde_bobinage;

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

    public function setTempCorrection(?float $temp_correction): static
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

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
