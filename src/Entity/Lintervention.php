<?php

namespace App\Entity;

use App\Repository\LinterventionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinterventionRepository::class)]
class Lintervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'linterventions', cascade : ["persist"])]
    private ?Appareil $appareil = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $type_intervention = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_retour = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    #[ORM\ManyToOne(inversedBy: 'linterventions',cascade : ["persist"])]
    private ?Intervention $intervention = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getTypeIntervention(): ?string
    {
        return $this->type_intervention;
    }

    public function setTypeIntervention(string $type_intervention): static
    {
        $this->type_intervention = $type_intervention;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTimeInterface $date_retour): static
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getLig(): ?int
    {
        return $this->lig;
    }

    public function setLig(?int $lig): static
    {
        $this->lig = $lig;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): static
    {
        $this->intervention = $intervention;

        return $this;
    }
}
