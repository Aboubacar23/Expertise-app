<?php

namespace App\Entity;

use App\Repository\RemontageEquilibrageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemontageEquilibrageRepository::class)]
class RemontageEquilibrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $vitesse = null;

    #[ORM\Column(nullable: true)]
    private ?float $poids_rotor = null;

    #[ORM\Column(nullable: true)]
    private ?float $vitesse_equilibrage = null;

    #[ORM\Column(nullable: true)]
    private ?float $nb_plan = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualite_equilibrage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $clavette_entiere = null;

    #[ORM\Column(nullable: true)]
    private ?bool $clavette_1_2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $clavette_sans = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca5 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_ca6 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca5 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_ca6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correction = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa5 = null;

    #[ORM\Column(nullable: true)]
    private ?float $sans_plan_coa6 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa5 = null;

    #[ORM\Column(nullable: true)]
    private ?float $avec_plan_coa6 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'remontage_equilibrage', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVitesse(): ?float
    {
        return $this->vitesse;
    }

    public function setVitesse(?float $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getPoidsRotor(): ?float
    {
        return $this->poids_rotor;
    }

    public function setPoidsRotor(?float $poids_rotor): self
    {
        $this->poids_rotor = $poids_rotor;

        return $this;
    }

    public function getVitesseEquilibrage(): ?float
    {
        return $this->vitesse_equilibrage;
    }

    public function setVitesseEquilibrage(?float $vitesse_equilibrage): self
    {
        $this->vitesse_equilibrage = $vitesse_equilibrage;

        return $this;
    }

    public function getNbPlan(): ?float
    {
        return $this->nb_plan;
    }

    public function setNbPlan(?float $nb_plan): self
    {
        $this->nb_plan = $nb_plan;

        return $this;
    }

    public function getQualiteEquilibrage(): ?string
    {
        return $this->qualite_equilibrage;
    }

    public function setQualiteEquilibrage(?string $qualite_equilibrage): self
    {
        $this->qualite_equilibrage = $qualite_equilibrage;

        return $this;
    }

    public function isClavetteEntiere(): ?bool
    {
        return $this->clavette_entiere;
    }

    public function setClavetteEntiere(?bool $clavette_entiere): self
    {
        $this->clavette_entiere = $clavette_entiere;

        return $this;
    }

    public function isClavette12(): ?bool
    {
        return $this->clavette_1_2;
    }

    public function setClavette12(?bool $clavette_1_2): self
    {
        $this->clavette_1_2 = $clavette_1_2;

        return $this;
    }

    public function isClavetteSans(): ?bool
    {
        return $this->clavette_sans;
    }

    public function setClavetteSans(?bool $clavette_sans): self
    {
        $this->clavette_sans = $clavette_sans;

        return $this;
    }

    public function getSansPlanCa1(): ?float
    {
        return $this->sans_plan_ca1;
    }

    public function setSansPlanCa1(?float $sans_plan_ca1): self
    {
        $this->sans_plan_ca1 = $sans_plan_ca1;

        return $this;
    }

    public function getSansPlanCa2(): ?float
    {
        return $this->sans_plan_ca2;
    }

    public function setSansPlanCa2(?float $sans_plan_ca2): self
    {
        $this->sans_plan_ca2 = $sans_plan_ca2;

        return $this;
    }

    public function getSansPlanCa3(): ?float
    {
        return $this->sans_plan_ca3;
    }

    public function setSansPlanCa3(?float $sans_plan_ca3): self
    {
        $this->sans_plan_ca3 = $sans_plan_ca3;

        return $this;
    }

    public function getSansPlanCa4(): ?float
    {
        return $this->sans_plan_ca4;
    }

    public function setSansPlanCa4(?float $sans_plan_ca4): self
    {
        $this->sans_plan_ca4 = $sans_plan_ca4;

        return $this;
    }

    public function getSansPlanCa5(): ?float
    {
        return $this->sans_plan_ca5;
    }

    public function setSansPlanCa5(?float $sans_plan_ca5): self
    {
        $this->sans_plan_ca5 = $sans_plan_ca5;

        return $this;
    }

    public function getSansPlanCa6(): ?float
    {
        return $this->sans_plan_ca6;
    }

    public function setSansPlanCa6(?float $sans_plan_ca6): self
    {
        $this->sans_plan_ca6 = $sans_plan_ca6;

        return $this;
    }

    public function getCorrection(): ?string
    {
        return $this->correction;
    }

    public function setCorrection(?string $correction): self
    {
        $this->correction = $correction;

        return $this;
    }

    public function getSansPlanCoa1(): ?float
    {
        return $this->sans_plan_coa1;
    }

    public function setSansPlanCoa1(?float $sans_plan_coa1): self
    {
        $this->sans_plan_coa1 = $sans_plan_coa1;

        return $this;
    }

    public function getSansPlanCoa2(): ?float
    {
        return $this->sans_plan_coa2;
    }

    public function setSansPlanCoa2(?float $sans_plan_coa2): self
    {
        $this->sans_plan_coa2 = $sans_plan_coa2;

        return $this;
    }

    public function getSansPlanCoa3(): ?float
    {
        return $this->sans_plan_coa3;
    }

    public function setSansPlanCoa3(?float $sans_plan_coa3): self
    {
        $this->sans_plan_coa3 = $sans_plan_coa3;

        return $this;
    }

    public function getSansPlanCoa4(): ?float
    {
        return $this->sans_plan_coa4;
    }

    public function setSansPlanCoa4(?float $sans_plan_coa4): self
    {
        $this->sans_plan_coa4 = $sans_plan_coa4;

        return $this;
    }

    public function getSansPlanCoa5(): ?float
    {
        return $this->sans_plan_coa5;
    }

    public function setSansPlanCoa5(?float $sans_plan_coa5): self
    {
        $this->sans_plan_coa5 = $sans_plan_coa5;

        return $this;
    }

    public function getSansPlanCoa6(): ?float
    {
        return $this->sans_plan_coa6;
    }

    public function setSansPlanCoa6(?float $sans_plan_coa6): self
    {
        $this->sans_plan_coa6 = $sans_plan_coa6;

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


    public function getAvecPlanCa1(): ?float
    {
        return $this->avec_plan_ca1;
    }

    public function setAvecPlanCa1(?float $avec_plan_ca1): self
    {
        $this->avec_plan_ca1 = $avec_plan_ca1;

        return $this;
    }

    public function getAvecPlanCa2(): ?float
    {
        return $this->avec_plan_ca2;
    }

    public function setAvecPlanCa2(?float $avec_plan_ca2): self
    {
        $this->avec_plan_ca2 = $avec_plan_ca2;

        return $this;
    }

    public function getAvecPlanCa3(): ?float
    {
        return $this->avec_plan_ca3;
    }

    public function setAvecPlanCa3(?float $avec_plan_ca3): self
    {
        $this->avec_plan_ca3 = $avec_plan_ca3;

        return $this;
    }

    public function getAvecPlanCa4(): ?float
    {
        return $this->avec_plan_ca4;
    }

    public function setAvecPlanCa4(?float $avec_plan_ca4): self
    {
        $this->avec_plan_ca4 = $avec_plan_ca4;

        return $this;
    }

    public function getAvecPlanCa5(): ?float
    {
        return $this->avec_plan_ca5;
    }

    public function setAvecPlanCa5(?float $avec_plan_ca5): self
    {
        $this->avec_plan_ca5 = $avec_plan_ca5;

        return $this;
    }

    public function getAvecPlanCa6(): ?float
    {
        return $this->avec_plan_ca6;
    }

    public function setAvecPlanCa6(?float $avec_plan_ca6): self
    {
        $this->avec_plan_ca6 = $avec_plan_ca6;

        return $this;
    }

    public function getAvecPlanCoa1(): ?float
    {
        return $this->avec_plan_coa1;
    }

    public function setAvecPlanCoa1(?float $avec_plan_coa1): self
    {
        $this->avec_plan_coa1 = $avec_plan_coa1;

        return $this;
    }

    public function getAvecPlanCoa2(): ?float
    {
        return $this->avec_plan_coa2;
    }

    public function setAvecPlanCoa2(?float $avec_plan_coa2): self
    {
        $this->avec_plan_coa2 = $avec_plan_coa2;

        return $this;
    }

    public function getAvecPlanCoa3(): ?float
    {
        return $this->avec_plan_coa3;
    }

    public function setAvecPlanCoa3(?float $avec_plan_coa3): self
    {
        $this->avec_plan_coa3 = $avec_plan_coa3;

        return $this;
    }

    public function getAvecPlanCoa4(): ?float
    {
        return $this->avec_plan_coa4;
    }

    public function setAvecPlanCoa4(?float $avec_plan_coa4): self
    {
        $this->avec_plan_coa4 = $avec_plan_coa4;

        return $this;
    }

    public function getAvecPlanCoa5(): ?float
    {
        return $this->avec_plan_coa5;
    }

    public function setAvecPlanCoa5(?float $avec_plan_coa5): self
    {
        $this->avec_plan_coa5 = $avec_plan_coa5;

        return $this;
    }

    public function getAvecPlanCoa6(): ?float
    {
        return $this->avec_plan_coa6;
    }

    public function setAvecPlanCoa6(?float $avec_plan_coa6): self
    {
        $this->avec_plan_coa6 = $avec_plan_coa6;

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
            $this->parametre->setRemontageEquilibrage(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getRemontageEquilibrage() !== $this) {
            $parametre->setRemontageEquilibrage($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
