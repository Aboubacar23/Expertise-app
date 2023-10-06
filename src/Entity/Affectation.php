<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationRepository::class)]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    private ?AffaireMetrologie $affaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_affaire = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    private ?ServiceResponsable $service_affectation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_sortie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sortie_par = null;

    #[ORM\Column(nullable: true)]
    private ?bool $retour = null;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: Laffectation::class)]
    private Collection $laffectations;

    #[ORM\OneToOne(mappedBy: 'affectation', cascade: ['persist', 'remove'])]
    private ?RetourAffectation $retourAffectation = null; 

    public function __construct()
    {
        $this->laffectations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffaire(): ?AffaireMetrologie
    {
        return $this->affaire;
    }

    public function setAffaire(?AffaireMetrologie $affaire): static
    {
        $this->affaire = $affaire;

        return $this;
    }

    public function getNomAffaire(): ?string
    {
        return $this->nom_affaire;
    }

    public function setNomAffaire(?string $nom_affaire): static
    {
        $this->nom_affaire = $nom_affaire;

        return $this;
    }

    public function getServiceAffectation(): ?ServiceResponsable
    {
        return $this->service_affectation;
    }

    public function setServiceAffectation(?ServiceResponsable $service_affectation): static
    {
        $this->service_affectation = $service_affectation;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getSortiePar(): ?string
    {
        return $this->sortie_par;
    }

    public function setSortiePar(?string $sortie_par): static
    {
        $this->sortie_par = $sortie_par;

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

    /**
     * @return Collection<int, Laffectation>
     */
    public function getLaffectations(): Collection
    {
        return $this->laffectations;
    }

    public function addLaffectation(Laffectation $laffectation): static
    {
        if (!$this->laffectations->contains($laffectation)) {
            $this->laffectations->add($laffectation);
            $laffectation->setAffectation($this);
        }

        return $this;
    }

    public function removeLaffectation(Laffectation $laffectation): static
    {
        if ($this->laffectations->removeElement($laffectation)) {
            // set the owning side to null (unless already changed)
            if ($laffectation->getAffectation() === $this) {
                $laffectation->setAffectation(null);
            }
        }

        return $this;
    }

    public function getRetourAffectation(): ?RetourAffectation
    {
        return $this->retourAffectation;
    }

    public function addRetourAffectation(?RetourAffectation $retourAffectation): static
    {
        // unset the owning side of the relation if necessary
        if ($retourAffectation === null && $this->retourAffectation !== null) {
            $this->retourAffectation->setAffectation(null);
        } 

        // set the owning side of the relation if necessary
        if ($retourAffectation !== null && $retourAffectation->getAffectation() !== $this) {
            $retourAffectation->setAffectation($this);
        }

        $this->retourAffectation = $retourAffectation;

        return $this;
    }

    public function __toString()
    {
        return $this->getAffaire();
    }
}
