<?php

namespace App\Entity;

use App\Repository\AppareilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    public ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $num_appareil = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_validite = null;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesure::class)]
    private Collection $appareilMesures;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesureMecanique::class)]
    private Collection $appareilMesureMecaniques;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesureElectrique::class)]
    private Collection $appareilMesureElectriques;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: AppareilMesureEssais::class)]
    private Collection $appareilMesureEssais;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_barre = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_serie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\ManyToOne(inversedBy: 'appareils')]
    private ?ServiceResponsable $service_responsable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $affectation = null;

    #[ORM\Column(length: 255)]
    private ?string $periodicite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unite_mesure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $classe_ap = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prix_achat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_da = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_fournisseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_certificat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $classe_definition = null;

    #[ORM\Column(nullable: true)]
    private ?bool $en_tendance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_etat = null;

    #[ORM\Column(length:255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: Lintervention::class)]
    private Collection $linterventions;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: Laffectation::class)]
    private Collection $laffectations;

    #[ORM\OneToMany(mappedBy: 'appareil', targetEntity: Certificat::class)]
    private Collection $certificats;

    #[ORM\Column(length: 255)]
    private ?string $type_service = null;


    public function __construct()
    {
        $this->appareilMesures = new ArrayCollection();
        $this->appareilMesureMecaniques = new ArrayCollection();
        $this->appareilMesureElectriques = new ArrayCollection();
        $this->appareilMesureEssais = new ArrayCollection();
        $this->linterventions = new ArrayCollection();
        $this->laffectations = new ArrayCollection();
        $this->certificats = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, AppareilMesure>
     */
    public function getAppareilMesures(): Collection
    {
        return $this->appareilMesures;
    }

    public function addAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if (!$this->appareilMesures->contains($appareilMesure)) {
            $this->appareilMesures->add($appareilMesure);
            $appareilMesure->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesure(AppareilMesure $appareilMesure): self
    {
        if ($this->appareilMesures->removeElement($appareilMesure)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesure->getAppareil() === $this) {
                $appareilMesure->setAppareil(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getNumAppareil();
    }

    /**
     * @return Collection<int, AppareilMesureMecanique>
     */
    public function getAppareilMesureMecaniques(): Collection
    {
        return $this->appareilMesureMecaniques;
    }

    public function addAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if (!$this->appareilMesureMecaniques->contains($appareilMesureMecanique)) {
            $this->appareilMesureMecaniques->add($appareilMesureMecanique);
            $appareilMesureMecanique->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique): self
    {
        if ($this->appareilMesureMecaniques->removeElement($appareilMesureMecanique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureMecanique->getAppareil() === $this) {
                $appareilMesureMecanique->setAppareil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureElectrique>
     */
    public function getAppareilMesureElectriques(): Collection
    {
        return $this->appareilMesureElectriques;
    }

    public function addAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if (!$this->appareilMesureElectriques->contains($appareilMesureElectrique)) {
            $this->appareilMesureElectriques->add($appareilMesureElectrique);
            $appareilMesureElectrique->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique): self
    {
        if ($this->appareilMesureElectriques->removeElement($appareilMesureElectrique)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureElectrique->getAppareil() === $this) {
                $appareilMesureElectrique->setAppareil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AppareilMesureEssais>
     */
    public function getAppareilMesureEssais(): Collection
    {
        return $this->appareilMesureEssais;
    }

    public function addAppareilMesureEssai(AppareilMesureEssais $appareilMesureEssai): static
    {
        if (!$this->appareilMesureEssais->contains($appareilMesureEssai)) {
            $this->appareilMesureEssais->add($appareilMesureEssai);
            $appareilMesureEssai->setAppareil($this);
        }

        return $this;
    }

    public function removeAppareilMesureEssai(AppareilMesureEssais $appareilMesureEssai): static
    {
        if ($this->appareilMesureEssais->removeElement($appareilMesureEssai)) {
            // set the owning side to null (unless already changed)
            if ($appareilMesureEssai->getAppareil() === $this) {
                $appareilMesureEssai->setAppareil(null);
            }
        }

        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->code_barre;
    }

    public function setCodeBarre(?string $code_barre): static
    {
        $this->code_barre = $code_barre;

        return $this;
    }

    public function getNumeroSerie(): ?string
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie(string $numero_serie): static
    {
        $this->numero_serie = $numero_serie;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getServiceResponsable(): ?ServiceResponsable
    {
        return $this->service_responsable;
    }

    public function setServiceResponsable(?ServiceResponsable $service_responsable): static
    {
        $this->service_responsable = $service_responsable;

        return $this;
    }

    public function getAffectation(): ?string
    {
        return $this->affectation;
    }

    public function setAffectation(?string $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getPeriodicite(): ?string
    {
        return $this->periodicite;
    }

    public function setPeriodicite(string $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getUniteMesure(): ?string
    {
        return $this->unite_mesure;
    }

    public function setUniteMesure(?string $unite_mesure): static
    {
        $this->unite_mesure = $unite_mesure;

        return $this;
    }

    public function getClasseAp(): ?string
    {
        return $this->classe_ap;
    }

    public function setClasseAp(?string $classe_ap): static
    {
        $this->classe_ap = $classe_ap;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(?\DateTimeInterface $date_achat): static
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->prix_achat;
    }

    public function setPrixAchat(?string $prix_achat): static
    {
        $this->prix_achat = $prix_achat;

        return $this;
    }

    public function getNumeroDa(): ?string
    {
        return $this->numero_da;
    }

    public function setNumeroDa(?string $numero_da): static
    {
        $this->numero_da = $numero_da;

        return $this;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nom_fournisseur;
    }

    public function setNomFournisseur(?string $nom_fournisseur): static
    {
        $this->nom_fournisseur = $nom_fournisseur;

        return $this;
    }

    public function getNumeroCertificat(): ?string
    {
        return $this->numero_certificat;
    }

    public function setNumeroCertificat(?string $numero_certificat): static
    {
        $this->numero_certificat = $numero_certificat;

        return $this;
    }

    public function isClasseDefinition(): ?bool
    {
        return $this->classe_definition;
    }

    public function setClasseDefinition(?bool $classe_definition): static
    {
        $this->classe_definition = $classe_definition;

        return $this;
    }

    public function isEnTendance(): ?bool
    {
        return $this->en_tendance;
    }

    public function setEnTendance(?bool $en_tendance): static
    {
        $this->en_tendance = $en_tendance;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateEtat(): ?\DateTimeInterface
    {
        return $this->date_etat;
    }

    public function setDateEtat(?\DateTimeInterface $date_etat): static
    {
        $this->date_etat = $date_etat;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Lintervention>
     */
    public function getLinterventions(): Collection
    {
        return $this->linterventions;
    }

    public function addLintervention(Lintervention $lintervention): static
    {
        if (!$this->linterventions->contains($lintervention)) {
            $this->linterventions->add($lintervention);
            $lintervention->setAppareil($this);
        }

        return $this;
    }

    public function removeLintervention(Lintervention $lintervention): static
    {
        if ($this->linterventions->removeElement($lintervention)) {
            // set the owning side to null (unless already changed)
            if ($lintervention->getAppareil() === $this) {
                $lintervention->setAppareil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Laffectation>
     */
    public function getLaffectations(): Collection
    {
        return $this->laffectations;
    }

    public function addLaffectation(Laffectation $laffectation): static
    {
        if (!$this->laffectations->contains($laffectation)) {
            $this->laffectations->add($laffectation);
            $laffectation->setAppareil($this);
        }

        return $this;
    }

    public function removeLaffectation(Laffectation $laffectation): static
    {
        if ($this->laffectations->removeElement($laffectation)) {
            // set the owning side to null (unless already changed)
            if ($laffectation->getAppareil() === $this) {
                $laffectation->setAppareil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Certificat>
     */
    public function getCertificats(): Collection
    {
        return $this->certificats;
    }

    public function addCertificat(Certificat $certificat): static
    {
        if (!$this->certificats->contains($certificat)) {
            $this->certificats->add($certificat);
            $certificat->setAppareil($this);
        }

        return $this;
    }

    public function removeCertificat(Certificat $certificat): static
    {
        if ($this->certificats->removeElement($certificat)) {
            // set the owning side to null (unless already changed)
            if ($certificat->getAppareil() === $this) {
                $certificat->setAppareil(null);
            }
        }

        return $this;
    }

    public function getTypeService(): ?string
    {
        return $this->type_service;
    }

    public function setTypeService(string $type_service): static
    {
        $this->type_service = $type_service;

        return $this;
    }

}
