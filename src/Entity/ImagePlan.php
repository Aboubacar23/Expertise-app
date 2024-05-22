<?php

namespace App\Entity;

use App\Repository\ImagePlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagePlanRepository::class)]
class ImagePlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_ca = null;

    #[ORM\Column(length: 255)]
    private ?string $image_coa = null;

    #[ORM\OneToOne(inversedBy: 'imagePlan', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageCa(): ?string
    {
        return $this->image_ca;
    }

    public function setImageCa(string $image_ca): static
    {
        $this->image_ca = $image_ca;

        return $this;
    }

    public function getImageCoa(): ?string
    {
        return $this->image_coa;
    }

    public function setImageCoa(string $image_coa): static
    {
        $this->image_coa = $image_coa;

        return $this;
    }

    public function getParametre(): ?Parametre
    {
        return $this->parametre;
    }

    public function setParametre(?Parametre $parametre): static
    {
        $this->parametre = $parametre;

        return $this;
    }
}
