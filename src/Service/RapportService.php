<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class RapportService
{
    // Propriété pour stocker l'instance de Dompdf
    private $domPdf;

    // Constructeur pour initialiser Dompdf avec des options par défaut
    public function __construct() {
        $this->domPdf = new Dompdf();

        // Options par défaut pour Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');

        // Définir les options pour Dompdf
        $this->domPdf->setOptions($pdfOptions);
    }

    // Méthode pour afficher le fichier PDF
    public function showPdfFile($html, $fichier, $num_projet, $num_qualite)
    {
        // Options spécifiques pour ce PDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instanciation de Dompdf avec les nouvelles options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);

        // Configuration des callbacks pour Dompdf (numérotation des pages)
        $dompdf->setCallbacks([
            'event' => function ($event) use ($dompdf) {
                if ($event['event'] === 'dompdf.page_number') {
                    $dompdf->getCanvas()->page_text(500, 18, 'Page {PAGE_NUM} sur {PAGE_COUNT}', null, 10, [0, 0, 0]);
                }
            }
        ]);

        // Contexte pour les requêtes HTTP sécurisées
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        // Définir le contexte HTTP pour Dompdf
        $dompdf->setHttpContext($context);

        // Charger le contenu HTML
        $dompdf->loadHtml($html);

        // Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Définition des variables pour le pied de page
        $num = $num_projet;
        $qualite = $num_qualite;

        // Fonction pour ajouter un pied de page à chaque page
        $footer = function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($num, $qualite) {
            // Vérifier si ce n'est pas la première page
            if ($pageNumber > 1) {
                $textLeft = "Page $pageNumber sur $pageCount";
                $textCenter = $num;
                $textRight = $qualite;

                $font = $fontMetrics->getFont('Times New Roman');
                $pageWidth = $canvas->get_width();
                $pageHeight = $canvas->get_height();
                $size = 8;
                $widthLeft = $fontMetrics->getTextWidth($textLeft, $font, $size);
                $widthCenter = $fontMetrics->getTextWidth($textCenter, $font, $size);
                $widthRight = $fontMetrics->getTextWidth($textRight, $font, $size);

                // Ajouter le texte au pied de page
                $canvas->text(20, $pageHeight - 20, $textLeft, $font, $size);
                $canvas->text(($pageWidth - $widthCenter) / 2, $pageHeight - 20, $textCenter, $font, $size);
                $canvas->text($pageWidth - $widthRight - 20, $pageHeight - 20, $textRight, $font, $size);
            }
        };

        // Ajouter le script de pied de page à chaque page
        $dompdf->getCanvas()->page_script($footer);

        // Envoi du PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }
}
