<?php

namespace App\Entity;

use App\Repository\RemontageFinitionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemontageFinitionRepository::class)]
class RemontageFinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_carcasse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_cablage1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_cablage2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_cablage3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_cablage4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_sonde1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_sonde2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_sonde3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_arbre1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_arbre2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general8 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general9 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general10 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general11 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_carcasse2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_cablage2_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_sonde2_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_arbre2_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_arbre2_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_arbre2_3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_general2_8 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_plaque1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_plaque2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_plaque3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_plaque4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $controle_plaque5 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToOne(mappedBy: 'remontage_finition', cascade: ['persist', 'remove'])]
    private ?Parametre $parametre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getControleCarcasse(): ?string
    {
        return $this->controle_carcasse;
    }

    public function setControleCarcasse(?string $controle_carcasse): self
    {
        $this->controle_carcasse = $controle_carcasse;

        return $this;
    }

    public function getControleCablage1(): ?string
    {
        return $this->controle_cablage1;
    }

    public function setControleCablage1(?string $controle_cablage1): self
    {
        $this->controle_cablage1 = $controle_cablage1;

        return $this;
    }

    public function getControleCablage2(): ?string
    {
        return $this->controle_cablage2;
    }

    public function setControleCablage2(?string $controle_cablage2): self
    {
        $this->controle_cablage2 = $controle_cablage2;

        return $this;
    }

    public function getControleCablage3(): ?string
    {
        return $this->controle_cablage3;
    }

    public function setControleCablage3(?string $controle_cablage3): self
    {
        $this->controle_cablage3 = $controle_cablage3;

        return $this;
    }

    public function getControleCablage4(): ?string
    {
        return $this->controle_cablage4;
    }

    public function setControleCablage4(?string $controle_cablage4): self
    {
        $this->controle_cablage4 = $controle_cablage4;

        return $this;
    }

    public function getControleSonde1(): ?string
    {
        return $this->controle_sonde1;
    }

    public function setControleSonde1(?string $controle_sonde1): self
    {
        $this->controle_sonde1 = $controle_sonde1;

        return $this;
    }

    public function getControleSonde2(): ?string
    {
        return $this->controle_sonde2;
    }

    public function setControleSonde2(?string $controle_sonde2): self
    {
        $this->controle_sonde2 = $controle_sonde2;

        return $this;
    }

    public function getControleSonde3(): ?string
    {
        return $this->controle_sonde3;
    }

    public function setControleSonde3(?string $controle_sonde3): self
    {
        $this->controle_sonde3 = $controle_sonde3;

        return $this;
    }

    public function getControleArbre1(): ?string
    {
        return $this->controle_arbre1;
    }

    public function setControleArbre1(?string $controle_arbre1): self
    {
        $this->controle_arbre1 = $controle_arbre1;

        return $this;
    }

    public function getControleArbre2(): ?string
    {
        return $this->controle_arbre2;
    }

    public function setControleArbre2(?string $controle_arbre2): self
    {
        $this->controle_arbre2 = $controle_arbre2;

        return $this;
    }

    public function getControleGeneral1(): ?string
    {
        return $this->controle_general1;
    }

    public function setControleGeneral1(?string $controle_general1): self
    {
        $this->controle_general1 = $controle_general1;

        return $this;
    }

    public function getControleGeneral2(): ?string
    {
        return $this->controle_general2;
    }

    public function setControleGeneral2(?string $controle_general2): self
    {
        $this->controle_general2 = $controle_general2;

        return $this;
    }

    public function getControleGeneral3(): ?string
    {
        return $this->controle_general3;
    }

    public function setControleGeneral3(?string $controle_general3): self
    {
        $this->controle_general3 = $controle_general3;

        return $this;
    }

    public function getControleGeneral4(): ?string
    {
        return $this->controle_general4;
    }

    public function setControleGeneral4(?string $controle_general4): self
    {
        $this->controle_general4 = $controle_general4;

        return $this;
    }

    public function getControleGeneral5(): ?string
    {
        return $this->controle_general5;
    }

    public function setControleGeneral5(?string $controle_general5): self
    {
        $this->controle_general5 = $controle_general5;

        return $this;
    }

    public function getControleGeneral6(): ?string
    {
        return $this->controle_general6;
    }

    public function setControleGeneral6(?string $controle_general6): self
    {
        $this->controle_general6 = $controle_general6;

        return $this;
    }

    public function getControleGeneral7(): ?string
    {
        return $this->controle_general7;
    }

    public function setControleGeneral7(?string $controle_general7): self
    {
        $this->controle_general7 = $controle_general7;

        return $this;
    }

    public function getControleGeneral8(): ?string
    {
        return $this->controle_general8;
    }

    public function setControleGeneral8(?string $controle_general8): self
    {
        $this->controle_general8 = $controle_general8;

        return $this;
    }

    public function getControleGeneral9(): ?string
    {
        return $this->controle_general9;
    }

    public function setControleGeneral9(?string $controle_general9): self
    {
        $this->controle_general9 = $controle_general9;

        return $this;
    }

    public function getControleGeneral10(): ?string
    {
        return $this->controle_general10;
    }

    public function setControleGeneral10(?string $controle_general10): self
    {
        $this->controle_general10 = $controle_general10;

        return $this;
    }

    public function getControleGeneral11(): ?string
    {
        return $this->controle_general11;
    }

    public function setControleGeneral11(?string $controle_general11): self
    {
        $this->controle_general11 = $controle_general11;

        return $this;
    }

    public function getControleCarcasse2(): ?string
    {
        return $this->controle_carcasse2;
    }

    public function setControleCarcasse2(?string $controle_carcasse2): self
    {
        $this->controle_carcasse2 = $controle_carcasse2;

        return $this;
    }

    public function getControleCablage21(): ?string
    {
        return $this->controle_cablage2_1;
    }

    public function setControleCablage21(?string $controle_cablage2_1): self
    {
        $this->controle_cablage2_1 = $controle_cablage2_1;

        return $this;
    }

    public function getControleSonde21(): ?string
    {
        return $this->controle_sonde2_1;
    }

    public function setControleSonde21(?string $controle_sonde2_1): self
    {
        $this->controle_sonde2_1 = $controle_sonde2_1;

        return $this;
    }

    public function getControleArbre21(): ?string
    {
        return $this->controle_arbre2_1;
    }

    public function setControleArbre21(?string $controle_arbre2_1): self
    {
        $this->controle_arbre2_1 = $controle_arbre2_1;

        return $this;
    }

    public function getControleArbre22(): ?string
    {
        return $this->controle_arbre2_2;
    }

    public function setControleArbre22(?string $controle_arbre2_2): self
    {
        $this->controle_arbre2_2 = $controle_arbre2_2;

        return $this;
    }

    public function getControleArbre23(): ?string
    {
        return $this->controle_arbre2_3;
    }

    public function setControleArbre23(?string $controle_arbre2_3): self
    {
        $this->controle_arbre2_3 = $controle_arbre2_3;

        return $this;
    }

    public function getControleGeneral21(): ?string
    {
        return $this->controle_general2_1;
    }

    public function setControleGeneral21(?string $controle_general2_1): self
    {
        $this->controle_general2_1 = $controle_general2_1;

        return $this;
    }

    public function getControleGeneral22(): ?string
    {
        return $this->controle_general2_2;
    }

    public function setControleGeneral22(?string $controle_general2_2): self
    {
        $this->controle_general2_2 = $controle_general2_2;

        return $this;
    }

    public function getControleGeneral23(): ?string
    {
        return $this->controle_general2_3;
    }

    public function setControleGeneral23(?string $controle_general2_3): self
    {
        $this->controle_general2_3 = $controle_general2_3;

        return $this;
    }

    public function getControleGeneral24(): ?string
    {
        return $this->controle_general2_4;
    }

    public function setControleGeneral24(?string $controle_general2_4): self
    {
        $this->controle_general2_4 = $controle_general2_4;

        return $this;
    }

    public function getControleGeneral25(): ?string
    {
        return $this->controle_general2_5;
    }

    public function setControleGeneral25(?string $controle_general2_5): self
    {
        $this->controle_general2_5 = $controle_general2_5;

        return $this;
    }

    public function getControleGeneral26(): ?string
    {
        return $this->controle_general2_6;
    }

    public function setControleGeneral26(?string $controle_general2_6): self
    {
        $this->controle_general2_6 = $controle_general2_6;

        return $this;
    }

    public function getControleGeneral27(): ?string
    {
        return $this->controle_general2_7;
    }

    public function setControleGeneral27(?string $controle_general2_7): self
    {
        $this->controle_general2_7 = $controle_general2_7;

        return $this;
    }

    public function getControleGeneral28(): ?string
    {
        return $this->controle_general2_8;
    }

    public function setControleGeneral28(?string $controle_general2_8): self
    {
        $this->controle_general2_8 = $controle_general2_8;

        return $this;
    }

    public function getControlePlaque1(): ?string
    {
        return $this->controle_plaque1;
    }

    public function setControlePlaque1(?string $controle_plaque1): self
    {
        $this->controle_plaque1 = $controle_plaque1;

        return $this;
    }

    public function getControlePlaque2(): ?string
    {
        return $this->controle_plaque2;
    }

    public function setControlePlaque2(?string $controle_plaque2): self
    {
        $this->controle_plaque2 = $controle_plaque2;

        return $this;
    }

    public function getControlePlaque3(): ?string
    {
        return $this->controle_plaque3;
    }

    public function setControlePlaque3(?string $controle_plaque3): self
    {
        $this->controle_plaque3 = $controle_plaque3;

        return $this;
    }

    public function getControlePlaque4(): ?string
    {
        return $this->controle_plaque4;
    }

    public function setControlePlaque4(?string $controle_plaque4): self
    {
        $this->controle_plaque4 = $controle_plaque4;

        return $this;
    }

    public function getControlePlaque5(): ?string
    {
        return $this->controle_plaque5;
    }

    public function setControlePlaque5(?string $controle_plaque5): self
    {
        $this->controle_plaque5 = $controle_plaque5;

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
            $this->parametre->setRemontageFinition(null);
        }

        // set the owning side of the relation if necessary
        if ($parametre !== null && $parametre->getRemontageFinition() !== $this) {
            $parametre->setRemontageFinition($this);
        }

        $this->parametre = $parametre;

        return $this;
    }
}
