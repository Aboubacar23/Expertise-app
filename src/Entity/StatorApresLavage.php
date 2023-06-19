<?php

namespace App\Entity;

use App\Repository\StatorApresLavageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatorApresLavageRepository::class)]
class StatorApresLavage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $temp_ambiante = null;

    #[ORM\Column(nullable: true)]
    private ?int $temp_tolerie = null;

    #[ORM\Column(nullable: true)]
    private ?float $hygrometrie = null;
 
    #[ORM\Column]
    private ?float $valeur1 = null;

    #[ORM\Column]
    private ?float $valeur2 = null;

    #[ORM\Column]
    private ?float $valeur3 = null;

    #[ORM\Column]
    private ?float $valeur4 = null;

    #[ORM\Column]
    private ?float $valeur5 = null;

    #[ORM\Column]
    private ?float $valeur6 = null;

    #[ORM\Column]
    private ?float $valeur7 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite1 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite2 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite3 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite4 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite5 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite6 = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite7 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'stator_apres_lavage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\OneToMany(mappedBy: 'stator_apres_lavage', targetEntity: LStatorApresLavage::class)]
    private Collection $lStatorApresLavages;

    public function __construct()
    {
        $this->lStatorApresLavages = new ArrayCollection();
    }

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

    public function getValeur5(): ?float
    {
        return $this->valeur5;
    }

    public function setValeur5(float $valeur5): self
    {
        $this->valeur5 = $valeur5;

        return $this;
    }

    public function getValeur6(): ?float
    {
        return $this->valeur6;
    }

    public function setValeur6(float $valeur6): self
    {
        $this->valeur6 = $valeur6;

        return $this;
    }

    public function getValeur7(): ?float
    {
        return $this->valeur7;
    }

    public function setValeur7(float $valeur7): self
    {
        $this->valeur7 = $valeur7;

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

    public function getConformite5(): ?string
    {
        return $this->conformite5;
    }

    public function setConformite5(string $conformite5): self
    {
        $this->conformite5 = $conformite5;

        return $this;
    }

    public function getConformite6(): ?string
    {
        return $this->conformite6;
    }

    public function setConformite6(string $conformite6): self
    {
        $this->conformite6 = $conformite6;

        return $this;
    }

    public function getConformite7(): ?string
    {
        return $this->conformite7;
    }

    public function setConformite7(string $conformite7): self
    {
        $this->conformite7 = $conformite7;

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
            $this->parametre->setStatorApresLavage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getStatorApresLavage() !== $this) {
            $parametre->setStatorApresLavage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    /**
     * @return Collection<int, LStatorApresLavage>
     */
    public function getLStatorApresLavages(): Collection
    {
        return $this->lStatorApresLavages;
    }

    public function addLStatorApresLavage(LStatorApresLavage $lStatorApresLavage): self
    {
        if (!$this->lStatorApresLavages->contains($lStatorApresLavage)) {
            $this->lStatorApresLavages->add($lStatorApresLavage);
            $lStatorApresLavage->setStatorApresLavage($this);
        }

        return $this;
    }

    public function removeLStatorApresLavage(LStatorApresLavage $lStatorApresLavage): self
    {
        if ($this->lStatorApresLavages->removeElement($lStatorApresLavage)) {
            // set the owning side to null (unless already changed)
            if ($lStatorApresLavage->getStatorApresLavage() === $this) {
                $lStatorApresLavage->setStatorApresLavage(null);
            }
        }

        return $this;
    }
}
