<?php

namespace App\Entity;

use App\Repository\ControleBobinageRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $constat2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controleBobinage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

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

    public function getConstat1(): ?string
    {
        return $this->constat1;
    }

    public function setConstat1(string $constat1): self
    {
        $this->constat1 = $constat1;

        return $this;
    }

    public function getConstat2(): ?string
    {
        return $this->constat2;
    }

    public function setConstat2(string $constat2): self
    {
        $this->constat2 = $constat2;

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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }
}
