<?php

namespace App\Controller;

use App\Entity\Appareil;
use App\Form\AppareilType;
use App\Repository\AppareilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appareil')]
class AppareilController extends AbstractController
{
    #[Route('/', name: 'app_appareil_index', methods: ['GET'])]
    public function index(AppareilRepository $appareilRepository): Response
    {
        return $this->render('appareil/index.html.twig', [
            'appareils' => $appareilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_appareil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppareilRepository $appareilRepository): Response
    {
        $appareil = new Appareil();
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appareilRepository->save($appareil, true);

            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appareil/new.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appareil_show', methods: ['GET'])]
    public function show(Appareil $appareil): Response
    {
        return $this->render('appareil/show.html.twig', [
            'appareil' => $appareil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appareil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appareil $appareil, AppareilRepository $appareilRepository): Response
    {
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appareilRepository->save($appareil, true);
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appareil/edit.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_appareil_delete', methods: ['GET'])]
    public function delete(Request $request, Appareil $appareil, AppareilRepository $appareilRepository): Response
    {
       if($appareil){
        $appareilRepository->remove($appareil, true);
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);

       }else{
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);

       } 
    }
}
