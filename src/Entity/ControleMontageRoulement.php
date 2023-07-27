<?php

namespace App\Entity;

use App\Repository\ControleMontageRoulementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleMontageRoulementRepository::class)]
class ControleMontageRoulement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_roulement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_montage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ca_kit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_roulement = null;
 
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_montage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $coa_kit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_a = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_b = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_c = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_d = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_vide1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_ca_jeu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cote_ca_vide2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_a = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_b = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_c = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_d = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_vide1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $cote_coa_jeu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cote_coa_vide2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controle_montage_roulement', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaRoulement(): ?string
    {
        return $this->ca_roulement;
    }

    public function setCaRoulement(?string $ca_roulement): self
    {
        $this->ca_roulement = $ca_roulement;

        return $this;
    }

    public function getCaMontage(): ?string
    {
        return $this->ca_montage;
    }

    public function setCaMontage(?string $ca_montage): self
    {
        $this->ca_montage = $ca_montage;

        return $this;
    }

    public function isCaKit(): ?bool
    {
        return $this->ca_kit;
    }

    public function setCaKit(?bool $ca_kit): self
    {
        $this->ca_kit = $ca_kit;

        return $this;
    }

    public function getCoaRoulement(): ?string
    {
        return $this->coa_roulement;
    }

    public function setCoaRoulement(?string $coa_roulement): self
    {
        $this->coa_roulement = $coa_roulement;

        return $this;
    }

    public function getCoaMontage(): ?string
    {
        return $this->coa_montage;
    }

    public function setCoaMontage(?string $coa_montage): self
    {
        $this->coa_montage = $coa_montage;

        return $this;
    }

    public function isCoaKit(): ?bool
    {
        return $this->coa_kit;
    }

    public function setCoaKit(?bool $coa_kit): self
    {
        $this->coa_kit = $coa_kit;

        return $this;
    }

    public function getCoteCaA(): ?float
    {
        return $this->cote_ca_a;
    }

    public function setCoteCaA(?float $cote_ca_a): self
    {
        $this->cote_ca_a = $cote_ca_a;

        return $this;
    }

    public function getCoteCaB(): ?float
    {
        return $this->cote_ca_b;
    }

    public function setCoteCaB(?float $cote_ca_b): self
    {
        $this->cote_ca_b = $cote_ca_b;

        return $this;
    }

    public function getCoteCaC(): ?float
    {
        return $this->cote_ca_c;
    }

    public function setCoteCaC(?float $cote_ca_c): self
    {
        $this->cote_ca_c = $cote_ca_c;

        return $this;
    }

    public function getCoteCaD(): ?float
    {
        return $this->cote_ca_d;
    }

    public function setCoteCaD(?float $cote_ca_d): self
    {
        $this->cote_ca_d = $cote_ca_d;

        return $this;
    }

    public function getCoteCaVide1(): ?float
    {
        return $this->cote_ca_vide1;
    }

    public function setCoteCaVide1(?float $cote_ca_vide1): self
    {
        $this->cote_ca_vide1 = $cote_ca_vide1;

        return $this;
    }

    public function getCoteCaJeu(): ?float
    {
        return $this->cote_ca_jeu;
    }

    public function setCoteCaJeu(?float $cote_ca_jeu): self
    {
        $this->cote_ca_jeu = $cote_ca_jeu;

        return $this;
    }

    public function getCoteCaVide2(): ?string
    {
        return $this->cote_ca_vide2;
    }

    public function setCoteCaVide2(?string $cote_ca_vide2): self
    {
        $this->cote_ca_vide2 = $cote_ca_vide2;

        return $this;
    }

    public function getCoteCoaA(): ?float
    {
        return $this->cote_coa_a;
    }

    public function setCoteCoaA(?float $cote_coa_a): self
    {
        $this->cote_coa_a = $cote_coa_a;

        return $this;
    }

    public function getCoteCoaB(): ?float
    {
        return $this->cote_coa_b;
    }

    public function setCoteCoaB(?float $cote_coa_b): self
    {
        $this->cote_coa_b = $cote_coa_b;

        return $this;
    }

    public function getCoteCoaC(): ?float
    {
        return $this->cote_coa_c;
    }

    public function setCoteCoaC(?float $cote_coa_c): self
    {
        $this->cote_coa_c = $cote_coa_c;

        return $this;
    }

    public function getCoteCoaD(): ?float
    {
        return $this->cote_coa_d;
    }

    public function setCoteCoaD(?float $cote_coa_d): self
    {
        $this->cote_coa_d = $cote_coa_d;

        return $this;
    }

    public function getCoteCoaVide1(): ?float
    {
        return $this->cote_coa_vide1;
    }

    public function setCoteCoaVide1(?float $cote_coa_vide1): self
    {
        $this->cote_coa_vide1 = $cote_coa_vide1;

        return $this;
    }

    public function getCoteCoaJeu(): ?float
    {
        return $this->cote_coa_jeu;
    }

    public function setCoteCoaJeu(?float $cote_coa_jeu): self
    {
        $this->cote_coa_jeu = $cote_coa_jeu;

        return $this;
    }

    public function getCoteCoaVide2(): ?string
    {
        return $this->cote_coa_vide2;
    }

    public function setCoteCoaVide2(?string $cote_coa_vide2): self
    {
        $this->cote_coa_vide2 = $cote_coa_vide2;

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
            $this->parametre->setControleMontageRoulement(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleMontageRoulement() !== $this) {
            $parametre->setControleMontageRoulement($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
