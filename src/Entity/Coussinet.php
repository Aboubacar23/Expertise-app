<?php

namespace App\Entity;

use App\Repository\CoussinetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoussinetRepository::class)]
class Coussinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ref_palier_ca = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ref_palier_coa = null;

    #[ORM\Column(nullable: true)]
    private ?int $num_code_ca = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_ca = null;

    #[ORM\Column(nullable: true)]
    private ?int $num_code_coa = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_coa = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'coussinet', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefPalierCa(): ?string
    {
        return $this->ref_palier_ca;
    }

    public function setRefPalierCa(?string $ref_palier_ca): self
    {
        $this->ref_palier_ca = $ref_palier_ca;

        return $this;
    }

    public function getRefPalierCoa(): ?string
    {
        return $this->ref_palier_coa;
    }

    public function setRefPalierCoa(?string $ref_palier_coa): self
    {
        $this->ref_palier_coa = $ref_palier_coa;

        return $this;
    }

    public function getNumCodeCa(): ?int
    {
        return $this->num_code_ca;
    }

    public function setNumCodeCa(?int $num_code_ca): self
    {
        $this->num_code_ca = $num_code_ca;

        return $this;
    }

    public function getPhotoCa(): ?string
    {
        return $this->photo_ca;
    }

    public function setPhotoCa(?string $photo_ca): self
    {
        $this->photo_ca = $photo_ca;

        return $this;
    }

    public function getNumCodeCoa(): ?int
    {
        return $this->num_code_coa;
    }

    public function setNumCodeCoa(?int $num_code_coa): self
    {
        $this->num_code_coa = $num_code_coa;

        return $this;
    }

    public function getPhotoCoa(): ?string
    {
        return $this->photo_coa;
    }

    public function setPhotoCoa(?string $photo_coa): self
    {
        $this->photo_coa = $photo_coa;

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

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): self
    {
        // unset the owning side of the relation if necessary
        if ($parametre === null && $this->parametre !== null) {
            $this->parametre->setCoussinet(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getCoussinet() !== $this) {
            $parametre->setCoussinet($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
