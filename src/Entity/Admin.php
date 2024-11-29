<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[UniqueEntity(fields: ['username'], message: "Il existe déjà un compte avec ce nom d'utilisateur")]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'suivi_par', targetEntity: Affaire::class)]
    private Collection $affaire;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $signature_photo = null;

    #[ORM\OneToOne(mappedBy: 'operateur_exp_avant_lavage', cascade: ['persist', 'remove'])]
    private ?Signature $signature = null;

    #[ORM\OneToOne(mappedBy: 'operateur_remontage', cascade: ['persist', 'remove'])]
    private ?Signature $operateurRemontage = null;

    #[ORM\OneToOne(mappedBy: 'operateur_essai_finaux', cascade: ['persist', 'remove'])]
    private ?Signature $operateurEssaiFinaux = null;

    #[ORM\OneToOne(mappedBy: 'operateur_validation_finale', cascade: ['persist', 'remove'])]
    private ?Signature $operateurValidationFinale = null;

 
    public function __construct()
    {
        $this->affaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Affaire>
     */
    public function getAffaire(): Collection
    {
        return $this->affaire;
    }

    public function addAffaire(Affaire $affaire): self
    {
        if (!$this->affaire->contains($affaire)) {
            $this->affaire->add($affaire);
            $affaire->setSuiviPar($this);
        }

        return $this;
    }

    public function removeAffaire(Affaire $affaire): self
    {
        if ($this->affaire->removeElement($affaire)) {
            // set the owning side to null (unless already changed)
            if ($affaire->getSuiviPar() === $this) {
                $affaire->setSuiviPar(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom().' '.$this->getPrenom();
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

    public function getSignaturePhoto(): ?string
    {
        return $this->signature_photo;
    }

    public function setSignaturePhoto(?string $signature_photo): static
    {
        $this->signature_photo = $signature_photo;

        return $this;
    }

    public function getSignature(): ?Signature
    {
        return $this->signature;
    }

    public function setSignature(?Signature $signature): static
    {
        // unset the owning side of the relation if necessary
        if ($signature === null && $this->signature !== null) {
            $this->signature->setOperateurExpAvantLavage(null);
        }

        // set the owning side of the relation if necessary
        if ($signature !== null && $signature->getOperateurExpAvantLavage() !== $this) {
            $signature->setOperateurExpAvantLavage($this);
        }

        $this->signature = $signature;

        return $this;
    }

    public function getOperateurRemontage(): ?Signature
    {
        return $this->operateurRemontage;
    }

    public function setOperateurRemontage(?Signature $operateurRemontage): static
    {
        // unset the owning side of the relation if necessary
        if ($operateurRemontage === null && $this->operateurRemontage !== null) {
            $this->operateurRemontage->setOperateurRemontage(null);
        }

        // set the owning side of the relation if necessary
        if ($operateurRemontage !== null && $operateurRemontage->getOperateurRemontage() !== $this) {
            $operateurRemontage->setOperateurRemontage($this);
        }

        $this->operateurRemontage = $operateurRemontage;

        return $this;
    }

    public function getOperateurEssaiFinaux(): ?Signature
    {
        return $this->operateurEssaiFinaux;
    }

    public function setOperateurEssaiFinaux(?Signature $operateurEssaiFinaux): static
    {
        // unset the owning side of the relation if necessary
        if ($operateurEssaiFinaux === null && $this->operateurEssaiFinaux !== null) {
            $this->operateurEssaiFinaux->setOperateurEssaiFinaux(null);
        }

        // set the owning side of the relation if necessary
        if ($operateurEssaiFinaux !== null && $operateurEssaiFinaux->getOperateurEssaiFinaux() !== $this) {
            $operateurEssaiFinaux->setOperateurEssaiFinaux($this);
        }

        $this->operateurEssaiFinaux = $operateurEssaiFinaux;

        return $this;
    }

    public function getOperateurValidationFinale(): ?Signature
    {
        return $this->operateurValidationFinale;
    }

    public function setOperateurValidationFinale(?Signature $operateurValidationFinale): static
    {
        // unset the owning side of the relation if necessary
        if ($operateurValidationFinale === null && $this->operateurValidationFinale !== null) {
            $this->operateurValidationFinale->setOperateurValidationFinale(null);
        }

        // set the owning side of the relation if necessary
        if ($operateurValidationFinale !== null && $operateurValidationFinale->getOperateurValidationFinale() !== $this) {
            $operateurValidationFinale->setOperateurValidationFinale($this);
        }

        $this->operateurValidationFinale = $operateurValidationFinale;

        return $this;
    }

}
