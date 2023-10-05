<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_da = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_da = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_envoi = null;

    #[ORM\Column(length: 255)]
    private ?string $demandeur = null;

    #[ORM\Column(length: 255)]
    private ?string $prestataire = null;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: Lintervention::class)]
    private Collection $linterventions;

    #[ORM\OneToOne(mappedBy: 'intervention', cascade: ['persist', 'remove'])]
    private ?RetourIntervention $retourIntervention = null;

    #[ORM\Column(nullable: true)]
    private ?bool $retour = null;

    public function __construct()
    {
        $this->linterventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroDa(): ?string
    {
        return $this->numero_da;
    }

    public function setNumeroDa(?string $numero_da): static
    {
        $this->numero_da = $numero_da;

        return $this;
    }

    public function getDateDa(): ?\DateTimeInterface
    {
        return $this->date_da;
    }

    public function setDateDa(\DateTimeInterface $date_da): static
    {
        $this->date_da = $date_da;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi(\DateTimeInterface $date_envoi): static
    {
        $this->date_envoi = $date_envoi;

        return $this;
    }

    public function getDemandeur(): ?string
    {
        return $this->demandeur;
    }

    public function setDemandeur(string $demandeur): static
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    public function getPrestataire(): ?string
    {
        return $this->prestataire;
    }

    public function setPrestataire(string $prestataire): static
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    /**
     * @return Collection<int, Lintervention>
     */
    public function getLinterventions(): Collection
    {
        return $this->linterventions;
    }

    public function addLintervention(Lintervention $lintervention): static
    {
        if (!$this->linterventions->contains($lintervention)) {
            $this->linterventions->add($lintervention);
            $lintervention->setIntervention($this);
        }

        return $this;
    }

    public function removeLintervention(Lintervention $lintervention): static
    {
        if ($this->linterventions->removeElement($lintervention)) {
            // set the owning side to null (unless already changed)
            if ($lintervention->getIntervention() === $this) {
                $lintervention->setIntervention(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumeroDa();
    }

    public function getRetourIntervention(): ?RetourIntervention
    {
        return $this->retourIntervention;
    }

    public function setRetourIntervention(?RetourIntervention $retourIntervention): static
    {
        // unset the owning side of the relation if necessary
        if ($retourIntervention === null && $this->retourIntervention !== null) {
            $this->retourIntervention->setIntervention(null);
        }

        // set the owning side of the relation if necessary
        if ($retourIntervention !== null && $retourIntervention->getIntervention() !== $this) {
            $retourIntervention->setIntervention($this);
        }

        $this->retourIntervention = $retourIntervention;

        return $this;
    }

    public function isRetour(): ?bool
    {
        return $this->retour;
    }

    public function setRetour(?bool $retour): static
    {
        $this->retour = $retour;

        return $this;
    }
}
