<?php

namespace App\Entity;

use App\Repository\AffaireMetrologieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffaireMetrologieRepository::class)]
class AffaireMetrologie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $num_affaire = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chef_chantier = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    #[ORM\OneToMany(mappedBy: 'affaire', targetEntity: Affectation::class)]
    private Collection $affectations;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAffaire(): ?string
    {
        return $this->num_affaire;
    }

    public function setNumAffaire(string $num_affaire): static
    {
        $this->num_affaire = $num_affaire;

        return $this;
    }

    public function getNomAffaire(): ?string
    {
        return $this->nom_affaire;
    }

    public function setNomAffaire(string $nom_affaire): static
    {
        $this->nom_affaire = $nom_affaire;

        return $this;
    }

    public function getChefChantier(): ?string
    {
        return $this->chef_chantier;
    }

    public function setChefChantier(?string $chef_chantier): static
    {
        $this->chef_chantier = $chef_chantier;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): static
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations->add($affectation);
            $affectation->setAffaire($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getAffaire() === $this) {
                $affectation->setAffaire(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumAffaire();
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
