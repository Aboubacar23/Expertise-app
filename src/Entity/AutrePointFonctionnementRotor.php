<?php

namespace App\Entity;

use App\Repository\AutrePointFonctionnementRotorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutrePointFonctionnementRotorRepository::class)]
class AutrePointFonctionnementRotor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $m = null;

    #[ORM\Column(nullable: true)]
    private ?float $iden = null;

    #[ORM\Column(nullable: true)]
    private ?float $cd = null;

    #[ORM\Column]
    private ?float $u = null;

    #[ORM\Column]
    private ?float $i1 = null;

    #[ORM\Column]
    private ?float $i2 = null;

    #[ORM\Column]
    private ?float $i3 = null;

    #[ORM\Column]
    private ?float $imoy = null;

    #[ORM\Column]
    private ?float $pabs = null;

    #[ORM\Column] 
    private ?float $pjoule = null;


    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'autre_point_fonctionnement_rotor', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    { 
        return $this->id;
    }

    public function getM(): ?float
    {
        return $this->m;
    }

    public function setM(?float $m): self
    {
        $this->m = $m;

        return $this;
    }

    public function getIden(): ?float
    {
        return $this->iden;
    }
    public function setIden(?float $iden): self
    {
        $this->iden = $iden;

        return $this;
    }

    public function getCd(): ?float
    {
        return $this->cd;
    }

    public function setCd(?float $cd): self
    {
        $this->cd = $cd;

        return $this;
    }
    public function getU(): ?float
    {
        return $this->u;
    }

    public function setU(float $u): self
    {
        $this->u = $u;

        return $this;
    }

    public function getI1(): ?float
    {
        return $this->i1;
    }

    public function setI1(float $i1): self
    {
        $this->i1 = $i1;

        return $this;
    }

    public function getI2(): ?float
    {
        return $this->i2;
    }

    public function setI2(float $i2): self
    {
        $this->i2 = $i2;

        return $this;
    }

    public function getI3(): ?float
    {
        return $this->i3;
    }

    public function setI3(float $i3): self
    {
        $this->i3 = $i3;

        return $this;
    }

    public function getImoy(): ?float
    {
        return $this->imoy;
    }

    public function setImoy(float $imoy): self
    {
        $this->imoy = $imoy;

        return $this;
    }

    public function getPabs(): ?float
    {
        return $this->pabs;
    }

    public function setPabs(float $pabs): self
    {
        $this->pabs = $pabs;

        return $this;
    }

    public function getPjoule(): ?float
    {
        return $this->pjoule;
    }

    public function setPjoule(float $pjoule): self
    {
        $this->pjoule = $pjoule;

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
            $this->parametre->setAutrePointFonctionnementRotor(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getAutrePointFonctionnementRotor() !== $this) {
            $parametre->setAutrePointFonctionnementRotor($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
