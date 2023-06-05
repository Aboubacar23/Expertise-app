<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $u = null;

    #[ORM\Column]
    private ?float $i1 = null;

    #[ORM\Column]
    private ?float $i2 = null;

    #[ORM\Column]
    private ?float $i3 = null;

    #[ORM\Column]
    private ?float $p = null;

    #[ORM\Column]
    private ?float $q = null;

    #[ORM\Column]
    private ?float $cos = null;

    #[ORM\Column]
    private ?float $n = null;

    #[ORM\Column]
    private ?float $pj = null;

    #[ORM\Column(nullable: true)]
    private ?float $p_pj = null;
 
    #[ORM\ManyToOne(inversedBy: 'caracteristiques')]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getP(): ?float
    {
        return $this->p;
    }

    public function setP(float $p): self
    {
        $this->p = $p;

        return $this;
    }

    public function getQ(): ?float
    {
        return $this->q;
    }

    public function setQ(float $q): self
    {
        $this->q = $q;

        return $this;
    }

    public function getCos(): ?float
    {
        return $this->cos;
    }

    public function setCos(float $cos): self
    {
        $this->cos = $cos;

        return $this;
    }

    public function getN(): ?float
    {
        return $this->n;
    }

    public function setN(float $n): self
    {
        $this->n = $n;

        return $this;
    }

    public function getPj(): ?float
    {
        return $this->pj;
    }

    public function setPj(float $pj): self
    {
        $this->pj = $pj;

        return $this;
    }

    public function getPPj(): ?float
    {
        return $this->p_pj;
    }

    public function setPPj(float $p_pj): self
    {
        $this->p_pj = $p_pj;

        return $this;
    }


    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        $this->parametre = $parametre;

        return $this;
    }
}
