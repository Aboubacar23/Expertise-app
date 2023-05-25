<?php

namespace App\Entity;

use App\Repository\PointFonctionnementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointFonctionnementRepository::class)]
class PointFonctionnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $t = null;

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
    private ?float $i = null;

    #[ORM\Column]
    private ?float $tamb = null;

    #[ORM\Column]
    private ?float $ca = null;

    #[ORM\Column]
    private ?float $coa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\ManyToOne(inversedBy: 'pointFonctionnements')]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getT(): ?float
    {
        return $this->t;
    }

    public function setT(float $t): self
    {
        $this->t = $t;

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

    public function getI(): ?float
    {
        return $this->i;
    }

    public function setI(float $i): self
    {
        $this->i = $i;

        return $this;
    }

    public function getTamb(): ?float
    {
        return $this->tamb;
    }

    public function setTamb(float $tamb): self
    {
        $this->tamb = $tamb;

        return $this;
    }

    public function getCa(): ?float
    {
        return $this->ca;
    }

    public function setCa(float $ca): self
    {
        $this->ca = $ca;

        return $this;
    }

    public function getCoa(): ?float
    {
        return $this->coa;
    }

    public function setCoa(float $coa): self
    {
        $this->coa = $coa;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

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
