<?php

namespace App\Entity;

use App\Repository\ControleVisuelElectriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleVisuelElectriqueRepository::class)]
class ControleVisuelElectrique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_dimension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_marque = null;

    #[ORM\Column(nullable: true)]
    private ?int $balais_quantite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_nuance = null;

    #[ORM\Column(nullable: true)]
    private ?int $balais_longueur_shunt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_type_cosse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_aspect = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_type_pression = null;

    #[ORM\Column(nullable: true)]
    private ?bool $balais_presence_gaine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_dimension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_marque = null;

    #[ORM\Column(nullable: true)]
    private ?int $balais_masse_quantite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_nuance = null;

    #[ORM\Column(nullable: true)]
    private ?int $balais_masse_longueur_shunt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_type_cosse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_aspect = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $balais_masse_type_pression = null;

    #[ORM\Column(nullable: true)]
    private ?bool $balais_masse_presence_gaine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sens_rotation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $remarque = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controleVisuelElectrique', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ?self
    {
        $this->id = $id;
        return $this;
    }

    public function getBalaisDimension(): ?string
    {
        return $this->balais_dimension;
    }

    public function setBalaisDimension(?string $balais_dimension): self
    {
        $this->balais_dimension = $balais_dimension;

        return $this;
    }

    public function getBalaisMarque(): ?string
    {
        return $this->balais_marque;
    }

    public function setBalaisMarque(?string $balais_marque): self
    {
        $this->balais_marque = $balais_marque;

        return $this;
    }

    public function getBalaisQuantite(): ?int
    {
        return $this->balais_quantite;
    }

    public function setBalaisQuantite(?int $balais_quantite): self
    {
        $this->balais_quantite = $balais_quantite;

        return $this;
    }

    public function getBalaisNuance(): ?string
    {
        return $this->balais_nuance;
    }

    public function setBalaisNuance(?string $balais_nuance): self
    {
        $this->balais_nuance = $balais_nuance;

        return $this;
    }

    public function getBalaisLongueurShunt(): ?int
    {
        return $this->balais_longueur_shunt;
    }

    public function setBalaisLongueurShunt(?int $balais_longueur_shunt): self
    {
        $this->balais_longueur_shunt = $balais_longueur_shunt;

        return $this;
    }

    public function getBalaisTypeCosse(): ?string
    {
        return $this->balais_type_cosse;
    }

    public function setBalaisTypeCosse(?string $balais_type_cosse): self
    {
        $this->balais_type_cosse = $balais_type_cosse;

        return $this;
    }

    public function getBalaisAspect(): ?string
    {
        return $this->balais_aspect;
    }

    public function setBalaisAspect(?string $balais_aspect): self
    {
        $this->balais_aspect = $balais_aspect;

        return $this;
    }

    public function getBalaisTypePression(): ?string
    {
        return $this->balais_type_pression;
    }

    public function setBalaisTypePression(?string $balais_type_pression): self
    {
        $this->balais_type_pression = $balais_type_pression;

        return $this;
    }

    public function isBalaisPresenceGaine(): ?bool
    {
        return $this->balais_presence_gaine;
    }

    public function setBalaisPresenceGaine(?bool $balais_presence_gaine): self
    {
        $this->balais_presence_gaine = $balais_presence_gaine;

        return $this;
    }

    public function getBalaisMasseDimension(): ?string
    {
        return $this->balais_masse_dimension;
    }

    public function setBalaisMasseDimension(?string $balais_masse_dimension): self
    {
        $this->balais_masse_dimension = $balais_masse_dimension;

        return $this;
    }

    public function getBalaisMasseMarque(): ?string
    {
        return $this->balais_masse_marque;
    }

    public function setBalaisMasseMarque(?string $balais_masse_marque): self
    {
        $this->balais_masse_marque = $balais_masse_marque;

        return $this;
    }

    public function getBalaisMasseQuantite(): ?int
    {
        return $this->balais_masse_quantite;
    }

    public function setBalaisMasseQuantite(?int $balais_masse_quantite): self
    {
        $this->balais_masse_quantite = $balais_masse_quantite;

        return $this;
    }

    public function getBalaisMasseNuance(): ?string
    {
        return $this->balais_masse_nuance;
    }

    public function setBalaisMasseNuance(?string $balais_masse_nuance): self
    {
        $this->balais_masse_nuance = $balais_masse_nuance;

        return $this;
    }

    public function getBalaisMasseLongueurShunt(): ?int
    {
        return $this->balais_masse_longueur_shunt;
    }

    public function setBalaisMasseLongueurShunt(?int $balais_masse_longueur_shunt): self
    {
        $this->balais_masse_longueur_shunt = $balais_masse_longueur_shunt;

        return $this;
    }

    public function getBalaisMasseTypeCosse(): ?string
    {
        return $this->balais_masse_type_cosse;
    }

    public function setBalaisMasseTypeCosse(?string $balais_masse_type_cosse): self
    {
        $this->balais_masse_type_cosse = $balais_masse_type_cosse;

        return $this;
    }

    public function getBalaisMasseAspect(): ?string
    {
        return $this->balais_masse_aspect;
    }

    public function setBalaisMasseAspect(?string $balais_masse_aspect): self
    {
        $this->balais_masse_aspect = $balais_masse_aspect;

        return $this;
    }

    public function getBalaisMasseTypePression(): ?string
    {
        return $this->balais_masse_type_pression;
    }

    public function setBalaisMasseTypePression(?string $balais_masse_type_pression): self
    {
        $this->balais_masse_type_pression = $balais_masse_type_pression;

        return $this;
    }

    public function isBalaisMassePresenceGaine(): ?bool
    {
        return $this->balais_masse_presence_gaine;
    }

    public function setBalaisMassePresenceGaine(?bool $balais_masse_presence_gaine): self
    {
        $this->balais_masse_presence_gaine = $balais_masse_presence_gaine;

        return $this;
    }

    public function getSensRotation(): ?string
    {
        return $this->sens_rotation;
    }

    public function setSensRotation(?string $sens_rotation): self
    {
        $this->sens_rotation = $sens_rotation;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

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
            $this->parametre->setControleVisuelElectrique(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleVisuelElectrique() !== $this) {
            $parametre->setControleVisuelElectrique($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
