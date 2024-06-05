<?php

namespace App\Twig;

use Twig\TwigFunction;
use App\Entity\Parametre;
use Twig\Extension\AbstractExtension;
use App\Repository\ParametreRepository;
use App\Repository\RemarqueRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParametreExtension extends AbstractExtension
{
    // Propriétés pour stocker les repositories et l'EntityManager
    private $em;
    private $remarqueRepository;

    // Constructeur pour injecter les dépendances
    public function __construct(ParametreRepository $em, RemarqueRepository $remarqueRepository)
    {
        $this->em = $em;
        $this->remarqueRepository = $remarqueRepository;
    }

    // Méthode pour obtenir les listes de Parametre selon des critères spécifiques
    public function getListes()
    {
        // Tableau pour stocker les listes filtrées
        $listes = [];

        // Récupère tous les paramètres triés par ID décroissant
        $lists = $this->em->findBy([], ['id' => 'desc']);

        // Filtre les paramètres selon des critères spécifiques
        foreach ($lists as $item) {
            if ($item->isStatut() == 0 &&
                $item->isExpertiseElectiqueAvantLavage() == 1 &&
                $item->isExpertiseElectiqueApresLavage() == 1 &&
                $item->isExpertiseMecanique()) {
                array_push($listes, $item);
            }
        }

        // Retourne les listes filtrées
        return $listes;
    }

    // Méthode pour obtenir les remarques selon des critères spécifiques
    public function getRemarque()
    {
        // Tableau pour stocker les remarques filtrées
        $listes = [];

        // Récupère toutes les remarques triées par ID décroissant
        $lists = $this->remarqueRepository->findBy([], ['id' => 'desc']);

        // Filtre les remarques selon des critères spécifiques
        foreach ($lists as $item) {
            if ($item->isEtat() == 0) {
                array_push($listes, $item);
            }
        }

        // Retourne les remarques filtrées
        return $listes;
    }
}
