<?php

namespace App\Entity;

use App\Repository\RevueEnclenchementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RevueEnclenchementRepository::class)]
class RevueEnclenchement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_contrat = null;

    #[ORM\Column(length: 255)]
    private ?string $cahier_charge = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_pcq = null;

    #[ORM\Column(length: 255)]
    private ?string $amiante = null;

    #[ORM\Column(length: 255)]
    private ?string $contre_expertise = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $re7_client = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $delai_demande_client = null;

    #[ORM\Column(length: 255)]
    private ?string $point_arret = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $arrive_commande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $arc = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $revue_enclenchement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $arrivee_machine = null;

    #[ORM\Column(nullable: true)]
    private ?int $objectif_rapport_expertise = null;

    #[ORM\Column(nullable: true)]
    private ?int $objectif_mise_dispo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_rapport_expertise_finalise = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_machine_prete = null;

    #[ORM\OneToOne(mappedBy: 'revue_enclenchement', cascade: ['persist', 'remove'])]
    private ?Affaire $affaire = null;

    #[ORM\OneToMany(mappedBy: 'revue_enclenchement', targetEntity: Atelier::class)]
    private Collection $ateliers;

    #[ORM\OneToMany(mappedBy: 'revue_enclenchement', targetEntity: EtudesAchats::class)]
    private Collection $etudesAchats;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description_prestation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plan = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $clarification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $utilisateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $indice = null;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->etudesAchats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroContrat(): ?string
    {
        return $this->numero_contrat;
    }

    public function setNumeroContrat(string $numero_contrat): self
    {
        $this->numero_contrat = $numero_contrat;

        return $this;
    }

    public function getCahierCharge(): ?string
    {
        return $this->cahier_charge;
    }

    public function setCahierCharge(string $cahier_charge): self
    {
        $this->cahier_charge = $cahier_charge;

        return $this;
    }

    public function getNumeroPcq(): ?string
    {
        return $this->numero_pcq;
    }

    public function setNumeroPcq(string $numero_pcq): self
    {
        $this->numero_pcq = $numero_pcq;

        return $this;
    }

    public function getAmiante(): ?string
    {
        return $this->amiante;
    }

    public function setAmiante(string $amiante): self
    {
        $this->amiante = $amiante;

        return $this;
    }

    public function getContreExpertise(): ?string
    {
        return $this->contre_expertise;
    }

    public function setContreExpertise(string $contre_expertise): self
    {
        $this->contre_expertise = $contre_expertise;

        return $this;
    }

    public function getRe7Client(): ?\DateTimeInterface
    {
        return $this->re7_client;
    }

    public function setRe7Client(?\DateTimeInterface $re7_client): self
    {
        $this->re7_client = $re7_client;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getDelaiDemandeClient(): ?\DateTimeInterface
    {
        return $this->delai_demande_client;
    }

    public function setDelaiDemandeClient(\DateTimeInterface $delai_demande_client): self
    {
        $this->delai_demande_client = $delai_demande_client;

        return $this;
    }

    public function getPointArret(): ?string
    {
        return $this->point_arret;
    }

    public function setPointArret(string $point_arret): self
    {
        $this->point_arret = $point_arret;

        return $this;
    }

    public function getArriveCommande(): ?\DateTimeInterface
    {
        return $this->arrive_commande;
    }

    public function setArriveCommande(\DateTimeInterface $arrive_commande): self
    {
        $this->arrive_commande = $arrive_commande;

        return $this;
    }

    public function getArc(): ?\DateTimeInterface
    {
        return $this->arc;
    }

    public function setArc(\DateTimeInterface $arc): self
    {
        $this->arc = $arc;

        return $this;
    }

    public function getRevueEnclenchement(): ?\DateTimeInterface
    {
        return $this->revue_enclenchement;
    }

    public function setRevueEnclenchement(\DateTimeInterface $revue_enclenchement): self
    {
        $this->revue_enclenchement = $revue_enclenchement;

        return $this;
    }

    public function getArriveeMachine(): ?\DateTimeInterface
    {
        return $this->arrivee_machine;
    }

    public function setArriveeMachine(\DateTimeInterface $arrivee_machine): self
    {
        $this->arrivee_machine = $arrivee_machine;

        return $this;
    }

    public function getObjectifRapportExpertise(): ?int
    {
        return $this->objectif_rapport_expertise;
    }

    public function setObjectifRapportExpertise(int $objectif_rapport_expertise): self
    {
        $this->objectif_rapport_expertise = $objectif_rapport_expertise;

        return $this;
    }

    public function getObjectifMiseDispo(): ?int
    {
        return $this->objectif_mise_dispo;
    }

    public function setObjectifMiseDispo(int $objectif_mise_dispo): self
    {
        $this->objectif_mise_dispo = $objectif_mise_dispo;

        return $this;
    }

    public function getDateRapportExpertiseFinalise(): ?\DateTimeInterface
    {
        return $this->date_rapport_expertise_finalise;
    }

    public function setDateRapportExpertiseFinalise(\DateTimeInterface $date_rapport_expertise_finalise): self
    {
        $this->date_rapport_expertise_finalise = $date_rapport_expertise_finalise;

        return $this;
    }

    public function getDateMachinePrete(): ?\DateTimeInterface
    {
        return $this->date_machine_prete;
    }

    public function setDateMachinePrete(\DateTimeInterface $date_machine_prete): self
    {
        $this->date_machine_prete = $date_machine_prete;

        return $this;
    }

    public function getAffaire(): ?Affaire
    {
        return $this->affaire;
    }

    public function setAffaire(?Affaire $affaire): self
    {
        // unset the owning side of the relation if necessary
        if ($affaire === null && $this->affaire !== null) {
            $this->affaire->setRevueEnclenchement(null);
        }

        // set the owning side of the relation if necessary
        if ($affaire !== null && $affaire->getRevueEnclenchement() !== $this) {
            $affaire->setRevueEnclenchement($this);
        }

        $this->affaire = $affaire;

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
            $atelier->setRevueEnclenchement($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        if ($this->ateliers->removeElement($atelier)) {
            // set the owning side to null (unless already changed)
            if ($atelier->getRevueEnclenchement() === $this) {
                $atelier->setRevueEnclenchement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtudesAchats>
     */
    public function getEtudesAchats(): Collection
    {
        return $this->etudesAchats;
    }

    public function addEtudesAchat(EtudesAchats $etudesAchat): self
    {
        if (!$this->etudesAchats->contains($etudesAchat)) {
            $this->etudesAchats->add($etudesAchat);
            $etudesAchat->setRevueEnclenchement($this);
        }

        return $this;
    }

    public function removeEtudesAchat(EtudesAchats $etudesAchat): self
    {
        if ($this->etudesAchats->removeElement($etudesAchat)) {
            // set the owning side to null (unless already changed)
            if ($etudesAchat->getRevueEnclenchement() === $this) {
                $etudesAchat->setRevueEnclenchement(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptionPrestation(): ?string
    {
        return $this->description_prestation;
    }

    public function setDescriptionPrestation(string $description_prestation): self
    {
        $this->description_prestation = $description_prestation;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(?string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getClarification(): ?string
    {
        return $this->clarification;
    }

    public function setClarification(?string $clarification): self
    {
        $this->clarification = $clarification;

        return $this;
    }

    public function getUtilisateur(): ?string
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?string $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(?string $indice): static
    {
        $this->indice = $indice;

        return $this;
    }
}
