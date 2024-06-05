<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Laffectation;
use App\Entity\RetourAffectation;
use App\Form\RetourAffectationType;
use App\Form\LaffectationRetourType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LaffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RetourAffectationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/retour/affectation')]
class RetourAffectationController extends AbstractController
{
    #[Route('/index', name: 'app_retour_affectation_index', methods: ['GET'])]
    public function index(RetourAffectationRepository $retourAffectationRepository): Response
    {
        return $this->render('metrologies/retour_affectation/index.html.twig', [
            'retour_affectations' => $retourAffectationRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    #[Route('/new', name: 'app_retour_affectation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RetourAffectationRepository $retourAffectationRepository, EntityManagerInterface $em): Response
    {
        $retourAffectation = new RetourAffectation();
        $form = $this->createForm(RetourAffectationType::class, $retourAffectation);
        $form->handleRequest($request);

        // Soumission et validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $affecs = $retourAffectation->getAffectation();
            $affecs->setRetour(1);
            foreach ($affecs->getLaffectations() as $item) {
                $item->getAppareil()->setStatus(0);
                $em->persist($item->getAppareil());
            }
            $em->flush();
            $retourAffectationRepository->save($retourAffectation, true);
            return $this->redirectToRoute('app_retour_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'new.html.twig' avec le formulaire de création
        return $this->renderForm('metrologies/retour_affectation/new.html.twig', [
            'retour_affectation' => $retourAffectation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_retour_affectation_show', methods: ['GET'])]
    public function show(RetourAffectation $retourAffectation): Response
    {
        return $this->render('metrologies/retour_affectation/show.html.twig', [
            'retour_affectation' => $retourAffectation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_retour_affectation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RetourAffectation $retourAffectation, RetourAffectationRepository $retourAffectationRepository): Response
    {
        $form = $this->createForm(RetourAffectationType::class, $retourAffectation);
        $form->handleRequest($request);

        // Soumission et validation du formulaire d'édition
        if ($form->isSubmitted() && $form->isValid()) {
            $retourAffectationRepository->save($retourAffectation, true);
            return $this->redirectToRoute('app_retour_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'edit.html.twig' avec le formulaire d'édition
        return $this->renderForm('metrologies/retour_affectation/edit.html.twig', [
            'retour_affectation' => $retourAffectation,
            'form' => $form,
        ]);
    }

    #[Route('/sup/{id}', name: 'app_retour_affectation_delete', methods: ['GET'])]
    public function delete(Request $request, RetourAffectation $retourAffectation, RetourAffectationRepository $retourAffectationRepository): Response
    {
        if ($retourAffectation) {
            if ($retourAffectation->getAffectation()) {
                $this->addFlash('danger', 'Désolé vous ne pouvez pas supprimer cette affectation !');
                return $this->redirectToRoute('app_retour_affectation_index', [], Response::HTTP_SEE_OTHER);
            }
            $retourAffectationRepository->remove($retourAffectation, true);
            return $this->redirectToRoute('app_retour_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_retour_affectation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/print-affectation/{id}', name: 'app_affectation_retour_print', methods: ['POST', 'GET'])]
    public function print(RetourAffectation $retourAffectation): Response
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
        $html = $this->renderView('metrologies/retour_affectation/print.html.twig', [
            'retourAffectation' => $retourAffectation,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Génération d'un nom de fichier
        $fichier = "Retour Affectation : " . $retourAffectation->getAffectation()->getAffaire();

        // Envoi du PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }

    #[Route('/modifier-appareil-retour/{id}/edit', name: 'app_retour_affectation_app_edit', methods: ['GET', 'POST'])]
    public function modifier(Request $request, Laffectation $laffectation, LaffectationRepository $laffectationRepository, EntityManagerInterface $em): Response
    {
        $id = $laffectation->getAffectation()->getRetourAffectation()->getId();
        $form = $this->createForm(LaffectationRetourType::class, $laffectation);
        $form->handleRequest($request);

        // Soumission et validation du formulaire de modification
        if ($form->isSubmitted() && $form->isValid()) {
            $app = $laffectation->getAppareil();
            $app->setDesignation($laffectation->getDesignation());
            $app->setType($laffectation->getType());
            $app->setEtat($laffectation->getEtat());
            $em->persist($app);
            $em->flush($app);
            $laffectationRepository->save($laffectation, true);
            return $this->redirectToRoute('app_retour_affectation_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'edit_app_retour.html.twig' avec le formulaire de modification
        return $this->renderForm('metrologies/retour_affectation/edit_app_retour.html.twig', [
            'laffectation' => $laffectation,
            'form' => $form,
        ]);
    }
}
