<?php

namespace App\Entity;

use App\Repository\LStatorApresLavageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LStatorApresLavageRepository::class)]
class LStatorApresLavage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $controle = null;

    #[ORM\Column(length: 255)]
    private ?string $critere = null;

    #[ORM\Column]
    private ?float $tension_essai = null;

    #[ORM\Column]
    private ?float $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\ManyToOne(inversedBy: 'lStatorApresLavages')]
    private ?StatorApresLavage $stator_apres_lavage = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur_relevee = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_correction = null;

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

    public function getTensionEssai(): ?float
    {
        return $this->tension_essai;
    }

    public function setTensionEssai(float $tension_essai): self
    {
        $this->tension_essai = $tension_essai;

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

    public function getStatorApresLavage(): ?StatorApresLavage
    {
        return $this->stator_apres_lavage;
    }

    public function setStatorApresLavage(?StatorApresLavage $stator_apres_lavage): self
    {
        $this->stator_apres_lavage = $stator_apres_lavage;

        return $this;
    }

    public function getValeurRelevee(): ?float
    {
        return $this->valeur_relevee;
    }

    public function setValeurRelevee(?float $valeur_relevee): self
    {
        $this->valeur_relevee = $valeur_relevee;

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
}
