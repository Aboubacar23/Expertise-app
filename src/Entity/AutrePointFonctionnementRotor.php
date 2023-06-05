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
