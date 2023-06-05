<?php

namespace App\Entity;

use App\Repository\AppareilMesureMecaniqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppareilMesureMecaniqueRepository::class)]
class AppareilMesureMecanique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureMecaniques')]
    private ?Parametre $parametre = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureMecaniques')]
    private ?Appareil $appareil = null;

    public function getId(): ?int
    {
        return $this->id;
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
        $this->parametre = $parametre;

        return $this;
    }

    public function getAppareil(): ?Appareil
    {
        return $this->appareil;
    }

    public function setAppareil(?Appareil $appareil): self
    {
        $this->appareil = $appareil;

        return $this;
    }
}
