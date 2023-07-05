<?php

namespace App\Entity;

use App\Repository\ContreExpertiseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContreExpertiseRepository::class)]
class ContreExpertise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $recapitulatif = null;

    #[ORM\OneToOne(mappedBy: 'contre_expertise', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecapitulatif(): ?string
    {
        return $this->recapitulatif;
    }

    public function setRecapitulatif(string $recapitulatif): self
    {
        $this->recapitulatif = $recapitulatif;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setContreExpertise(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getContreExpertise() !== $this) {
            $parametre->setContreExpertise($this);
        }

        $this->parametre = $parametre;

        return $this;
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

    public function __toString()
    {
        return $this->getRecapitulatif();
    }
}
