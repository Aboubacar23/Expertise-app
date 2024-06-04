<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Repository\AdminRepository;
use App\Repository\AffaireRepository;
use App\Repository\ClientRepository;
use App\Repository\ParametreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Déclare la classe HomeController qui hérite d'AbstractController
#[Route('/expertise-jeumont')]
class HomeController extends AbstractController
{
    /**
     * Récupère le nombre total de tous les éléments de l'application pour les envoyer au dashboard
     *
     * @param AdminRepository $adminRepository
     * @return Response
     */
    #[Route('/home', name: 'app_home')]
    public function index(AdminRepository $adminRepository, ClientRepository $clientRepository, ParametreRepository $parametreRepository, AffaireRepository $affaireRepository): Response
    {
        // Compte le nombre d'administrateurs
        $admin = count($adminRepository->findAll());
        // Compte le nombre de clients
        $client = count($clientRepository->findAll());
        // Récupère tous les paramètres
        $parametres = $parametreRepository->findAll();
        // Compte le nombre d'affaires
        $affaire = count($affaireRepository->findAll());

        // Initialise les variables de comptage
        $nombre = 0;
        $encours = 0;
        $terminer = 0;
        $var_encours = 0;
        $var_terminer = 0;
        $encoursPourc = 0;
        $terminerPourc = 0;
        $bloqueVal = 0;
        $bloque = 0;
        $var_par = 1;

        // Si des paramètres existent, met à jour la variable de comptage
        if ($parametres) {
            $var_par = count($parametres);
        }

        // Récupère les affaires triées par ordre décroissant d'ID
        $tables = $affaireRepository->findBy([], ['id' => 'desc']);
        $affaires = [];

        // Parcourt chaque affaire et ses paramètres associés
        foreach ($tables as $item2) {
            foreach ($item2->getParametres() as $item) {
                // Incrémente le compteur si le statut et le remontage sont complets
                if ($item->isStatut() == 1 && $item->isRemontage() == 1) {
                    $nombre = $nombre + 1;
                }

                // Incrémente les compteurs en fonction du statut de l'affaire
                if ($item->isStatut() == 0) {
                    $var_encours = $var_encours + 1;
                } else {
                    $var_terminer = $var_terminer + 1;
                }

                // Incrémente le compteur si l'affaire est bloquée
                if ($item->getAffaire()->isBloque()) {
                    $bloqueVal = $bloqueVal + 1;
                }
            }

            // Ajoute l'affaire à la liste si elle n'est pas terminée
            if ($item2->isEtat() != 1) {
                array_push($affaires, $item2);
            }
        }

        // Calcule les pourcentages si des affaires existent
        if ($affaires) {
            $encoursPourc = 100 * ($var_encours / $var_par);
            $terminerPourc = 100 * ($var_terminer / $var_par);
            $bloque = 100 * ($bloqueVal / $var_par);
        }

        // Met à jour les compteurs finaux
        $encours = $var_encours;
        $terminer = $var_terminer;

        // Rend la vue pour le dashboard avec les données calculées
        return $this->render('home/index.html.twig', [
            'admin' => $admin,
            'client' => $client,
            'nombre' => $nombre,
            'var_par' => $var_par,
            'affaire' => $affaire,
            'encours' => $encours,
            'encoursPourc' => $encoursPourc,
            'terminerPourc' => $terminerPourc,
            'bloque' => $bloque,
            'bloqueVal' => $bloqueVal,
            'terminer' => $terminer,
            'affaires' => $affaires,
        ]);
    }

    // La fonction qui affiche la liste des affaires terminées
    #[Route('/corbeille-listes', name: 'app_corbeille_listes', methods: ['GET'])]
    public function rapport(ParametreRepository $parametreRepository): Response
    {
        // Récupère tous les paramètres triés par ordre décroissant d'ID
        $listes = $parametreRepository->findBy([], ['id' => 'desc']);
        $parametres = [];

        // Parcourt chaque paramètre pour vérifier s'il est dans la corbeille
        foreach ($listes as $item) {
            if ($item->isCorbeille() == true) {
                array_push($parametres, $item);
            }
        }

        // Rend la vue pour la corbeille avec les paramètres dans la corbeille
        return $this->render('home/corbeille.html.twig', [
            'parametres' => $parametres,
        ]);
    }
}
