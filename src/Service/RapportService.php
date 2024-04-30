<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class RapportService
{
    private $domPdf;

    public function __construct() {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html, $fichier, $num_projet)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);
        $dompdf->setCallbacks([
            'event' => function ($event) use ($dompdf) {
                if ($event['event'] === 'dompdf.page_number') {
                    $dompdf->getCanvas()->page_text(500, 18, 'Page {PAGE_NUM} sur {PAGE_COUNT}', null, 10, [0, 0, 0]);
                }
            }
        ]);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        $dompdf->setHttpContext($context);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $num = $num_projet;
        $footer = function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($num) {
           // Vérifier si ce n'est pas la première page
            if ($pageNumber > 1) {
                $numero = "2025";
                $textLeft = "Page $pageNumber sur $pageCount";
                $textCenter = $num;
                $textRight = "IAQ19001";

                $font = $fontMetrics->getFont('Times New Roman');
                $pageWidth = $canvas->get_width();
                $pageHeight = $canvas->get_height();
                $size = 10;
                $widthLeft = $fontMetrics->getTextWidth($textLeft, $font, $size);
                $widthCenter = $fontMetrics->getTextWidth($textCenter, $font, $size);
                $widthRight = $fontMetrics->getTextWidth($textRight, $font, $size);
                $canvas->text(20, $pageHeight - 20, $textLeft, $font, $size);
                $canvas->text(($pageWidth - $widthCenter) / 2, $pageHeight - 20, $textCenter, $font, $size);
                $canvas->text($pageWidth - $widthRight - 20, $pageHeight - 20, $textRight, $font, $size);
            }
        };
        
        // Ajouter le script de pied de page à chaque page
        $dompdf->getCanvas()->page_script($footer);
    

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }
}