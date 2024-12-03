<?php

namespace App\Entity;

use App\Repository\SignatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignatureRepository::class)]
class Signature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $exp_avant_lavage = null;

    #[ORM\OneToOne(inversedBy: 'signature', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_exp_avant_lavage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $exp_apres_lavage = null;

    #[ORM\OneToOne(inversedBy: 'signature', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_exp_apres_lavage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $exp_meca = null;

    #[ORM\OneToOne(inversedBy: 'signature', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_exp_meca = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validation_exp = null;

    #[ORM\OneToOne(inversedBy: 'signature', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_validation_exp = null;

    #[ORM\Column(nullable: true)]
    private ?bool $remontage = null;

    #[ORM\OneToOne(inversedBy: 'operateurRemontage', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_remontage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $essai_finaux = null;

    #[ORM\OneToOne(inversedBy: 'operateurEssaiFinaux', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_essai_finaux = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validation_finale = null;

    #[ORM\OneToOne(inversedBy: 'operateurValidationFinale', cascade: ['persist', 'remove'])]
    private ?Admin $operateur_validation_finale = null;

    #[ORM\OneToOne(inversedBy: 'signature', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_exp_avant_lavage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_exp_apres_lavage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_exp_meca = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_remontage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_essai_finaux = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_validation_finale = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_validation_exp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isExpAvantLavage(): ?bool
    {
        return $this->exp_avant_lavage;
    }

    public function setExpAvantLavage(?bool $exp_avant_lavage): static
    {
        $this->exp_avant_lavage = $exp_avant_lavage;

        return $this;
    }

    public function getOperateurExpAvantLavage(): ?Admin
    {
        return $this->operateur_exp_avant_lavage;
    }

    public function setOperateurExpAvantLavage(?Admin $operateur_exp_avant_lavage): static
    {
        $this->operateur_exp_avant_lavage = $operateur_exp_avant_lavage;

        return $this;
    }

    public function isExpApresLavage(): ?bool
    {
        return $this->exp_apres_lavage;
    }

    public function setExpApresLavage(?bool $exp_apres_lavage): static
    {
        $this->exp_apres_lavage = $exp_apres_lavage;

        return $this;
    }

    public function getOperateurExpApresLavage(): ?Admin
    {
        return $this->operateur_exp_apres_lavage;
    }

    public function setOperateurExpApresLavage(?Admin $operateur_exp_apres_lavage): static
    {
        $this->operateur_exp_apres_lavage = $operateur_exp_apres_lavage;

        return $this;
    }

    public function isExpMeca(): ?bool
    {
        return $this->exp_meca;
    }

    public function setExpMeca(?bool $exp_meca): static
    {
        $this->exp_meca = $exp_meca;

        return $this;
    }

    public function getOperateurExpMeca(): ?Admin
    {
        return $this->operateur_exp_meca;
    }

    public function setOperateurExpMeca(?Admin $operateur_exp_meca): static
    {
        $this->operateur_exp_meca = $operateur_exp_meca;

        return $this;
    }

    public function isValidationExp(): ?bool
    {
        return $this->validation_exp;
    }

    public function setValidationExp(?bool $validation_exp): static
    {
        $this->validation_exp = $validation_exp;

        return $this;
    }

    public function getOperateurValidationExp(): ?Admin
    {
        return $this->operateur_validation_exp;
    }

    public function setOperateurValidationExp(?Admin $operateur_validation_exp): static
    {
        $this->operateur_validation_exp = $operateur_validation_exp;

        return $this;
    }

    public function isRemontage(): ?bool
    {
        return $this->remontage;
    }

    public function setRemontage(?bool $remontage): static
    {
        $this->remontage = $remontage;

        return $this;
    }

    public function getOperateurRemontage(): ?Admin
    {
        return $this->operateur_remontage;
    }

    public function setOperateurRemontage(?Admin $operateur_remontage): static
    {
        $this->operateur_remontage = $operateur_remontage;

        return $this;
    }

    public function isEssaiFinaux(): ?bool
    {
        return $this->essai_finaux;
    }

    public function setEssaiFinaux(?bool $essai_finaux): static
    {
        $this->essai_finaux = $essai_finaux;

        return $this;
    }

    public function getOperateurEssaiFinaux(): ?Admin
    {
        return $this->operateur_essai_finaux;
    }

    public function setOperateurEssaiFinaux(?Admin $operateur_essai_finaux): static
    {
        $this->operateur_essai_finaux = $operateur_essai_finaux;

        return $this;
    }

    public function isValidationFinale(): ?bool
    {
        return $this->validation_finale;
    }

    public function setValidationFinale(?bool $validation_finale): static
    {
        $this->validation_finale = $validation_finale;

        return $this;
    }

    public function getOperateurValidationFinale(): ?Admin
    {
        return $this->operateur_validation_finale;
    }

    public function setOperateurValidationFinale(?Admin $operateur_validation_finale): static
    {
        $this->operateur_validation_finale = $operateur_validation_finale;

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

    public function getDateExpAvantLavage(): ?\DateTimeInterface
    {
        return $this->date_exp_avant_lavage;
    }

    public function setDateExpAvantLavage(?\DateTimeInterface $date_exp_avant_lavage): static
    {
        $this->date_exp_avant_lavage = $date_exp_avant_lavage;

        return $this;
    }

    public function getDateExpApresLavage(): ?\DateTimeInterface
    {
        return $this->date_exp_apres_lavage;
    }

    public function setDateExpApresLavage(?\DateTimeInterface $date_exp_apres_lavage): static
    {
        $this->date_exp_apres_lavage = $date_exp_apres_lavage;

        return $this;
    }

    public function getDateExpMeca(): ?\DateTimeInterface
    {
        return $this->date_exp_meca;
    }

    public function setDateExpMeca(?\DateTimeInterface $date_exp_meca): static
    {
        $this->date_exp_meca = $date_exp_meca;

        return $this;
    }

    public function getDateRemontage(): ?\DateTimeInterface
    {
        return $this->date_remontage;
    }

    public function setDateRemontage(?\DateTimeInterface $date_remontage): static
    {
        $this->date_remontage = $date_remontage;

        return $this;
    }

    public function getDateEssaiFinaux(): ?\DateTimeInterface
    {
        return $this->date_essai_finaux;
    }

    public function setDateEssaiFinaux(?\DateTimeInterface $date_essai_finaux): static
    {
        $this->date_essai_finaux = $date_essai_finaux;

        return $this;
    }

    public function getDateValidationFinale(): ?\DateTimeInterface
    {
        return $this->date_validation_finale;
    }

    public function setDateValidationFinale(?\DateTimeInterface $date_validation_finale): static
    {
        $this->date_validation_finale = $date_validation_finale;

        return $this;
    }

    public function getDateValidationExp(): ?\DateTimeInterface
    {
        return $this->date_validation_exp;
    }

    public function setDateValidationExp(?\DateTimeInterface $date_validation_exp): static
    {
        $this->date_validation_exp = $date_validation_exp;

        return $this;
    }
}
