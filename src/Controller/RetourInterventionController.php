<?php

namespace App\Controller;

use App\Service\PdfServiceP;
use App\Service\RapportService;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Lintervention;
use App\Entity\RetourIntervention;
use App\Form\RetourInterventionType;
use App\Form\LinterventionRetourType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LinterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RetourInterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Définition de la route principale pour ce contrôleur
#[Route('/retour/intervention')]
class RetourInterventionController extends AbstractController
{
    // Route pour afficher la liste de toutes les interventions de retour
    #[Route('/', name: 'app_retour_intervention_index', methods: ['GET'])]
    public function index(RetourInterventionRepository $retourInterventionRepository): Response
    {
        // Rendu de la vue Twig 'index.html.twig' avec la liste des interventions de retour
        return $this->render('metrologies/retour_intervention/index.html.twig', [
            'retour_interventions' => $retourInterventionRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    // Route pour créer une nouvelle intervention de retour
    #[Route('/new', name: 'app_retour_intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RetourInterventionRepository $retourInterventionRepository, EntityManagerInterface $em): Response
    {
        $retourIntervention = new RetourIntervention();
        $form = $this->createForm(RetourInterventionType::class, $retourIntervention);
        $form->handleRequest($request);

        // Soumission et validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $inters = $retourIntervention->getIntervention();
            $inters->setRetour(1);
            foreach ($inters->getLinterventions() as $item) {
                $item->getAppareil()->setStatus(0);
                $em->persist($item->getAppareil());
            }
            $em->flush();
            $retourInterventionRepository->save($retourIntervention, true);
            return $this->redirectToRoute('app_retour_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'new.html.twig' avec le formulaire de création
        return $this->renderForm('metrologies/retour_intervention/new.html.twig', [
            'retour_intervention' => $retourIntervention,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'une intervention de retour spécifique
    #[Route('/details/{id}', name: 'app_retour_intervention_show', methods: ['GET'])]
    public function show(RetourIntervention $retourIntervention, Request $request): Response
    {
        return $this->render('metrologies/retour_intervention/show.html.twig', [
            'retour_intervention' => $retourIntervention,
        ]);
    }

    // Route pour éditer une intervention de retour existante
    #[Route('/{id}/edit', name: 'app_retour_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RetourIntervention $retourIntervention, RetourInterventionRepository $retourInterventionRepository): Response
    {
        $form = $this->createForm(RetourInterventionType::class, $retourIntervention);
        $form->handleRequest($request);

        // Soumission et validation du formulaire d'édition
        if ($form->isSubmitted() && $form->isValid()) {
            $retourInterventionRepository->save($retourIntervention, true);
            return $this->redirectToRoute('app_retour_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'edit.html.twig' avec le formulaire d'édition
        return $this->renderForm('metrologies/retour_intervention/edit.html.twig', [
            'retour_intervention' => $retourIntervention,
            'form' => $form,
        ]);
    }

    // Route pour supprimer une intervention de retour existante
    #[Route('/sup/{id}', name: 'app_retour_intervention_delete', methods: ['GET'])]
    public function delete(Request $request, RetourIntervention $retourIntervention, RetourInterventionRepository $retourInterventionRepository): Response
    {
        if ($retourIntervention) {
            if ($retourIntervention->getIntervention()) {
                $this->addFlash('danger', 'Désolé vous ne pouvez pas supprimer cette intervention !');
                return $this->redirectToRoute('app_retour_intervention_index', [], Response::HTTP_SEE_OTHER);
            }
            $retourInterventionRepository->remove($retourIntervention, true);
            return $this->redirectToRoute('app_retour_intervention_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_retour_intervention_index', [], Response::HTTP_SEE_OTHER);
    }

    // Route pour modifier un appareil de retour dans une intervention
    #[Route('/modifier-appareil-retour/{id}/edit', name: 'app_retour_intervention_app_edit', methods: ['GET', 'POST'])]
    public function modifier(Request $request, Lintervention $lintervention, LinterventionRepository $linterventionRepository, EntityManagerInterface $em): Response
    {
        $id = $lintervention->getIntervention()->getRetourIntervention()->getId();
        $form = $this->createForm(LinterventionRetourType::class, $lintervention);
        $form->handleRequest($request);

        // Soumission et validation du formulaire de modification
        if ($form->isSubmitted() && $form->isValid()) {

            $app = $lintervention->getAppareil();
            $app->setDesignation($lintervention->getDesignation());
            $app->setMarque($lintervention->getMarque());
            $app->setType($lintervention->getType());
            $app->setEtat($lintervention->getEtat());
            $app->setStatut($lintervention->getStatut());
            $app->setNumeroCertificat($lintervention->getNumeroCertificat());

            $periodicite = intval($app->getPeriodicite());
            $date_depuis  = $lintervention->getDateEtalonnage();
            if ($date_depuis && $periodicite)
            {
                $dateValidite = clone $date_depuis;
                $dateValidite->modify('+'.$periodicite. 'months');
                $app->setDateValidite($dateValidite);
            }
            $app->setDateEtat($lintervention->getDateEtalonnage());

            $em->persist($app);
            $em->flush($app);

            $linterventionRepository->save($lintervention, true);
            return $this->redirectToRoute('app_retour_intervention_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'edit_app_retour.html.twig' avec le formulaire de modification
        return $this->renderForm('metrologies/retour_intervention/edit_app_retour.html.twig', [
            'lintervention' => $lintervention,
            'form' => $form,
        ]);
    }

    // Route pour imprimer le bon de sortie
    #[Route('/print-intervention/{id}', name: 'app_intervention_retour_print', methods: ['POST', 'GET'])]
    public function print(RetourIntervention $intervention): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instanciation de Dompdf
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
        $html = $this->renderView('metrologies/retour_intervention/print.html.twig', [
            'retourIntervention' => $intervention,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Génération d'un nom de fichier
        $fichier = "Intervention : " . $intervention->getIntervention()->getNumeroDa();

        // Envoi du PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }

    // Route pour imprimer le bon de sortie
    #[Route('/print-all/{id}', name: 'app_intervention_retour_all_print', methods: ['POST', 'GET'])]
    public function printAllCerticat(RetourIntervention $intervention, PdfServiceP $pdfServiceP): Response
    {

        $fichier = "La liste des certificats du Retour DA".$intervention->getIntervention();
        $html = $this->renderView('appareil/printAll.html.twig', [
            'retourIntervention' => $intervention,
        ]);

        return $pdfServiceP->showPdfFile($html, $fichier);
    }
}
