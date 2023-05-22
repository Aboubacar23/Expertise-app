<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
class Machine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $sous_categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sous_categorie2 = null;

    #[ORM\Column(length: 255, nullable: true)] 
    private ?string $sous_categorie3 = null;

    #[ORM\OneToMany(mappedBy: 'machine', targetEntity: Parametre::class)]
    private Collection $parametres;

    #[ORM\ManyToOne(inversedBy: 'machines')]
    private ?Type $type = null; 

    public function __construct()
    {
        $this->parametres = new ArrayCollection(); 
    }

    public function __toString()
    {
        return $this->getCategorie(). ' - '.$this->getSousCategorie(). ' - '.$this->getSousCategorie2(). ' - '.$this->getSousCategorie3();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSousCategorie(): ?string
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(string $sous_categorie): self
    {
        $this->sous_categorie = $sous_categorie;

        return $this;
    }

    public function getSousCategorie2(): ?string
    {
        return $this->sous_categorie2;
    }

    public function setSousCategorie2(string $sous_categorie2): self
    {
        $this->sous_categorie2 = $sous_categorie2;

        return $this;
    }

    public function getSousCategorie3(): ?string
    {
        return $this->sous_categorie3;
    }

    public function setSousCategorie3(string $sous_categorie3): self
    {
        $this->sous_categorie3 = $sous_categorie3;

        return $this;
    }

    /**
     * @return Collection<int, Parametre>
     */
    public function getParametres(): Collection
    {
        return $this->parametres;
    }

    public function addParametre(Parametre $parametre): self
    {
        if (!$this->parametres->contains($parametre)) {
            $this->parametres->add($parametre);
            $parametre->setMachine($this);
        }

        return $this;
    }

    public function removeParametre(Parametre $parametre): self
    {
        if ($this->parametres->removeElement($parametre)) {
            // set the owning side to null (unless already changed)
            if ($parametre->getMachine() === $this) {
                $parametre->setMachine(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
