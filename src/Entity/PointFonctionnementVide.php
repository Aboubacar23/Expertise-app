<?php

namespace App\Entity;

use App\Repository\PointFonctionnementVideRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointFonctionnementVideRepository::class)]
class PointFonctionnementVide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false, length: 255)]
    private ?string $image = null;

   /*
    #[ORM\Column(nullable: true)]
    private ?string $u = null;

    #[ORM\Column(nullable: true)]
    private ?string $i1 = null;

    #[ORM\Column(nullable: true)]
    private ?string $i2 = null;

    #[ORM\Column(nullable: true)]
    private ?string $i3 = null;

    #[ORM\Column(nullable: true)]
    private ?string $p = null;

    #[ORM\Column(nullable: true)]
    private ?string $q = null;

    #[ORM\Column(nullable: true)]
    private ?string $cos = null;

    #[ORM\Column(nullable: true)]
    private ?string $n = null;

    #[ORM\Column(nullable: true)]
    private ?string $i = null;

    #[ORM\Column(nullable: true)]
    private ?string $tamb = null;

    #[ORM\Column(nullable: true)]
    private ?string $ca = null;

    #[ORM\Column(nullable: true)]
    private ?string $coa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;
*/
    #[ORM\ManyToOne(inversedBy: 'pointFonctionnementVides')]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
/*
    public function getU(): ?string
    {
        return $this->u;
    }

    public function setU(string $u): self
    {
        $this->u = $u;

        return $this;
    }

    public function getI1(): ?string
    {
        return $this->i1;
    }

    public function setI1(string $i1): self
    {
        $this->i1 = $i1;

        return $this;
    }

    public function getI2(): ?string
    {
        return $this->i2;
    }

    public function setI2(string $i2): self
    {
        $this->i2 = $i2;

        return $this;
    }

    public function getI3(): ?string
    {
        return $this->i3;
    }

    public function setI3(string $i3): self
    {
        $this->i3 = $i3;

        return $this;
    }

    public function getP(): ?string
    {
        return $this->p;
    }

    public function setP(string $p): self
    {
        $this->p = $p;

        return $this;
    }

    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(string $q): self
    {
        $this->q = $q;

        return $this;
    }

    public function getCos(): ?string
    {
        return $this->cos;
    }

    public function setCos(string $cos): self
    {
        $this->cos = $cos;

        return $this;
    }

    public function getN(): ?string
    {
        return $this->n;
    }

    public function setN(string $n): self
    {
        $this->n = $n;

        return $this;
    }

    public function getI(): ?string
    {
        return $this->i;
    }

    public function setI(string $i): self
    {
        $this->i = $i;

        return $this;
    }

    public function getTamb(): ?string
    {
        return $this->tamb;
    }

    public function setTamb(string $tamb): self
    {
        $this->tamb = $tamb;

        return $this;
    }

    public function getCa(): ?string
    {
        return $this->ca;
    }

    public function setCa(string $ca): self
    {
        $this->ca = $ca;

        return $this;
    }

    public function getCoa(): ?string
    {
        return $this->coa;
    }

    public function setCoa(string $coa): self
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
    */

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }
}
