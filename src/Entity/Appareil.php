<?php

namespace App\Entity;

use App\Repository\AppareilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppareilRepository::class)]
class Appareil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $num_appareil = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_validite = null;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesure::class)]
    private Collection $appareilMesures;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesureMecanique::class)]
    private Collection $appareilMesureMecaniques;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesureElectrique::class)]
    private Collection $appareilMesureElectriques;


    public function __construct()
    {
        $this->appareilMesures = new ArrayCollection();
        $this->appareilMesureMecaniques = new ArrayCollection();
        $this->appareilMesureElectriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getNumAppareil(): ?string
    {
        return $this->num_appareil;
    }

    public function setNumAppareil(string $num_appareil): self
    {
        $this->num_appareil = $num_appareil;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->date_validite;
    }

    public function setDateValidite(\DateTimeInterface $date_validite): self
    {
        $this->date_validite = $date_validite;

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesure>
     */
    public function getAppareilMesures(): Collection
    {
        return $this->appareilMesures;
    }

    public function addAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if (!$this->appareilMesures->contains($appareilMesure)) {
            $this->appareilMesures->add($appareilMesure);
            $appareilMesure->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if ($this->appareilMesures->removeElement($appareilMesure)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesure->getAppareil() === $this) {
                $appareilMesure->setAppareil(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getDesignation().' - '.$this->getNumAppareil(). ' - '.$this->getDateValidite()->format('Y-m-d');
    }

    /**
     * @return Collection<int, AppareilMesureMecanique>
     */
    public function getAppareilMesureMecaniques(): Collection
    {
        return $this->appareilMesureMecaniques;
    }

    public function addAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if (!$this->appareilMesureMecaniques->contains($appareilMesureMecanique)) {
            $this->appareilMesureMecaniques->add($appareilMesureMecanique);
            $appareilMesureMecanique->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if ($this->appareilMesureMecaniques->removeElement($appareilMesureMecanique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureMecanique->getAppareil() === $this) {
                $appareilMesureMecanique->setAppareil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureElectrique>
     */
    public function getAppareilMesureElectriques(): Collection
    {
        return $this->appareilMesureElectriques;
    }

    public function addAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if (!$this->appareilMesureElectriques->contains($appareilMesureElectrique)) {
            $this->appareilMesureElectriques->add($appareilMesureElectrique);
            $appareilMesureElectrique->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if ($this->appareilMesureElectriques->removeElement($appareilMesureElectrique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureElectrique->getAppareil() === $this) {
                $appareilMesureElectrique->setAppareil(null);
            }
        }

        return $this;
    }

}
