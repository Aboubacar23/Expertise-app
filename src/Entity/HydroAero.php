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
    private ?string $preconisation1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preconisation2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preconisation3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preconisation4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preconisation5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu1 = null;

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

    public function getPreconisation1(): ?string
    {
        return $this->preconisation1;
    }

    public function setPreconisation1(?string $preconisation1): self
    {
        $this->preconisation1 = $preconisation1;

        return $this;
    }

    public function getPreconisation2(): ?string
    {
        return $this->preconisation2;
    }

    public function setPreconisation2(?string $preconisation2): self
    {
        $this->preconisation2 = $preconisation2;

        return $this;
    }

    public function getPreconisation3(): ?string
    {
        return $this->preconisation3;
    }

    public function setPreconisation3(?string $preconisation3): self
    {
        $this->preconisation3 = $preconisation3;

        return $this;
    }

    public function getPreconisation4(): ?string
    {
        return $this->preconisation4;
    }

    public function setPreconisation4(?string $preconisation4): self
    {
        $this->preconisation4 = $preconisation4;

        return $this;
    }

    public function getPreconisation5(): ?string
    {
        return $this->preconisation5;
    }

    public function setPreconisation5(?string $preconisation5): self
    {
        $this->preconisation5 = $preconisation5;

        return $this;
    }

    public function getRetenu1(): ?string
    {
        return $this->retenu1;
    }

    public function setRetenu1(?string $retenu1): self
    {
        $this->retenu1 = $retenu1;

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
