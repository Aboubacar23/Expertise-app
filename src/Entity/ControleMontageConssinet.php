<?php

namespace App\Entity;

use App\Repository\ControleMontageConssinetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControleMontageConssinetRepository::class)]
class ControleMontageConssinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_avant1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_avant2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_avant3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_arriere1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_arriere2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_arriere3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_avant1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_avant2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_avant3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_arriere1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_arriere2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accouplement_oppose_arriere3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_nature_releve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_diametre_attendu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_tolerence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_moyenne_releve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_conformite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ca_observation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_nature_releve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_diametre_attendu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_tolerance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_moyenne_releve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_conformite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coa_observation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'controle_montage_coussinet', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    #[ORM\Column(nullable: true)]
    private ?float $d1 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d5 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d6 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d7 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d8 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d9 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d10 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d11 = null;

    #[ORM\Column(nullable: true)]
    private ?float $d12 = null;

    #[ORM\Column(nullable: true)]
    private ?float $longueur_accouplement = null;

    #[ORM\Column(nullable: true)]
    private ?float $longueur_opp_accouplement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccouplementAvant1(): ?string
    {
        return $this->accouplement_avant1;
    }

    public function setAccouplementAvant1(?string $accouplement_avant1): self
    {
        $this->accouplement_avant1 = $accouplement_avant1;

        return $this;
    }

    public function getAccouplementAvant2(): ?string
    {
        return $this->accouplement_avant2;
    }

    public function setAccouplementAvant2(?string $accouplement_avant2): self
    {
        $this->accouplement_avant2 = $accouplement_avant2;

        return $this;
    }

    public function getAccouplementAvant3(): ?string
    {
        return $this->accouplement_avant3;
    }

    public function setAccouplementAvant3(?string $accouplement_avant3): self
    {
        $this->accouplement_avant3 = $accouplement_avant3;

        return $this;
    }

    public function getAccouplementArriere1(): ?string
    {
        return $this->accouplement_arriere1;
    }

    public function setAccouplementArriere1(?string $accouplement_arriere1): self
    {
        $this->accouplement_arriere1 = $accouplement_arriere1;

        return $this;
    }

    public function getAccouplementArriere2(): ?string
    {
        return $this->accouplement_arriere2;
    }

    public function setAccouplementArriere2(?string $accouplement_arriere2): self
    {
        $this->accouplement_arriere2 = $accouplement_arriere2;

        return $this;
    }

    public function getAccouplementArriere3(): ?string
    {
        return $this->accouplement_arriere3;
    }

    public function setAccouplementArriere3(?string $accouplement_arriere3): self
    {
        $this->accouplement_arriere3 = $accouplement_arriere3;

        return $this;
    }

    public function getAccouplementOpposeAvant1(): ?string
    {
        return $this->accouplement_oppose_avant1;
    }

    public function setAccouplementOpposeAvant1(?string $accouplement_oppose_avant1): self
    {
        $this->accouplement_oppose_avant1 = $accouplement_oppose_avant1;

        return $this;
    }

    public function getAccouplementOpposeAvant2(): ?string
    {
        return $this->accouplement_oppose_avant2;
    }

    public function setAccouplementOpposeAvant2(?string $accouplement_oppose_avant2): self
    {
        $this->accouplement_oppose_avant2 = $accouplement_oppose_avant2;

        return $this;
    }

    public function getAccouplementOpposeAvant3(): ?string
    {
        return $this->accouplement_oppose_avant3;
    }

    public function setAccouplementOpposeAvant3(?string $accouplement_oppose_avant3): self
    {
        $this->accouplement_oppose_avant3 = $accouplement_oppose_avant3;

        return $this;
    }

    public function getAccouplementOpposeArriere1(): ?string
    {
        return $this->accouplement_oppose_arriere1;
    }

    public function setAccouplementOpposeArriere1(?string $accouplement_oppose_arriere1): self
    {
        $this->accouplement_oppose_arriere1 = $accouplement_oppose_arriere1;

        return $this;
    }

    public function getAccouplementOpposeArriere2(): ?string
    {
        return $this->accouplement_oppose_arriere2;
    }

    public function setAccouplementOpposeArriere2(?string $accouplement_oppose_arriere2): self
    {
        $this->accouplement_oppose_arriere2 = $accouplement_oppose_arriere2;

        return $this;
    }

    public function getAccouplementOpposeArriere3(): ?string
    {
        return $this->accouplement_oppose_arriere3;
    }

    public function setAccouplementOpposeArriere3(?string $accouplement_oppose_arriere3): self
    {
        $this->accouplement_oppose_arriere3 = $accouplement_oppose_arriere3;

        return $this;
    }

    public function getCaNatureReleve(): ?string
    {
        return $this->ca_nature_releve;
    }

    public function setCaNatureReleve(?string $ca_nature_releve): self
    {
        $this->ca_nature_releve = $ca_nature_releve;

        return $this;
    }

    public function getCaDiametreAttendu(): ?string
    {
        return $this->ca_diametre_attendu;
    }

    public function setCaDiametreAttendu(?string $ca_diametre_attendu): self
    {
        $this->ca_diametre_attendu = $ca_diametre_attendu;

        return $this;
    }

    public function getCaTolerence(): ?string
    {
        return $this->ca_tolerence;
    }

    public function setCaTolerence(?string $ca_tolerence): self
    {
        $this->ca_tolerence = $ca_tolerence;

        return $this;
    }

    public function getCaMoyenneReleve(): ?string
    {
        return $this->ca_moyenne_releve;
    }

    public function setCaMoyenneReleve(?string $ca_moyenne_releve): self
    {
        $this->ca_moyenne_releve = $ca_moyenne_releve;

        return $this;
    }

    public function getCaConformite(): ?string
    {
        return $this->ca_conformite;
    }

    public function setCaConformite(?string $ca_conformite): self
    {
        $this->ca_conformite = $ca_conformite;

        return $this;
    }

    public function getCaObservation(): ?string
    {
        return $this->ca_observation;
    }

    public function setCaObservation(?string $ca_observation): self
    {
        $this->ca_observation = $ca_observation;

        return $this;
    }

    public function getCoaNatureReleve(): ?string
    {
        return $this->coa_nature_releve;
    }

    public function setCoaNatureReleve(?string $coa_nature_releve): self
    {
        $this->coa_nature_releve = $coa_nature_releve;

        return $this;
    }

    public function getCoaDiametreAttendu(): ?string
    {
        return $this->coa_diametre_attendu;
    }

    public function setCoaDiametreAttendu(?string $coa_diametre_attendu): self
    {
        $this->coa_diametre_attendu = $coa_diametre_attendu;

        return $this;
    }

    public function getCoaTolerance(): ?string
    {
        return $this->coa_tolerance;
    }

    public function setCoaTolerance(?string $coa_tolerance): self
    {
        $this->coa_tolerance = $coa_tolerance;

        return $this;
    }

    public function getCoaMoyenneReleve(): ?string
    {
        return $this->coa_moyenne_releve;
    }

    public function setCoaMoyenneReleve(?string $coa_moyenne_releve): self
    {
        $this->coa_moyenne_releve = $coa_moyenne_releve;

        return $this;
    }

    public function getCoaConformite(): ?string
    {
        return $this->coa_conformite;
    }

    public function setCoaConformite(?string $coa_conformite): self
    {
        $this->coa_conformite = $coa_conformite;

        return $this;
    }

    public function getCoaObservation(): ?string
    {
        return $this->coa_observation;
    }

    public function setCoaObservation(?string $coa_observation): self
    {
        $this->coa_observation = $coa_observation;

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
            $this->parametre->setControleMontageCoussinet(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getControleMontageCoussinet() !== $this) {
            $parametre->setControleMontageCoussinet($this);
        }

        $this->parametre = $parametre;

        return $this;
    }

    public function getD1(): ?float
    {
        return $this->d1;
    }

    public function setD1(?float $d1): self
    {
        $this->d1 = $d1;

        return $this;
    }

    public function getD2(): ?float
    {
        return $this->d2;
    }

    public function setD2(?float $d2): self
    {
        $this->d2 = $d2;

        return $this;
    }

    public function getD3(): ?float
    {
        return $this->d3;
    }

    public function setD3(?float $d3): self
    {
        $this->d3 = $d3;

        return $this;
    }

    public function getD4(): ?float
    {
        return $this->d4;
    }

    public function setD4(?float $d4): self
    {
        $this->d4 = $d4;

        return $this;
    }

    public function getD5(): ?float
    {
        return $this->d5;
    }

    public function setD5(?float $d5): self
    {
        $this->d5 = $d5;

        return $this;
    }

    public function getD6(): ?float
    {
        return $this->d6;
    }

    public function setD6(?float $d6): self
    {
        $this->d6 = $d6;

        return $this;
    }

    public function getD7(): ?float
    {
        return $this->d7;
    }

    public function setD7(?float $d7): self
    {
        $this->d7 = $d7;

        return $this;
    }

    public function getD8(): ?float
    {
        return $this->d8;
    }

    public function setD8(?float $d8): self
    {
        $this->d8 = $d8;

        return $this;
    }

    public function getD9(): ?float
    {
        return $this->d9;
    }

    public function setD9(?float $d9): self
    {
        $this->d9 = $d9;

        return $this;
    }

    public function getD10(): ?float
    {
        return $this->d10;
    }

    public function setD10(?float $d10): self
    {
        $this->d10 = $d10;

        return $this;
    }

    public function getD11(): ?float
    {
        return $this->d11;
    }

    public function setD11(?float $d11): self
    {
        $this->d11 = $d11;

        return $this;
    }

    public function getD12(): ?float
    {
        return $this->d12;
    }

    public function setD12(?float $d12): self
    {
        $this->d12 = $d12;

        return $this;
    }

    public function getLongueurAccouplement(): ?float
    {
        return $this->longueur_accouplement;
    }

    public function setLongueurAccouplement(?float $longueur_accouplement): self
    {
        $this->longueur_accouplement = $longueur_accouplement;

        return $this;
    }

    public function getLongueurOppAccouplement(): ?float
    {
        return $this->longueur_opp_accouplement;
    }

    public function setLongueurOppAccouplement(?float $longueur_opp_accouplement): self
    {
        $this->longueur_opp_accouplement = $longueur_opp_accouplement;

        return $this;
    }
}
