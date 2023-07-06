<?php

namespace App\Entity;

use App\Repository\SynoptiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SynoptiqueRepository::class)]
class Synoptique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $repere = null;

    #[ORM\ManyToOne(inversedBy: 'synoptiques')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepere(): ?string
    {
        return $this->repere;
    }

    public function setRepere(?string $repere): self
    {
        $this->repere = $repere;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
