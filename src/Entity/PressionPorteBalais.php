<?php

namespace App\Entity;

use App\Repository\PressionPorteBalaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PressionPorteBalaisRepository::class)]
class PressionPorteBalais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num_balai = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pression = null;

    #[ORM\ManyToOne(inversedBy: 'pressionPorteBalais')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $critere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumBalai(): ?int
    {
        return $this->num_balai;
    }

    public function setNumBalai(int $num_balai): static
    {
        $this->num_balai = $num_balai;

        return $this;
    }

    public function getPression(): ?string
    {
        return $this->pression;
    }

    public function setPression(?string $pression): static
    {
        $this->pression = $pression;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(?string $critere): static
    {
        $this->critere = $critere;

        return $this;
    }
}
