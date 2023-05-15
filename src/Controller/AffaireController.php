<?php

namespace App\Controller;

use App\Entity\Affaire;
use App\Form\AffaireType;
use App\Repository\AffaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire')]
class AffaireController extends AbstractController
{
    #[Route('/', name: 'app_affaire_index', methods: ['GET'])]
    public function index(AffaireRepository $affaireRepository): Response
    {
        return $this->render('affaire/en_cours.html.twig', [
            'affaires' => $affaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository): Response
    {
        $affaire = new Affaire();
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaire->setEtat(0);
            $affaireRepository->save($affaire, true);

            return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/new.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_show', methods: ['GET'])]
    public function show(Affaire $affaire): Response
    {
        return $this->render('affaire/show.html.twig', [
            'affaire' => $affaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaireRepository->save($affaire, true);

            return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/edit.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_delete', methods: ['POST'])]
    public function delete(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affaire->getId(), $request->request->get('_token'))) {
            $affaireRepository->remove($affaire, true);
        }

        return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
