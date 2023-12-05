<?php

namespace App\Entity;

use App\Repository\LMesureVibratoireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LMesureVibratoireRepository::class)]
class LMesureVibratoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?float $n30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $a30 = null;
    #[ORM\Column(nullable: true)]
    private ?float $b30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $c30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $e30 = null;

    #[ORM\Column(nullable: true)]
    private ?float $f30 = null;

    #[ORM\ManyToOne(inversedBy: 'lMesureVibratoires')]
    private ?MesureVibratoire $mesure_vibratoire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLig(): ?int
    {
        return $this->lig;
    }

    public function setLig(?int $lig): static
    {
        $this->lig = $lig;

        return $this;
    }

    public function getMesureVibratoire(): ?MesureVibratoire
    {
        return $this->mesure_vibratoire;
    }

    public function setMesureVibratoire(?MesureVibratoire $mesure_vibratoire): static
    {
        $this->mesure_vibratoire = $mesure_vibratoire;

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

    public function getA30(): ?float
    {
        return $this->a30;
    }

    public function setA30(?float $a30): self
    {
        $this->a30 = $a30;

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
    public function getC30(): ?float
    {
        return $this->c30;
    }

    public function setC30(?float $c30): self
    {
        $this->c30 = $c30;

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

    public function getE30(): ?float
    {
        return $this->e30;
    }

    public function setE30(?float $e30): self
    {
        $this->e30 = $e30;

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
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
