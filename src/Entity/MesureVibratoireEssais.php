<?php

namespace App\Entity;

use App\Repository\MesureVibratoireEssaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesureVibratoireEssaisRepository::class)]
class MesureVibratoireEssais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position = null;

    #[ORM\Column(length: 255)]
    private ?string $montage = null;

    #[ORM\Column(length: 255)]
    private ?string $accouplement = null;

    #[ORM\Column(length: 255)]
    private ?string $clavette = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $n10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $n25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $n35 = null;

    #[ORM\Column(nullable: true)]
    private ?float $n45 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $a35 = null;
    #[ORM\Column(nullable: true)]
    private ?float $a45 = null;

    #[ORM\Column(nullable: true)]
    private ?float $b10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $b25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $b35 = null;
    #[ORM\Column(nullable: true)]
    private ?float $b45 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $c35 = null;
    #[ORM\Column(nullable: true)]
    private ?float $c45 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $d35 = null;
    #[ORM\Column(nullable: true)]
    private ?float $d45 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $e45 = null;
    #[ORM\Column(nullable: true)]
    private ?float $e35 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f25 = null;
    #[ORM\Column(nullable: true)]
    private ?float $f35 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f45 = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $obervation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre35 = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre45 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'mesure_vibratoire_essais', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getMontage(): ?string
    {
        return $this->montage;
    }

    public function setMontage(string $montage): self
    {
        $this->montage = $montage;

        return $this;
    }

    public function getAccouplement(): ?string
    {
        return $this->accouplement;
    }

    public function setAccouplement(string $accouplement): self
    {
        $this->accouplement = $accouplement;

        return $this;
    }

    public function getClavette(): ?string
    {
        return $this->clavette;
    }

    public function setClavette(string $clavette): self
    {
        $this->clavette = $clavette;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getN10(): ?float
    {
        return $this->n10;
    }

    public function setN10(?float $n10): self
    {
        $this->n10 = $n10;

        return $this;
    }
    public function getN35(): ?float
    {
        return $this->n35;
    }

    public function setN35(?float $n35): self
    {
        $this->n35 = $n35;

        return $this;
    }
    public function getN45(): ?float
    {
        return $this->n45;
    }

    public function setN45(?float $n45): self
    {
        $this->n45 = $n45;

        return $this;
    }

    public function getN25(): ?float
    {
        return $this->n25;
    }

    public function setN25(?float $n25): self
    {
        $this->n25 = $n25;

        return $this;
    }

    public function getA10(): ?float
    {
        return $this->a10;
    }

    public function setA10(?float $a10): self
    {
        $this->a10 = $a10;

        return $this;
    }

    public function getA25(): ?float
    {
        return $this->a25;
    }

    public function setA25(?float $a25): self
    {
        $this->a25 = $a25;

        return $this;
    }
    public function getA35(): ?float
    {
        return $this->a35;
    }

    public function setA35(?float $a35): self
    {
        $this->a35 = $a35;

        return $this;
    }

    public function getA45(): ?float
    {
        return $this->a45;
    }

    public function setA45(?float $a45): self
    {
        $this->a45 = $a45;

        return $this;
    }
    public function getB10(): ?float
    {
        return $this->b10;
    }

    public function setB10(?float $b10): self
    {
        $this->b10 = $b10;

        return $this;
    }

    public function getB25(): ?float
    {
        return $this->b25;
    }

    public function setB25(?float $b25): self
    {
        $this->b25 = $b25;

        return $this;
    }
    public function getB35(): ?float
    {
        return $this->b35;
    }

    public function setB35(?float $b35): self
    {
        $this->b35 = $b35;

        return $this;
    }
    public function getB45(): ?float
    {
        return $this->b45;
    }

    public function setB45(?float $b45): self
    {
        $this->b45 = $b45;

        return $this;
    }

    public function getC10(): ?float
    {
        return $this->c10;
    }

    public function setC10(?float $c10): self
    {
        $this->c10 = $c10;

        return $this;
    }

    public function getC25(): ?float
    {
        return $this->c25;
    }

    public function setC25(?float $c25): self
    {
        $this->c25 = $c25;

        return $this;
    }
    public function getC35(): ?float
    {
        return $this->c35;
    }

    public function setC35(?float $c35): self
    {
        $this->c35 = $c35;

        return $this;
    }
    public function getC45(): ?float
    {
        return $this->c45;
    }

    public function setC45(?float $c45): self
    {
        $this->c45 = $c45;

        return $this;
    }

    public function getD10(): ?float
    {
        return $this->d10;
    }

    public function setD10(?float $d10): self
    {
        $this->d10 = $d10;

        return $this;
    }

    public function getD25(): ?float
    {
        return $this->d25;
    }

    public function setD25(?float $d25): self
    {
        $this->d25 = $d25;

        return $this;
    }
    public function getD35(): ?float
    {
        return $this->d35;
    }

    public function setD35(?float $d35): self
    {
        $this->d35 = $d35;

        return $this;
    }
    public function getD45(): ?float
    {
        return $this->d45;
    }

    public function setD45(?float $d45): self
    {
        $this->d45 = $d45;

        return $this;
    }

    public function getE10(): ?float
    {
        return $this->e10;
    }

    public function setE10(?float $e10): self
    {
        $this->e10 = $e10;

        return $this;
    }

    public function getE25(): ?float
    {
        return $this->e25;
    }

    public function setE25(?float $e25): self
    {
        $this->e25 = $e25;

        return $this;
    }
    public function getE35(): ?float
    {
        return $this->e35;
    }

    public function setE35(?float $e35): self
    {
        $this->e35 = $e35;

        return $this;
    }
    public function getE45(): ?float
    {
        return $this->e45;
    }

    public function setE45(?float $e45): self
    {
        $this->e45 = $e45;

        return $this;
    }

    public function getF10(): ?float
    {
        return $this->f10;
    }

    public function setF10(?float $f10): self
    {
        $this->f10 = $f10;

        return $this;
    }

    public function getF25(): ?float
    {
        return $this->f25;
    }

    public function setF25(?float $f25): self
    {
        $this->f25 = $f25;

        return $this;
    }
    public function getF35(): ?float
    {
        return $this->f35;
    }

    public function setF35(?float $f35): self
    {
        $this->f35 = $f35;

        return $this;
    }
    public function getF45(): ?float
    {
        return $this->f45;
    }

    public function setF45(?float $f45): self
    {
        $this->f45 = $f45;

        return $this;
    }

    public function getObervation(): ?string
    {
        return $this->obervation;
    }

    public function setObervation(?string $obervation): self
    {
        $this->obervation = $obervation;

        return $this;
    }

    public function getTitre35(): ?string
    {
        return $this->titre35;
    }

    public function setTitre35(?string $titre35): self
    {
        $this->titre35 = $titre35;
        return $this;
    }
    public function getTitre45(): ?string
    {
        return $this->titre45;
    }

    public function setTitre45(?string $titre45): self
    {
        $this->titre45 = $titre45;
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

    public function setParametre(?Parametre $parametre): static
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setMesureVibratoireEssais(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureVibratoireEssais() !== $this) {
            $parametre->setMesureVibratoireEssais($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
