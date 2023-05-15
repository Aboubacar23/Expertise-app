<?php

namespace App\Entity;

use App\Repository\MachineRepository;
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
}
