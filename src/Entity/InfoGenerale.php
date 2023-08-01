<?php

namespace App\Entity;

use App\Repository\InfoGeneraleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoGeneraleRepository::class)]
class InfoGenerale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\OneToOne(mappedBy: 'info_generale', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setInfoGenerale(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getInfoGenerale() !== $this) {
            $parametre->setInfoGenerale($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
