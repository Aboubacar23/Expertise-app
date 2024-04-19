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
        
    }
    
    //la fonction qui affiche la liste des affaires terminer
    #[Route('/rapports/listes', name: 'app_affaire_rapport', methods: ['GET'])]
    public function rapport(ParametreRepository $parametreRepository, AffaireRepository $affaireRepository): Response
    {
        $affaires = $affaireRepository->findBy([], ['id' => 'desc']);
        return $this->render('rapport/rapport.html.twig', [
            'affaires' => $affaires,
        ]);
    }
   

    #[Route('/rapport-expertise-word/{id}', name: 'app_rapport_imprime_word')]
    public function expertiseWord(Parametre $parametre): Response
    {
        $phpWord = new PhpWord();
                
        $contenu = $this->renderView('rapport/rapport_expertise_word.html.twig', ['parametre' => $parametre]);
    
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $contenu);  

        $filename = "document.docx";
        $objetWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, "Word2007");
        $objetWriter->save($filename);

        return $this->file($filename, 'document.docx');
    }
    
    #[Route('/print/rapport-expertise/{id}', name: 'app_parametre_expertise', methods: ['POST', 'GET'])]
    public function rapportExpertise(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();
        $numero = $parametre->getAffaire()->getNumAffaire();
        $html = $this->renderView('rapport/rapport_expertise.html.twig', [
            'parametre' => $parametre
        ]);
        return  $pdfServiceP->showPdfFile($html, $fichier);
    }

    #[Route('/print/rapport-final/{id}', name: 'app_parametre_final', methods: ['POST', 'GET'])]
    public function rapporFinal(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        $fichier = $parametre->getAffaire()->getNomRapport();
        $numero = $parametre->getAffaire()->getNumAffaire();
        $html = $this->renderView('rapport/rapport_final.html.twig', [
            'parametre' => $parametre
        ]);
        return  $pdfServiceP->showPdfFile($html, $fichier);
    }

}
