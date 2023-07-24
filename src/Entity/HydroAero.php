<?php

namespace App\Entity;

use App\Repository\HydroAeroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HydroAeroRepository::class)]
class HydroAero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conformite5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu5 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'hydro_aero', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConformite1(): ?string
    {
        return $this->conformite1;
    }

    public function setConformite1(?string $conformite1): self
    {
        $this->conformite1 = $conformite1;

        return $this;
    }

    public function getConformite2(): ?string
    {
        return $this->conformite2;
    }

    public function setConformite2(?string $conformite2): self
    {
        $this->conformite2 = $conformite2;

        return $this;
    }

    public function getConformite3(): ?string
    {
        return $this->conformite3;
    }

    public function setConformite3(?string $conformite3): self
    {
        $this->conformite3 = $conformite3;

        return $this;
    }

    public function getConformite4(): ?string
    {
        return $this->conformite4;
    }

    public function setConformite4(?string $conformite4): self
    {
        $this->conformite4 = $conformite4;

        return $this;
    }

    public function getConformite5(): ?string
    {
        return $this->conformite5;
    }

    public function setConformite5(?string $conformite5): self
    {
        $this->conformite5 = $conformite5;

        return $this;
    }

    public function getConstat1(): ?string
    {
        return $this->constat1;
    }

    public function setConstat1(?string $constat1): self
    {
        $this->constat1 = $constat1;

        return $this;
    }

    public function getConstat2(): ?string
    {
        return $this->constat2;
    }

    public function setConstat2(?string $constat2): self
    {
        $this->constat2 = $constat2;

        return $this;
    }

    public function getConstat3(): ?string
    {
        return $this->constat3;
    }

    public function setConstat3(?string $constat3): self
    {
        $this->constat3 = $constat3;

        return $this;
    }

    public function getConstat4(): ?string
    {
        return $this->constat4;
    }

    public function setConstat4(?string $constat4): self
    {
        $this->constat4 = $constat4;

        return $this;
    }

    public function getConstat5(): ?string
    {
        return $this->constat5;
    }

    public function setConstat5(?string $constat5): self
    {
        $this->constat5 = $constat5;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getRetenu2(): ?string
    {
        return $this->retenu2;
    }

    public function setRetenu2(?string $retenu2): self
    {
        $this->retenu2 = $retenu2;

        return $this;
    }

    public function getRetenu3(): ?string
    {
        return $this->retenu3;
    }

    public function setRetenu3(?string $retenu3): self
    {
        $this->retenu3 = $retenu3;

        return $this;
    }

    public function getRetenu4(): ?string
    {
        return $this->retenu4;
    }

    public function setRetenu4(?string $retenu4): self
    {
        $this->retenu4 = $retenu4;

        return $this;
    }

    public function getRetenu5(): ?string
    {
        return $this->retenu5;
    }

    public function setRetenu5(?string $retenu5): self
    {
        $this->retenu5 = $retenu5;

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
            $this->parametre->setHydroAero(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getHydroAero() !== $this) {
            $parametre->setHydroAero($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
