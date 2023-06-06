<?php

namespace App\Entity;

use App\Repository\AppareilMesureElectriqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppareilMesureElectriqueRepository::class)]
class AppareilMesureElectrique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureElectriques')]
    private ?Parametre $parametre = null;

    #[ORM\ManyToOne(inversedBy: 'appareilMesureElectriques')]
    private ?Appareil $appareil = null;

    public function getId(): ?int
    {
        return $this->id;
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
