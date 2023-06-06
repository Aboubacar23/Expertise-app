<?php

namespace App\Entity;

use App\Repository\ConstatElectriqueApresLavageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConstatElectriqueApresLavageRepository::class)]
class ConstatElectriqueApresLavage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $verification = null;

    #[ORM\Column(length: 255)]
    private ?string $critere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preconisation_conclusion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'constatElectriqueApresLavages')]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVerification(): ?string
    {
        return $this->verification;
    }

    public function setVerification(?string $verification): self
    {
        $this->verification = $verification;

        return $this;
    }

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(string $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getPreconisationConclusion(): ?string
    {
        return $this->preconisation_conclusion;
    }

    public function setPreconisationConclusion(?string $preconisation_conclusion): self
    {
        $this->preconisation_conclusion = $preconisation_conclusion;

        return $this;
    }

    public function getRetenu(): ?string
    {
        return $this->retenu;
    }

    public function setRetenu(?string $retenu): self
    {
        $this->retenu = $retenu;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
}
