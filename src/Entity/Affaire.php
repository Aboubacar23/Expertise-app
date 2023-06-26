<?php

namespace App\Entity;

use App\Repository\AffaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffaireRepository::class)]
class Affaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'affaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    private ?string $code_client = null;

    #[ORM\Column(length: 255)]
    private ?string $num_fabrication = null;

    #[ORM\Column(length: 255)]
    private ?string $num_article_client = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $context = null;

    #[ORM\Column(length: 255)]
    private ?string $num_affaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_livraison = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_rapport = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation_travaux = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $travaux_sup = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToMany(mappedBy: 'affaire', targetEntity: Parametre::class)]
    private Collection $parametres;

    #[ORM\ManyToOne(inversedBy: 'affaire')]
    private ?Admin $suivi_par = null;

    #[ORM\Column(nullable: true)]
    private ?bool $bloque = null;

    #[ORM\OneToMany(mappedBy: 'affaire', targetEntity: Archive::class)]
    private Collection $archives;


    public function __construct()
    {
        $this->parametres = new ArrayCollection();
        $this->archives = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCodeClient(): ?string
    {
        return $this->code_client;
    }

    public function setCodeClient(string $code_client): self
    {
        $this->code_client = $code_client;

        return $this;
    }

    public function getNumFabrication(): ?string
    {
        return $this->num_fabrication;
    }

    public function setNumFabrication(string $num_fabrication): self
    {
        $this->num_fabrication = $num_fabrication;

        return $this;
    }

    public function getNumArticleClient(): ?string
    {
        return $this->num_article_client;
    }

    public function setNumArticleClient(string $num_article_client): self
    {
        $this->num_article_client = $num_article_client;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(?string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getNumAffaire(): ?string
    {
        return $this->num_affaire;
    }

    public function setNumAffaire(string $num_affaire): self
    {
        $this->num_affaire = $num_affaire;

        return $this;
    }


    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getNomRapport(): ?string
    {
        return $this->nom_rapport;
    }

    public function setNomRapport(string $nom_rapport): self
    {
        $this->nom_rapport = $nom_rapport;

        return $this;
    }

    public function getPresentationTravaux(): ?string
    {
        return $this->presentation_travaux;
    }

    public function setPresentationTravaux(?string $presentation_travaux): self
    {
        $this->presentation_travaux = $presentation_travaux;

        return $this;
    }

    public function getTravauxSup(): ?string
    {
        return $this->travaux_sup;
    }

    public function setTravauxSup(?string $travaux_sup): self
    {
        $this->travaux_sup = $travaux_sup;

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

    /**
     * @return Collection<int, Parametre>
     */
    public function getParametres(): Collection
    {
        return $this->parametres;
    }

    public function addParametre(Parametre $parametre): self
    {
        if (!$this->parametres->contains($parametre)) {
            $this->parametres->add($parametre);
            $parametre->setAffaire($this);
        }

        return $this;
    }

    public function removeParametre(Parametre $parametre): self
    {
        if ($this->parametres->removeElement($parametre)) {
            // set the owning side to null (unless already changed)
            if ($parametre->getAffaire() === $this) {
                $parametre->setAffaire(null);
            }
        }

        return $this;
    }

    public function getSuiviPar(): ?Admin
    {
        return $this->suivi_par;
    }

    public function setSuiviPar(?Admin $suivi_par): self
    {
        $this->suivi_par = $suivi_par;

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(?bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * @return Collection<int, Archive>
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archive $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives->add($archive);
            $archive->setAffaire($this);
        }

        return $this;
    }

    public function removeArchive(Archive $archive): self
    {
        if ($this->archives->removeElement($archive)) {
            // set the owning side to null (unless already changed)
            if ($archive->getAffaire() === $this) {
                $archive->setAffaire(null);
            }
        }

        return $this;
    }

}
