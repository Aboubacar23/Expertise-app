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
    private ?float $faux_rond_1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $faux_rond_2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $faux_rond_3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $faux_rond_4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'controleGeometriques')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255)]
    private ?string $diametre = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getFauxRond1(): ?float
    {
        return $this->faux_rond_1;
    }

    public function setFauxRond1(?float $faux_rond_1): self
    {
        $this->faux_rond_1 = $faux_rond_1;

        return $this;
    }

    public function getFauxRond2(): ?float
    {
        return $this->faux_rond_2;
    }

    public function setFauxRond2(?float $faux_rond_2): self
    {
        $this->faux_rond_2 = $faux_rond_2;

        return $this;
    }

    public function getFauxRond3(): ?float
    {
        return $this->faux_rond_3;
    }

    public function setFauxRond3(?float $faux_rond_3): self
    {
        $this->faux_rond_3 = $faux_rond_3;

        return $this;
    }

    public function getFauxRond4(): ?float
    {
        return $this->faux_rond_4;
    }

    public function setFauxRond4(?float $faux_rond_4): self
    {
        $this->faux_rond_4 = $faux_rond_4;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

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

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getDiametre(): ?string
    {
        return $this->diametre;
    }

    public function setDiametre(string $diametre): static
    {
        $this->diametre = $diametre;

        return $this;
    }
}
