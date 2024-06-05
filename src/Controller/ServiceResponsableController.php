<?php

namespace App\Controller;

use App\Entity\ServiceResponsable;
use App\Form\ServiceResponsableType;
use App\Repository\ServiceResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Définition de la route principale pour ce contrôleur
#[Route('/service/responsable')]
class ServiceResponsableController extends AbstractController
{
    // Route pour afficher la liste de tous les responsables de service
    #[Route('/', name: 'app_service_responsable_index', methods: ['GET'])]
    public function index(ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        // Rendu de la vue Twig 'index.html.twig' avec la liste des responsables de service
        return $this->render('metrologies/service_responsable/index.html.twig', [
            'service_responsables' => $serviceResponsableRepository->findAll(),
        ]);
    }

    // Route pour créer un nouveau responsable de service
    #[Route('/new', name: 'app_service_responsable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        // Création d'une nouvelle instance de ServiceResponsable
        $serviceResponsable = new ServiceResponsable();
        // Création du formulaire associé
        $form = $this->createForm(ServiceResponsableType::class, $serviceResponsable);
        // Traitement de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde du responsable de service dans le dépôt
            $serviceResponsableRepository->save($serviceResponsable, true);
            // Redirection vers la liste des responsables de service
            return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu du formulaire pour la création d'un nouveau responsable de service
        return $this->renderForm('metrologies/service_responsable/new.html.twig', [
            'service_responsable' => $serviceResponsable,
            'form' => $form,
        ]);
    }

    // Route pour éditer un responsable de service existant
    #[Route('/{id}/edit', name: 'app_service_responsable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceResponsable $serviceResponsable, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        // Création du formulaire associé
        $form = $this->createForm(ServiceResponsableType::class, $serviceResponsable);
        // Traitement de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde des modifications du responsable de service dans le dépôt
            $serviceResponsableRepository->save($serviceResponsable, true);
            // Redirection vers la liste des responsables de service
            return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu du formulaire pour l'édition du responsable de service
        return $this->renderForm('metrologies/service_responsable/edit.html.twig', [
            'service_responsable' => $serviceResponsable,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un responsable de service
    #[Route('/{id}', name: 'app_service_responsable_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, ServiceResponsable $serviceResponsable, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        // Vérification de l'existence du responsable de service
        if ($serviceResponsable) {
            // Suppression du responsable de service du dépôt
            $serviceResponsableRepository->remove($serviceResponsable, true);
            // Ajout d'un message flash pour confirmer la suppression
            $this->addFlash('danger', 'Service supprimé avec succès');
        }
        // Redirection vers la liste des responsables de service
        return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
