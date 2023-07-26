<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\LMesureIsolementEssai;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\MesureIsolementEssaiRepository;

#[ORM\Entity(repositoryClass: MesureIsolementEssaiRepository::class)]
class MesureIsolementEssai
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;
    
    #[ORM\Column(nullable: true)]
    private ?float $temp_ambiante = null;

    #[ORM\Column(nullable: true)]
    private ?float $temp_tolerie = null;

    #[ORM\Column(nullable: true)]
    private ?float $hygrometrie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_essais = null;

    #[ORM\OneToMany(mappedBy: 'mesure_isolement_essai', targetEntity: LMesureIsolementEssai::class)]
    private Collection $lMesureIsolementEssais;

    #[ORM\OneToOne(mappedBy: 'mesure_isolement_essai', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function __construct()
    {
        $this->lMesureIsolementEssais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempAmbiante(): ?float
    {
        return $this->temp_ambiante;
    }

    public function setTempAmbiante(?float $temp_ambiante): self
    {
        $this->temp_ambiante = $temp_ambiante;

        return $this;
    }

    public function getTempTolerie(): ?float
    {
        return $this->temp_tolerie;
    }

    public function setTempTolerie(?float $temp_tolerie): self
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

    public function getDateEssais(): ?\DateTimeInterface
    {
        return $this->date_essais;
    }

    public function setDateEssais(?\DateTimeInterface $date_essais): self
    {
        $this->date_essais = $date_essais;

        return $this;
    }
    
    public function isEtat(): ?bool
    { 
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, LMesureIsolementEssai>
     */
    public function getLMesureIsolementEssais(): Collection
    {
        return $this->lMesureIsolementEssais;
    }

    public function addLMesureIsolementEssai(LMesureIsolementEssai $lMesureIsolementEssai): static
    {
        if (!$this->lMesureIsolementEssais->contains($lMesureIsolementEssai)) {
            $this->lMesureIsolementEssais->add($lMesureIsolementEssai);
            $lMesureIsolementEssai->setMesureIsolementEssai($this);
        }

        return $this;
    }

    public function removeLMesureIsolementEssai(LMesureIsolementEssai $lMesureIsolementEssai): static
    {
        if ($this->lMesureIsolementEssais->removeElement($lMesureIsolementEssai)) {
            // set the owning side to null (unless already changed)
            if ($lMesureIsolementEssai->getMesureIsolementEssai() === $this) {
                $lMesureIsolementEssai->setMesureIsolementEssai(null);
            }
        }

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setMesureIsolementEssai(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getMesureIsolementEssai() !== $this) {
            $parametre->setMesureIsolementEssai($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
