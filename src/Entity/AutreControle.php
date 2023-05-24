<?php

namespace App\Entity;

use App\Repository\AutreControleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutreControleRepository::class)]
class AutreControle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_preconisation6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_preconisation6 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisConformite6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balaisMasseConformite6 = null;

    #[ORM\OneToOne(mappedBy: 'autre_controle', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalaisPreconisation1(): ?string
    {
        return $this->balais_preconisation1;
    }

    public function setBalaisPreconisation1(?string $balais_preconisation1): self
    {
        $this->balais_preconisation1 = $balais_preconisation1;

        return $this;
    }

    public function getBalaisPreconisation2(): ?string
    {
        return $this->balais_preconisation2;
    }

    public function setBalaisPreconisation2(?string $balais_preconisation2): self
    {
        $this->balais_preconisation2 = $balais_preconisation2;

        return $this;
    }

    public function getBalaisPreconisation3(): ?string
    {
        return $this->balais_preconisation3;
    }

    public function setBalaisPreconisation3(?string $balais_preconisation3): self
    {
        $this->balais_preconisation3 = $balais_preconisation3;

        return $this;
    }

    public function getBalaisPreconisation4(): ?string
    {
        return $this->balais_preconisation4;
    }

    public function setBalaisPreconisation4(?string $balais_preconisation4): self
    {
        $this->balais_preconisation4 = $balais_preconisation4;

        return $this;
    }

    public function getBalaisPreconisation5(): ?string
    {
        return $this->balais_preconisation5;
    }

    public function setBalaisPreconisation5(?string $balais_preconisation5): self
    {
        $this->balais_preconisation5 = $balais_preconisation5;

        return $this;
    }

    public function getBalaisPreconisation6(): ?string
    {
        return $this->balais_preconisation6;
    }

    public function setBalaisPreconisation6(?string $balais_preconisation6): self
    {
        $this->balais_preconisation6 = $balais_preconisation6;

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

    public function getBalaisMassePreconisation1() : ?string
    {
        return $this->balais_masse_preconisation1;
    }

    public function setBalaisMassePreconisation1(?string $balais_masse_preconisation1) : self
    {
        $this->balais_masse_preconisation1 = $balais_masse_preconisation1;

        return $this;
    }

    public function getBalaisMassePreconisation2(): ?string
    {
        return $this->balais_masse_preconisation2;
    }

    public function setBalaisMassePreconisation2(?string $balais_masse_preconisation2): self
    {
        $this->balais_masse_preconisation2 = $balais_masse_preconisation2;

        return $this;
    }

    public function getBalaisMassePreconisation3(): ?string
    {
        return $this->balais_masse_preconisation3;
    }

    public function setBalaisMassePreconisation3(?string $balais_masse_preconisation3): self
    {
        $this->balais_masse_preconisation3 = $balais_masse_preconisation3;

        return $this;
    }

    public function getBalaisMassePreconisation4(): ?string
    {
        return $this->balais_masse_preconisation4;
    }

    public function setBalaisMassePreconisation4(?string $balais_masse_preconisation4): self
    {
        $this->balais_masse_preconisation4 = $balais_masse_preconisation4;

        return $this;
    }

    public function getBalaisMassePreconisation5(): ?string
    {
        return $this->balais_masse_preconisation5;
    }

    public function setBalaisMassePreconisation5(?string $balais_masse_preconisation5): self
    {
        $this->balais_masse_preconisation5 = $balais_masse_preconisation5;

        return $this;
    }

    public function getBalaisMassePreconisation6(): ?string
    {
        return $this->balais_masse_preconisation6;
    }

    public function setBalaisMassePreconisation6(?string $balais_masse_preconisation6) : self
    {
        $this->balais_masse_preconisation6 = $balais_masse_preconisation6;

        return $this;
    }

    public function getBalaisConformite1(): ?string
    {
        return $this->balaisConformite1;
    }

    public function setBalaisConformite1(?string $balaisConformite1): self
    {
        $this->balaisConformite1 = $balaisConformite1;

        return $this;
    }

    public function getBalaisConformite2(): ?string
    {
        return $this->balaisConformite2;
    }

    public function setBalaisConformite2(?string $balaisConformite2): self
    {
        $this->balaisConformite2 = $balaisConformite2;

        return $this;
    }

    public function getBalaisConformite3(): ?string
    {
        return $this->balaisConformite3;
    }

    public function setBalaisConformite3(?string $balaisConformite3): self
    {
        $this->balaisConformite3 = $balaisConformite3;

        return $this;
    }

    public function getBalaisConformite4(): ?string
    {
        return $this->balaisConformite4;
    }

    public function setBalaisConformite4(?string $balaisConformite4): self
    {
        $this->balaisConformite4 = $balaisConformite4;

        return $this;
    }

    public function getBalaisConformite5(): ?string
    {
        return $this->balaisConformite5;
    }

    public function setBalaisConformite5(?string $balaisConformite5): self
    {
        $this->balaisConformite5 = $balaisConformite5;

        return $this;
    }

    public function getBalaisConformite6(): ?string
    {
        return $this->balaisConformite6;
    }

    public function setBalaisConformite6(?string $balaisConformite6): self
    {
        $this->balaisConformite6 = $balaisConformite6;

        return $this;
    }

    public function getBalaisMasseConformite1(): ?string
    {
        return $this->balaisMasseConformite1;
    }

    public function setBalaisMasseConformite1(?string $balaisMasseConformite1): self
    {
        $this->balaisMasseConformite1 = $balaisMasseConformite1;

        return $this;
    }

    public function getBalaisMasseConformite2(): ?string
    {
        return $this->balaisMasseConformite2;
    }

    public function setBalaisMasseConformite2(?string $balaisMasseConformite2): self
    {
        $this->balaisMasseConformite2 = $balaisMasseConformite2;

        return $this;
    }

    public function getBalaisMasseConformite3(): ?string
    {
        return $this->balaisMasseConformite3;
    }

    public function setBalaisMasseConformite3(?string $balaisMasseConformite3): self
    {
        $this->balaisMasseConformite3 = $balaisMasseConformite3;

        return $this;
    }

    public function getBalaisMasseConformite4(): ?string
    {
        return $this->balaisMasseConformite4;
    }

    public function setBalaisMasseConformite4(?string $balaisMasseConformite4): self
    {
        $this->balaisMasseConformite4 = $balaisMasseConformite4;

        return $this;
    }

    public function getBalaisMasseConformite5(): ?string
    {
        return $this->balaisMasseConformite5;
    }

    public function setBalaisMasseConformite5(?string $balaisMasseConformite5): self
    {
        $this->balaisMasseConformite5 = $balaisMasseConformite5;

        return $this;
    }

    public function getBalaisMasseConformite6(): ?string
    {
        return $this->balaisMasseConformite6;
    }

    public function setBalaisMasseConformite6(?string $balaisMasseConformite6): self
    {
        $this->balaisMasseConformite6 = $balaisMasseConformite6;

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
            $this->parametre->setAutreControle(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getAutreControle() !== $this) {
            $parametre->setAutreControle($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
