<?php

namespace App\Entity;

use App\Repository\AppareilMesureEssaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppareilMesureEssaisRepository::class)]
class AppareilMesureEssais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureEssais')]
    private ?Parametre $parametre = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureEssais')]
    private ?Appareil $appareil = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAppareil(): ?Appareil
    {
        return $this->appareil;
    }

    public function setAppareil(?Appareil $appareil): static
    {
        $this->appareil = $appareil;

        return $this;
    }
}
