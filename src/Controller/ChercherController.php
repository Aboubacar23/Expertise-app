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
 * Dérniere date de modification : -
 * ----------------------------------------------------------------
 *******Template **************************
 les views cherche se trouvent dans le dossier "cherche" du template
 * ********************** Déscription *****************************
 * Ce controleur contient qu'une seule fonction
 *  1 - la fonction "index" : permet denvoyer dans le fichier twig le formulaire 
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
    #[Route('/index-filtre-par-attributs', name: 'app_chercher')]
    public function index(AppareilRepository $appareilRepository, Request $request, PdfService $pdfService): Response
    {
        $chercher = new Chercher();
        $form = $this->createForm(ChercherType::class, $chercher);
        $form->handleRequest($request);

        $appareils = $appareilRepository->findAll();

        if ($form->isSubmitted() && $form->isValid())
        {
            $appareils = $appareilRepository->findChercher($chercher);
            $html = $this->render('metrologies/chercher/printEtat.html.twig', [
                'appareils' => $appareils,
                'etat' => $chercher->getEtat()
            ]);
            $fichier = "les appareils en état ".$chercher->getEtat();
            $pdfService->showPdfFile($html,$fichier);
        }

        return $this->render('metrologies/chercher/index.html.twig', [
            'form' => $form->createView(),
            'chercher' => $chercher,
        ]);
    }
}
