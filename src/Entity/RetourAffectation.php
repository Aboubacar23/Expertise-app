<?php

namespace App\Entity;

use App\Repository\RetourAffectationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetourAffectationRepository::class)]
class RetourAffectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'retourAffectation', cascade: ['persist', 'remove'])]
    private ?Affectation $affectation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retour_saisie_par = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_sortie = null;

    public function getId(): ?int
    {
        return $this->id; 
    }

    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    public function setAffectation(?Affectation $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getRetourSaisiePar(): ?string
    {
        return $this->retour_saisie_par;
    }

    public function setRetourSaisiePar(?string $retour_saisie_par): static
    {
        $this->retour_saisie_par = $retour_saisie_par;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }
}
