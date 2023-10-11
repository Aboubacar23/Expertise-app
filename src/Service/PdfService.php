<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct() {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html, $fichier) {
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
        $dompdf->setPaper('A4', 'landscape');
        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(
            function ($pageNumber, $pageCount, $canvas, $fontMetrics){
                $text = "Page $pageNumber sur $pageCount";
                $font = $fontMetrics->getFont('Times New Roman');
                $pageWidth = $canvas->get_width();
                $pageHeight = $canvas->get_height();
                $size = 12;
                $width = $fontMetrics->getTextWidth($text, $font, $size);
                $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text,$font,$size);
            }
        );

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }
}