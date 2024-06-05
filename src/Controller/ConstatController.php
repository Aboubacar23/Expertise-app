<?php
/**
 * ----------------------------------------------------------------
 * Projet : Base Métrologie
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 02-10-2023
 * Dernière date de modification : -
 * ----------------------------------------------------------------
 * ********************** Description *****************************
 * Ce contrôleur gère les constats.
 * Il contient une seule fonction :
 *  1 - La fonction "index" : permet d'afficher un paramètre donné dans une vue Twig.
 * ----------------------------------------------------------------
 */

namespace App\Controller;

use App\Entity\Parametre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/constat')]
class ConstatController extends AbstractController
{
    // Fonction pour afficher un paramètre donné dans une vue Twig
    #[Route('/show/{id}', name: 'app_constat_index')]
    public function index(Parametre $parametre): Response
    {
        return $this->render('constat/index.html.twig', [
            'parametre' => $parametre
        ]);
    }
}
