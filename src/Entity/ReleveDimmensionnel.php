<?php

namespace App\Entity;

use App\Repository\ReleveDimmensionnelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReleveDimmensionnelRepository::class)]
class ReleveDimmensionnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $cote_attendue = null;

    #[ORM\Column(length: 255)]
    private ?string $tolerance = null;

    #[ORM\Column(length: 255)]
    private ?string $cote_relevee = null;

    #[ORM\Column(length: 255)]
    private ?string $conformite = null;

    #[ORM\ManyToOne(inversedBy: 'releveDimmensionnels')]
    private ?Parametre $parametre = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getCoteAttendue(): ?string
    {
        return $this->cote_attendue;
    }

    public function setCoteAttendue(string $cote_attendue): self
    {
        $this->cote_attendue = $cote_attendue;

        return $this;
    }

    public function getTolerance(): ?string
    {
        return $this->tolerance;
    }

    public function setTolerance(string $tolerance): self
    {
        $this->tolerance = $tolerance;

        return $this;
    }

    public function getCoteRelevee(): ?string
    {
        return $this->cote_relevee;
    }

    public function setCoteRelevee(string $cote_relevee): self
    {
        $this->cote_relevee = $cote_relevee;

        return $this;
    }

    public function getConformite(): ?string
    {
        return $this->conformite;
    }

    public function setConformite(string $conformite): self
    {
        $this->conformite = $conformite;

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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }
}
