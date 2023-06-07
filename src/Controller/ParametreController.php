<?php

namespace App\Controller;

use TCPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Affaire;
use App\Entity\Parametre;
use App\Form\ParametreType;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/parametre')]
class ParametreController extends AbstractController
{
    #[Route('/', name: 'app_parametre_index', methods: ['GET'])]
    public function index(ParametreRepository $parametreRepository): Response
    {
        return $this->render('parametre/index.html.twig', [
            'parametres' => $parametreRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_parametre_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Affaire $affaire, ParametreRepository $parametreRepository): Response
    {
        $parametre = new Parametre();
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametre->setAffaire($affaire);
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/new.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
            'affaire' => $affaire
        ]);
    }

    #[Route('/{id}', name: 'app_parametre_show', methods: ['GET'])]
    public function show(Parametre $parametre): Response
    {
        return $this->render('parametre/show.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $parametre->getAffaire()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parametre_delete', methods: ['POST'])]
    public function delete(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parametre->getId(), $request->request->get('_token'))) {
            $parametreRepository->remove($parametre, true);
        }

        return $this->redirectToRoute('app_parametre_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/print/rapport/{id}', name: 'app_parametre_print', methods: ['POST', 'GET'])]
    public function print(Parametre $parametre): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        $dompdf->setHttpContext($context);
        $html = $this->renderView('parametre/rapport_pdf.html.twig', [
            'parametre' => $parametre
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
      /*
        $pdf = new TCPDF();
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();
        $pdf->SetTitle($parametre->getAffaire()->getNomRapport());
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Récupérez le contenu de la page Twig
        $content = $this->renderView('parametre/rapport_pdf.html.twig', [
            'parametre' => $parametre,
            'hello' => 'bonjour'
        ]);

        // Ajoutez le contenu à votre PDF
        $pdf->writeHTML($content);

        // Définissez le nom du fichier PDF généré
        $filename = $parametre->getAffaire()->getNomRapport();

        // Renvoyez le PDF en tant que réponse
        return new Response($pdf->Output($filename, 'I'), 200, array(
            'Content-Type' => 'application/pdf',
        ));
        */
    

    }
}
