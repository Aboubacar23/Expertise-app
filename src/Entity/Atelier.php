<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $operations = null;

    #[ORM\Column(length: 255)]
    private ?string $travaux = null;

    #[ORM\Column]
    private ?float $heures = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    private ?RevueEnclenchement $revue_enclenchement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperations(): ?string
    {
        return $this->operations;
    }

    public function setOperations(string $operations): self
    {
        $this->operations = $operations;

        return $this;
    }

    public function getTravaux(): ?string
    {
        return $this->travaux;
    }

    public function setTravaux(string $travaux): self
    {
        $this->travaux = $travaux;

        return $this;
    }

    public function getHeures(): ?float
    {
        return $this->heures;
    }

    public function setHeures(float $heures): self
    {
        $this->heures = $heures;

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
