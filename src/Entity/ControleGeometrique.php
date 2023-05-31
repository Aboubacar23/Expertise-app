<?php

namespace App\Entity;

use App\Repository\ControleGeometriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleGeometriqueRepository::class)]
class ControleGeometrique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_b1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_b2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_b3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_b4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_e1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_e2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_e3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_e4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_f1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_f2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_f3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $pivot_f4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_b = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_e = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_f = null;

    #[ORM\Column(nullable: true)]
    private ?float $add_1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $add_2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $add_3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $add_4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_add = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_c1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_c2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_c3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_c4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_c = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_d1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_d2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_d3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $tolerie_d4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_d = null;

    #[ORM\Column(nullable: true)]
    private ?float $accouplement_g1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $accouplement_g2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $accouplement_g3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $accouplement_g4 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controle_geometrique', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite_g = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPivotB1(): ?float
    {
        return $this->pivot_b1;
    }

    public function setPivotB1(?float $pivot_b1): self
    {
        $this->pivot_b1 = $pivot_b1;

        return $this;
    }

    public function getPivotB2(): ?float
    {
        return $this->pivot_b2;
    }

    public function setPivotB2(?float $pivot_b2): self
    {
        $this->pivot_b2 = $pivot_b2;

        return $this;
    }

    public function getPivotB3(): ?float
    {
        return $this->pivot_b3;
    }

    public function setPivotB3(?float $pivot_b3): self
    {
        $this->pivot_b3 = $pivot_b3;

        return $this;
    }

    public function getPivotB4(): ?float
    {
        return $this->pivot_b4;
    }

    public function setPivotB4(?float $pivot_b4): self
    {
        $this->pivot_b4 = $pivot_b4;

        return $this;
    }

    public function getTolerieE1(): ?float
    {
        return $this->tolerie_e1;
    }

    public function setTolerieE1(?float $tolerie_e1): self
    {
        $this->tolerie_e1 = $tolerie_e1;

        return $this;
    }

    public function getTolerieE2(): ?float
    {
        return $this->tolerie_e2;
    }

    public function setTolerieE2(?float $tolerie_e2): self
    {
        $this->tolerie_e2 = $tolerie_e2;

        return $this;
    }

    public function getTolerieE3(): ?float
    {
        return $this->tolerie_e3;
    }

    public function setTolerieE3(?float $tolerie_e3): self
    {
        $this->tolerie_e3 = $tolerie_e3;

        return $this;
    }

    public function getTolerieE4(): ?float
    {
        return $this->tolerie_e4;
    }

    public function setTolerieE4(?float $tolerie_e4): self
    {
        $this->tolerie_e4 = $tolerie_e4;

        return $this;
    }

    public function getPivotF1(): ?float
    {
        return $this->pivot_f1;
    }

    public function setPivotF1(?float $pivot_f1): self
    {
        $this->pivot_f1 = $pivot_f1;

        return $this;
    }

    public function getPivotF2(): ?float
    {
        return $this->pivot_f2;
    }

    public function setPivotF2(?float $pivot_f2): self
    {
        $this->pivot_f2 = $pivot_f2;

        return $this;
    }

    public function getPivotF3(): ?float
    {
        return $this->pivot_f3;
    }

    public function setPivotF3(?float $pivot_f3): self
    {
        $this->pivot_f3 = $pivot_f3;

        return $this;
    }

    public function getPivotF4(): ?float
    {
        return $this->pivot_f4;
    }

    public function setPivotF4(?float $pivot_f4): self
    {
        $this->pivot_f4 = $pivot_f4;

        return $this;
    }

    public function getConformiteB(): ?string
    {
        return $this->conformite_b;
    }

    public function setConformiteB(?string $conformite_b): self
    {
        $this->conformite_b = $conformite_b;

        return $this;
    }

    public function getConformiteE(): ?string
    {
        return $this->conformite_e;
    }

    public function setConformiteE(?string $conformite_e): self
    {
        $this->conformite_e = $conformite_e;

        return $this;
    }

    public function getConformiteF(): ?string
    {
        return $this->conformite_f;
    }

    public function setConformiteF(?string $conformite_f): self
    {
        $this->conformite_f = $conformite_f;

        return $this;
    }

    public function getAdd1(): ?float
    {
        return $this->add_1;
    }

    public function setAdd1(?float $add_1): self
    {
        $this->add_1 = $add_1;

        return $this;
    }

    public function getAdd2(): ?float
    {
        return $this->add_2;
    }

    public function setAdd2(?float $add_2): self
    {
        $this->add_2 = $add_2;

        return $this;
    }

    public function getAdd3(): ?float
    {
        return $this->add_3;
    }

    public function setAdd3(?float $add_3): self
    {
        $this->add_3 = $add_3;

        return $this;
    }

    public function getAdd4(): ?float
    {
        return $this->add_4;
    }

    public function setAdd4(?float $add_4): self
    {
        $this->add_4 = $add_4;

        return $this;
    }

    public function getConformiteAdd(): ?string
    {
        return $this->conformite_add;
    }

    public function setConformiteAdd(?string $conformite_add): self
    {
        $this->conformite_add = $conformite_add;

        return $this;
    }

    public function getTolerieC1(): ?float
    {
        return $this->tolerie_c1;
    }

    public function setTolerieC1(?float $tolerie_c1): self
    {
        $this->tolerie_c1 = $tolerie_c1;

        return $this;
    }

    public function getTolerieC2(): ?float
    {
        return $this->tolerie_c2;
    }

    public function setTolerieC2(?float $tolerie_c2): self
    {
        $this->tolerie_c2 = $tolerie_c2;

        return $this;
    }

    public function getTolerieC3(): ?float
    {
        return $this->tolerie_c3;
    }

    public function setTolerieC3(?float $tolerie_c3): self
    {
        $this->tolerie_c3 = $tolerie_c3;

        return $this;
    }

    public function getTolerieC4(): ?float
    {
        return $this->tolerie_c4;
    }

    public function setTolerieC4(?float $tolerie_c4): self
    {
        $this->tolerie_c4 = $tolerie_c4;

        return $this;
    }

    public function getConformiteC(): ?string
    {
        return $this->conformite_c;
    }

    public function setConformiteC(?string $conformite_c): self
    {
        $this->conformite_c = $conformite_c;

        return $this;
    }

    public function getTolerieD1(): ?float
    {
        return $this->tolerie_d1;
    }

    public function setTolerieD1(?float $tolerie_d1): self
    {
        $this->tolerie_d1 = $tolerie_d1;

        return $this;
    }

    public function getTolerieD2(): ?float
    {
        return $this->tolerie_d2;
    }

    public function setTolerieD2(?float $tolerie_d2): self
    {
        $this->tolerie_d2 = $tolerie_d2;

        return $this;
    }

    public function getTolerieD3(): ?float
    {
        return $this->tolerie_d3;
    }

    public function setTolerieD3(?float $tolerie_d3): self
    {
        $this->tolerie_d3 = $tolerie_d3;

        return $this;
    }

    public function getTolerieD4(): ?float
    {
        return $this->tolerie_d4;
    }

    public function setTolerieD4(?float $tolerie_d4): self
    {
        $this->tolerie_d4 = $tolerie_d4;

        return $this;
    }

    public function getConformiteD(): ?string
    {
        return $this->conformite_d;
    }

    public function setConformiteD(?string $conformite_d): self
    {
        $this->conformite_d = $conformite_d;

        return $this;
    }

    public function getAccouplementG1(): ?float
    {
        return $this->accouplement_g1;
    }

    public function setAccouplementG1(?float $accouplement_g1): self
    {
        $this->accouplement_g1 = $accouplement_g1;

        return $this;
    }

    public function getAccouplementG2(): ?float
    {
        return $this->accouplement_g2;
    }

    public function setAccouplementG2(?float $accouplement_g2): self
    {
        $this->accouplement_g2 = $accouplement_g2;

        return $this;
    }

    public function getAccouplementG3(): ?float
    {
        return $this->accouplement_g3;
    }

    public function setAccouplementG3(?float $accouplement_g3): self
    {
        $this->accouplement_g3 = $accouplement_g3;

        return $this;
    }

    public function getAccouplementG4(): ?float
    {
        return $this->accouplement_g4;
    }

    public function setAccouplementG4(?float $accouplement_g4): self
    {
        $this->accouplement_g4 = $accouplement_g4;

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
            $this->parametre->setControleGeometrique(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleGeometrique() !== $this) {
            $parametre->setControleGeometrique($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    public function getConformiteG(): ?string
    {
        return $this->conformite_g;
    }

    public function setConformiteG(?string $conformite_g): self
    {
        $this->conformite_g = $conformite_g;

        return $this;
    }
}
