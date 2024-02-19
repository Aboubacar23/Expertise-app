<?php

namespace App\Entity;

use App\Repository\EtudesAchatsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudesAchatsRepository::class)]
class EtudesAchats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quoi = null;

    #[ORM\Column(nullable: true)]
    private ?float $delai = null;

    #[ORM\Column(length: 255)]
    private ?string $observation = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'etudesAchats')]
    private ?RevueEnclenchement $revue_enclenchement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuoi(): ?string
    {
        return $this->quoi;
    }

    public function setQuoi(string $quoi): self
    {
        $this->quoi = $quoi;

        return $this;
    }

    public function getDelai(): ?float
    {
        return $this->delai;
    }

    public function setDelai(float $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

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

    public function getRevueEnclenchement(): ?RevueEnclenchement
    {
        return $this->revue_enclenchement;
    }

    public function setRevueEnclenchement(?RevueEnclenchement $revue_enclenchement): self
    {
        $this->revue_enclenchement = $revue_enclenchement;

        return $this;
    }
}
