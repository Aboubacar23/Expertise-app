<?php

namespace App\Controller;

use App\Entity\Correction;
use App\Entity\Critere;
use App\Form\CorrectionType;
use App\Form\CritereType;
use App\Repository\CorrectionRepository;
use App\Repository\CritereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPSTORM_META\map;

#[Route('/critere')]
class CritereController extends AbstractController
{
    #[Route('/index', name: 'app_critere_index')]
    public function index(Request $request, CritereRepository $critereRepository, CorrectionRepository $correctionRepository): Response
    {
        $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);

        $correction = new Correction();
        $form2 = $this->createForm(CorrectionType::class, $correction);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $critereRepository->save($critere, true);
            return $this->redirectToRoute('app_critere_index');
        }

        if ($form2->isSubmitted() && $form2->isValid())
        {
            $correctionRepository->save($correction, true);
            return $this->redirectToRoute('app_critere_index');
        }

        return $this->render('critere/index.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'critere' => $critere,
            'correction' => $correction,
            'criteres' => $critereRepository->findBy([],['id' => 'desc']),
            'corrections' => $correctionRepository->findBy([],['id' => 'desc'])
        ]);
    }


    #[Route('/modifier-critere/{id}', name: 'app_critere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,Critere $critere,CritereRepository $critereRepository, CorrectionRepository $correctionRepository): Response
    {
      //  $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $critereRepository->save($critere, true);
            return $this->redirectToRoute('app_critere_index');
        }

        $correction = new Correction();
        $form2 = $this->createForm(CorrectionType::class, $correction);
        $form2->handleRequest($request);

        return $this->render('critere/index.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'critere' => $critere,
            'criteres' => $critereRepository->findBy([],['id' => 'desc']),
            'corrections' => $correctionRepository->findBy([],['id' => 'desc'])
        ]);
    }

    
    #[Route('/delete/{id}', name: 'app_critere_delete')]
    public function delete(Critere $critere, CritereRepository $critereRepository): Response
    {
        if ($critere)
        {
            $critereRepository->remove($critere, true);
            return $this->redirectToRoute('app_critere_index');
        }

        return $this->redirectToRoute('app_critere_index');
    }

    #[Route('/delete-correction/{id}', name: 'app_correction_delete')]
    public function deleteCorrection(Correction $correction, CorrectionRepository $correctionRepository): Response
    {
        if ($correction)
        {
            $correctionRepository->remove($correction, true);
            return $this->redirectToRoute('app_critere_index');
        }

        return $this->redirectToRoute('app_critere_index');
    }

    #[Route('/modifier-correction/{id}', name: 'app_correction_edit', methods: ['GET', 'POST'])]
    public function editCorrection(Request $request,Correction $correction,CritereRepository $critereRepository, CorrectionRepository $correctionRepository): Response
    {
      //  $correction = new Correction();
        $form2 = $this->createForm(CorrectionType::class, $correction);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid())
        {
            $correctionRepository->save($correction, true);
            return $this->redirectToRoute('app_critere_index');
        }


        $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);

        return $this->render('critere/index.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'correction' => $correction,
            'criteres' => $critereRepository->findBy([],['id' => 'desc']),
            'corrections' => $correctionRepository->findBy([],['id' => 'desc'])
        ]);
    }
}
