<?php

namespace App\Entity;

use App\Repository\AppareilRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppareilRepository::class)]
class Appareil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $num_appareil = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_validite = null;

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

    public function getNumAppareil(): ?string
    {
        return $this->num_appareil;
    }

    public function setNumAppareil(string $num_appareil): self
    {
        $this->num_appareil = $num_appareil;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->date_validite;
    }

    public function setDateValidite(\DateTimeInterface $date_validite): self
    {
        $this->date_validite = $date_validite;

        return $this;
    }
}
