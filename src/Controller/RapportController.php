<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Parametre;
use App\Service\PdfServiceP;
use PhpOffice\PhpWord\PhpWord;
use App\Repository\AffaireRepository;
use App\Repository\ParametreRepository;
use App\Service\RapportService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    public function __construct(Private Environment $environment)
    {
        // Constructeur pour initialiser le service Twig Environment
    }

    // Fonction pour afficher la liste des affaires terminées
    #[Route('/rapports/listes', name: 'app_affaire_rapport', methods: ['GET'])]
    public function rapport(ParametreRepository $parametreRepository, AffaireRepository $affaireRepository): Response
    {
        // Récupère toutes les affaires, triées par identifiant de manière décroissante
        $affaires = $affaireRepository->findBy([], ['id' => 'desc']);

        // Affiche la vue 'rapport/rapport.html.twig' avec la liste des affaires
        return $this->render('rapport/rapport.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    // Fonction pour générer un rapport d'expertise en format Word
    #[Route('/rapport-expertise-word/{id}', name: 'app_rapport_imprime_word')]
    public function expertiseWord(Parametre $parametre): Response
    {
        // Crée un nouvel objet PhpWord
        $phpWord = new PhpWord();

        // Récupère le contenu HTML du template 'rapport/rapport_expertise_word.html.twig'
        $contenu = $this->renderView('rapport/rapport_expertise_word.html.twig', ['parametre' => $parametre]);

        // Ajoute une section au document Word
        $section = $phpWord->addSection();

        // Ajoute le contenu HTML à la section
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $contenu);

        // Définit le nom du fichier Word
        $filename = "document.docx";

        // Crée un Writer pour enregistrer le fichier Word
        $objetWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, "Word2007");
        $objetWriter->save($filename);

        // Retourne le fichier Word généré
        return $this->file($filename, 'document.docx');
    }

    // Fonction pour générer un rapport d'expertise en format PDF
    #[Route('/print/rapport-expertise/{id}', name: 'app_parametre_expertise', methods: ['POST', 'GET'])]
    public function rapportExpertise(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        // Génère un nom de fichier basé sur les informations de l'affaire
        $fichier = $parametre->getAffaire()->getNomRapport();
        $num_projet = $parametre->getAffaire()->getNumAffaire();
        $num_qualite = $parametre->getNumeroQualite();

        // Récupère le contenu HTML du template 'rapport/rapport_expertise.html.twig'
        $html = $this->renderView('rapport/rapport_expertise.html.twig', [
            'parametre' => $parametre
        ]);

        // Génère et retourne le fichier PDF
        return $pdfServiceP->showPdfFile($html, $fichier, $num_projet, $num_qualite);
    }

    // Fonction pour générer le rapport final en format PDF
    #[Route('/print/rapport-final/{id}', name: 'app_parametre_final', methods: ['POST', 'GET'])]
    public function rapporFinal(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        // Génère un nom de fichier basé sur les informations de l'affaire
        $fichier = $parametre->getAffaire()->getNomRapport();
        $num_projet = $parametre->getAffaire()->getNumAffaire();
        $num_qualite = $parametre->getNumeroQualite();

        // Récupère le contenu HTML du template 'rapport/rapport_final.html.twig'
        $html = $this->renderView('rapport/rapport_final.html.twig', [
            'parametre' => $parametre
        ]);

        // Génère et retourne le fichier PDF
        return $pdfServiceP->showPdfFile($html, $fichier, $num_projet, $num_qualite);
    }
}
