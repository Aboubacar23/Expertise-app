<?php

namespace App\Entity;

use App\Repository\ServiceResponsableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceResponsableRepository::class)]
class ServiceResponsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_service = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'sercice_responsable', targetEntity: Appareil::class)]
    private Collection $appareils;

    #[ORM\OneToMany(mappedBy: 'service_affectation', targetEntity: Affectation::class)]
    private Collection $date_sortie;

    public function __construct()
    {
        $this->appareils = new ArrayCollection();
        $this->date_sortie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroService(): ?string
    {
        return $this->numero_service;
    }

    public function setNumeroService(string $numero_service): static
    {
        $this->numero_service = $numero_service;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Appareil>
     */
    public function getAppareils(): Collection
    {
        return $this->appareils;
    }

    public function addAppareil(Appareil $appareil): static
    {
        if (!$this->appareils->contains($appareil)) {
            $this->appareils->add($appareil);
            $appareil->setServiceResponsable($this);
        }

        return $this;
    }

    public function removeAppareil(Appareil $appareil): static
    {
        if ($this->appareils->removeElement($appareil)) {
            // set the owning side to null (unless already changed)
            if ($appareil->getServiceResponsable() === $this) {
                $appareil->setServiceResponsable(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getDateSortie(): Collection
    {
        return $this->date_sortie;
    }

    public function addDateSortie(Affectation $dateSortie): static
    {
        if (!$this->date_sortie->contains($dateSortie)) {
            $this->date_sortie->add($dateSortie);
            $dateSortie->setServiceAffectation($this);
        }

        return $this;
    }

    public function removeDateSortie(Affectation $dateSortie): static
    {
        if ($this->date_sortie->removeElement($dateSortie)) {
            // set the owning side to null (unless already changed)
            if ($dateSortie->getServiceAffectation() === $this) {
                $dateSortie->setServiceAffectation(null);
            }
        }

        return $this;
    }
}
