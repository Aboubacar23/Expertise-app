<?php

namespace App\Controller;

use App\Entity\Chercher;
use App\Form\ChercherPeriodiqueType;
use App\Form\ChercherType;
use App\Form\ChercherValiditeType;
use App\Repository\AppareilRepository;
use App\Service\PdfService;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        $form1 = $this->createForm(ChercherType::class, $chercher);
        $form1->handleRequest($request);

        $form2 = $this->createForm(ChercherPeriodiqueType::class, $chercher);
        $form2->handleRequest($request);

        $form3 = $this->createForm(ChercherValiditeType::class, $chercher);
        $form3->handleRequest($request);

        $appareils = $appareilRepository->findAll();

        if ($form1->isSubmitted() && $form1->isValid())
        {
            $appareils = $appareilRepository->findChercherEtat($chercher);
            $html = $this->render('metrologies/chercher/printEtat.html.twig', [
                'appareils' => $appareils,
                'etat' => $chercher->getEtat()
            ]);
            $fichier = "les appareils en état ".$chercher->getEtat();
            $pdfService->showPdfFile($html,$fichier);
        }

        if ($form2->isSubmitted() && $form2->isValid())
        {
            $appareils = $appareilRepository->findChercherPeriodicite($chercher);
            $html = $this->render('metrologies/chercher/printPeriodicite.html.twig', [
                'appareils' => $appareils,
                'etat' => $chercher->getPeriodicite()
            ]);
            $fichier = "les appareils en état ".$chercher->getPeriodicite();
            $pdfService->showPdfFile($html,$fichier);
        }

        if ($form3->isSubmitted() && $form3->isValid())
        {
            $appareils = $appareilRepository->findChercherPeriodicite($chercher);
            $html = $this->render('metrologies/chercher/printDateValidite.html.twig', [
                'appareils' => $appareils,
            ]);
            $fichier = "les appareils en état ";
            $pdfService->showPdfFile($html,$fichier);
        }

        return $this->render('metrologies/chercher/index.html.twig', [
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'chercher' => $chercher,
        ]);
    }
}
