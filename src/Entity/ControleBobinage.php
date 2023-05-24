<?php

namespace App\Entity;

use App\Repository\ControleBobinageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleBobinageRepository::class)]
class ControleBobinage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite1 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite2 = null;

    #[ORM\Column(length: 255)]
    private ?string $preconisation1 = null;

    #[ORM\Column(length: 255)]
    private ?string $preconisation2 = null;

    #[ORM\Column(length: 255)]
    private ?string $retenu1 = null;

    #[ORM\Column(length: 255)]
    private ?string $retenu2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controleBobinage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConformite1(): ?string
    {
        return $this->conformite1;
    }

    public function setConformite1(string $conformite1): self
    {
        $this->conformite1 = $conformite1;

        return $this;
    }

    public function getConformite2(): ?string
    {
        return $this->conformite2;
    }

    public function setConformite2(string $conformite2): self
    {
        $this->conformite2 = $conformite2;

        return $this;
    }

    public function getPreconisation1(): ?string
    {
        return $this->preconisation1;
    }

    public function setPreconisation1(string $preconisation1): self
    {
        $this->preconisation1 = $preconisation1;

        return $this;
    }

    public function getPreconisation2(): ?string
    {
        return $this->preconisation2;
    }

    public function setPreconisation2(string $preconisation2): self
    {
        $this->preconisation2 = $preconisation2;

        return $this;
    }

    public function getRetenu1(): ?string
    {
        return $this->retenu1;
    }

    public function setRetenu1(string $retenu1): self
    {
        $this->retenu1 = $retenu1;

        return $this;
    }

    public function getRetenu2(): ?string
    {
        return $this->retenu2;
    }

    public function setRetenu2(string $retenu2): self
    {
        $this->retenu2 = $retenu2;

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
            $this->parametre->setControleBobinage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleBobinage() !== $this) {
            $parametre->setControleBobinage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
