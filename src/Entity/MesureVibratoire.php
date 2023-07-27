<?php

namespace App\Entity;

use App\Repository\MesureVibratoireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesureVibratoireRepository::class)]
class MesureVibratoire
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
    private ?float $n30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $n25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $b10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $b30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $b25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e25 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f25 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $obervation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\OneToOne(mappedBy: 'mesure_vibratoire', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

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


    public function getN30(): ?float
    {
        return $this->n30;
    }

    public function setN30(?float $n30): self
    {
        $this->n30 = $n30;

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

    public function getA30(): ?float
    {
        return $this->a30;
    }

    public function setA30(?float $a30): self
    {
        $this->a30 = $a30;

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

    public function getB10(): ?float
    {
        return $this->b10;
    }

    public function setB10(?float $b10): self
    {
        $this->b10 = $b10;

        return $this;
    }

    public function getB30(): ?float
    {
        return $this->b30;
    }

    public function setB30(?float $b30): self
    {
        $this->b30 = $b30;

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

    public function getC10(): ?float
    {
        return $this->c10;
    }

    public function setC10(?float $c10): self
    {
        $this->c10 = $c10;

        return $this;
    }

    public function getC30(): ?float
    {
        return $this->c30;
    }

    public function setC30(?float $c30): self
    {
        $this->c30 = $c30;

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

    public function getD10(): ?float
    {
        return $this->d10;
    }

    public function setD10(?float $d10): self
    {
        $this->d10 = $d10;

        return $this;
    }

    public function getD30(): ?float
    {
        return $this->d30;
    }

    public function setD30(?float $d30): self
    {
        $this->d30 = $d30;

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

    public function getE10(): ?float
    {
        return $this->e10;
    }

    public function setE10(?float $e10): self
    {
        $this->e10 = $e10;

        return $this;
    }

    public function getE30(): ?float
    {
        return $this->e30;
    }

    public function setE30(?float $e30): self
    {
        $this->e30 = $e30;

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

    public function getF10(): ?float
    {
        return $this->f10;
    }

    public function setF10(?float $f10): self
    {
        $this->f10 = $f10;

        return $this;
    }

    public function getF30(): ?float
    {
        return $this->f30;
    }

    public function setF30(?float $f30): self
    {
        $this->f30 = $f30;

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

    public function getObervation(): ?string
    {
        return $this->obervation;
    }

    public function setObervation(?string $obervation): self
    {
        $this->obervation = $obervation;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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
            $this->parametre->setMesureVibratoire(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureVibratoire() !== $this) {
            $parametre->setMesureVibratoire($this);
        }

        $this->parametre = $parametre;

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
}
