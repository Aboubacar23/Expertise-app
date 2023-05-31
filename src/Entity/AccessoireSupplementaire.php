<?php

namespace App\Entity;

use App\Repository\AccessoireSupplementaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessoireSupplementaireRepository::class)]
class AccessoireSupplementaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'accessoireSupplementaires')]
    private ?ControleVisuelMecanique $controle_visuel_mecanique = null;

    #[ORM\Column(nullable: true)]
    private ?int $lig = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getControleVisuelMecanique(): ?ControleVisuelMecanique
    {
        return $this->controle_visuel_mecanique;
    }

    public function setControleVisuelMecanique(?ControleVisuelMecanique $controle_visuel_mecanique): self
    {
        $this->controle_visuel_mecanique = $controle_visuel_mecanique;

        return $this;
    }

    public function getLig(): ?int
    {
        return $this->lig;
    }

    public function setLig(?int $lig): self
    {
        $this->lig = $lig;

        return $this;
    }
}
