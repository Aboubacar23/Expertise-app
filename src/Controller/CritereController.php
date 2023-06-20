<?php

namespace App\Controller;

use App\Entity\Critere;
use App\Form\CritereType;
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
    public function index(Request $request, CritereRepository $critereRepository): Response
    {
        $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $critereRepository->save($critere, true);
            return $this->redirectToRoute('app_critere_index');
        }

        return $this->render('critere/index.html.twig', [
            'form' => $form->createView(),
            'critere' => $critere,
            'criteres' => $critereRepository->findBy([],['id' => 'desc'])
        ]);
    }

    #[Route('/modifier-critere/{id}', name: 'app_critere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,Critere $critere,CritereRepository $critereRepository): Response
    {
      //  $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $critereRepository->save($critere, true);
            return $this->redirectToRoute('app_critere_index');
        }

        return $this->render('critere/index.html.twig', [
            'form' => $form->createView(),
            'critere' => $critere,
            'criteres' => $critereRepository->findBy([],['id' => 'desc'])
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
}
