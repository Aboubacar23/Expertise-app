<?php

namespace App\Entity;

use App\Repository\SondeBobinageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SondeBobinageRepository::class)]
class SondeBobinage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $temp_ambiante = null;

    #[ORM\Column]
    private ?int $temp_tolerie = null;

    #[ORM\Column]
    private ?float $hygrometrie = null;

    #[ORM\Column]
    private ?float $valeur1 = null;

    #[ORM\Column]
    private ?float $valeur2 = null;

    #[ORM\Column]
    private ?float $valeur3 = null;

    #[ORM\Column]
    private ?float $valeur4 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite1 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite2 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite3 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite4 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'sonde_bobinage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    } 


    public function getTempAmbiante(): ?int
    {
        return $this->temp_ambiante;
    }

    public function setTempAmbiante(?int $temp_ambiante): self
    {
        $this->temp_ambiante = $temp_ambiante;

        return $this;
    }

    public function getTempTolerie(): ?int
    {
        return $this->temp_tolerie;
    }

    public function setTempTolerie(?int $temp_tolerie): self
    {
        $this->temp_tolerie = $temp_tolerie;

        return $this;
    }

    public function getHygrometrie(): ?float
    {
        return $this->hygrometrie;
    }

    public function setHygrometrie(?float $hygrometrie): self
    {
        $this->hygrometrie = $hygrometrie;

        return $this;
    }

    public function getValeur1(): ?float
    {
        return $this->valeur1;
    }

    public function setValeur1(float $valeur1): self
    {
        $this->valeur1 = $valeur1;

        return $this;
    }

    public function getValeur2(): ?float
    {
        return $this->valeur2;
    }

    public function setValeur2(float $valeur2): self
    {
        $this->valeur2 = $valeur2;

        return $this;
    }

    public function getValeur3(): ?float
    {
        return $this->valeur3;
    }

    public function setValeur3(float $valeur3): self
    {
        $this->valeur3 = $valeur3;

        return $this;
    }

    public function getValeur4(): ?float
    {
        return $this->valeur4;
    }

    public function setValeur4(float $valeur4): self
    {
        $this->valeur4 = $valeur4;

        return $this;
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

    public function getConformite3(): ?string
    {
        return $this->conformite3;
    }

    public function setConformite3(string $conformite3): self
    {
        $this->conformite3 = $conformite3;

        return $this;
    }

    public function getConformite4(): ?string
    {
        return $this->conformite4;
    }

    public function setConformite4(string $conformite4): self
    {
        $this->conformite4 = $conformite4;

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
            $this->parametre->setSondeBobinage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getSondeBobinage() !== $this) {
            $parametre->setSondeBobinage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
