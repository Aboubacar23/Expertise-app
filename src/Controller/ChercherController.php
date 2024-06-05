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
 * Ce contrôleur contient une seule fonction :
 *  1 - La fonction "index" : permet d'envoyer le formulaire dans le fichier Twig.
 *
 * Les vues se trouvent dans le dossier "chercher" du template.
 * ----------------------------------------------------------------
 */

namespace App\Controller;

use App\Entity\Chercher;
use App\Form\ChercherType;
use App\Repository\AppareilRepository;
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/chercher')]
class ChercherController extends AbstractController
{
    // Route pour afficher le formulaire de recherche et traiter la recherche d'appareils par attributs
    #[Route('/index-filtre-par-attributs', name: 'app_chercher')]
    public function index(AppareilRepository $appareilRepository, Request $request, PdfService $pdfService): Response
    {
        // Crée une nouvelle instance de l'entité Chercher
        $chercher = new Chercher();

        // Crée le formulaire pour l'entité Chercher
        $form = $this->createForm(ChercherType::class, $chercher);
        $form->handleRequest($request);

        // Récupère tous les appareils
        $appareils = $appareilRepository->findAll();

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère les appareils correspondant aux critères de recherche
            $appareils = $appareilRepository->findChercher($chercher);

            // Génère le contenu HTML pour le PDF
            $html = $this->render('metrologies/chercher/printEtat.html.twig', [
                'appareils' => $appareils,
                'etat' => $chercher->getEtat()
            ]);

            // Nom du fichier PDF
            $fichier = "les appareils en état " . $chercher->getEtat();

            // Génère et affiche le PDF
            $pdfService->showPdfFile($html, $fichier);
        }

        // Rend la vue avec le formulaire de recherche
        return $this->render('metrologies/chercher/index.html.twig', [
            'form' => $form->createView(),
            'chercher' => $chercher,
        ]);
    }
}
