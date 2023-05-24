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
    private ?int $n10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $n25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $a10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $a25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $b10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $b25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $c10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $c25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $d10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $d25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $e10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $e25 = null;

    #[ORM\Column(nullable: true)]
    private ?int $f10 = null;

    #[ORM\Column(nullable: true)]
    private ?int $f25 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $obervation = null;

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

    public function getN10(): ?int
    {
        return $this->n10;
    }

    public function setN10(?int $n10): self
    {
        $this->n10 = $n10;

        return $this;
    }

    public function getN25(): ?int
    {
        return $this->n25;
    }

    public function setN25(?int $n25): self
    {
        $this->n25 = $n25;

        return $this;
    }

    public function getA10(): ?int
    {
        return $this->a10;
    }

    public function setA10(?int $a10): self
    {
        $this->a10 = $a10;

        return $this;
    }

    public function getA25(): ?int
    {
        return $this->a25;
    }

    public function setA25(?int $a25): self
    {
        $this->a25 = $a25;

        return $this;
    }

    public function getB10(): ?int
    {
        return $this->b10;
    }

    public function setB10(?int $b10): self
    {
        $this->b10 = $b10;

        return $this;
    }

    public function getB25(): ?int
    {
        return $this->b25;
    }

    public function setB25(?int $b25): self
    {
        $this->b25 = $b25;

        return $this;
    }

    public function getC10(): ?int
    {
        return $this->c10;
    }

    public function setC10(?int $c10): self
    {
        $this->c10 = $c10;

        return $this;
    }

    public function getC25(): ?int
    {
        return $this->c25;
    }

    public function setC25(?int $c25): self
    {
        $this->c25 = $c25;

        return $this;
    }

    public function getD10(): ?int
    {
        return $this->d10;
    }

    public function setD10(?int $d10): self
    {
        $this->d10 = $d10;

        return $this;
    }

    public function getD25(): ?int
    {
        return $this->d25;
    }

    public function setD25(?int $d25): self
    {
        $this->d25 = $d25;

        return $this;
    }

    public function getE10(): ?int
    {
        return $this->e10;
    }

    public function setE10(?int $e10): self
    {
        $this->e10 = $e10;

        return $this;
    }

    public function getE25(): ?int
    {
        return $this->e25;
    }

    public function setE25(?int $e25): self
    {
        $this->e25 = $e25;

        return $this;
    }

    public function getF10(): ?int
    {
        return $this->f10;
    }

    public function setF10(?int $f10): self
    {
        $this->f10 = $f10;

        return $this;
    }

    public function getF25(): ?int
    {
        return $this->f25;
    }

    public function setF25(?int $f25): self
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
