<?php

namespace App\Entity;

use App\Repository\RemontagePalierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemontagePalierRepository::class)]
class RemontagePalier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $caa = null;

    #[ORM\Column(nullable: true)]
    private ?float $cab = null;

    #[ORM\Column(nullable: true)]
    private ?float $cac = null;

    #[ORM\Column(nullable: true)]
    private ?float $cad = null;

    #[ORM\Column(nullable: true)]
    private ?float $ca_jeu = null;

    #[ORM\Column(nullable: true)]
    private ?float $ca_roulement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_graisse = null;

    #[ORM\Column(nullable: true)]
    private ?float $coaa = null;

    #[ORM\Column(nullable: true)]
    private ?float $coab = null;

    #[ORM\Column(nullable: true)]
    private ?float $coac = null;

    #[ORM\Column(nullable: true)]
    private ?float $coad = null;

    #[ORM\Column(nullable: true)]
    private ?float $coa_jeu = null;

    #[ORM\Column(nullable: true)]
    private ?float $coa_roulement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'remontage_palier', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaa(): ?float
    {
        return $this->caa;
    }

    public function setCaa(?float $caa): self
    {
        $this->caa = $caa;

        return $this;
    }

    public function getCab(): ?float
    {
        return $this->cab;
    }

    public function setCab(?float $cab): self
    {
        $this->cab = $cab;

        return $this;
    }

    public function getCac(): ?float
    {
        return $this->cac;
    }

    public function setCac(?float $cac): self
    {
        $this->cac = $cac;

        return $this;
    }

    public function getCad(): ?float
    {
        return $this->cad;
    }

    public function setCad(?float $cad): self
    {
        $this->cad = $cad;

        return $this;
    }

    public function getCaJeu(): ?float
    {
        return $this->ca_jeu;
    }

    public function setCaJeu(?float $ca_jeu): self
    {
        $this->ca_jeu = $ca_jeu;

        return $this;
    }

    public function getCaRoulement(): ?float
    {
        return $this->ca_roulement;
    }

    public function setCaRoulement(?float $ca_roulement): self
    {
        $this->ca_roulement = $ca_roulement;

        return $this;
    }

    public function getTypeGraisse(): ?string
    {
        return $this->type_graisse;
    }

    public function setTypeGraisse(?string $type_graisse): self
    {
        $this->type_graisse = $type_graisse;

        return $this;
    }

    public function getCoaa(): ?float
    {
        return $this->coaa;
    }

    public function setCoaa(?float $coaa): self
    {
        $this->coaa = $coaa;

        return $this;
    }

    public function getCoab(): ?float
    {
        return $this->coab;
    }

    public function setCoab(?float $coab): self
    {
        $this->coab = $coab;

        return $this;
    }

    public function getCoac(): ?float
    {
        return $this->coac;
    }

    public function setCoac(?float $coac): self
    {
        $this->coac = $coac;

        return $this;
    }

    public function getCoad(): ?float
    {
        return $this->coad;
    }

    public function setCoad(?float $coad): self
    {
        $this->coad = $coad;

        return $this;
    }

    public function getCoaJeu(): ?float
    {
        return $this->coa_jeu;
    }

    public function setCoaJeu(?float $coa_jeu): self
    {
        $this->coa_jeu = $coa_jeu;

        return $this;
    }

    public function getCoaRoulement(): ?float
    {
        return $this->coa_roulement;
    }

    public function setCoaRoulement(?float $coa_roulement): self
    {
        $this->coa_roulement = $coa_roulement;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setRemontagePalier(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getRemontagePalier() !== $this) {
            $parametre->setRemontagePalier($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
