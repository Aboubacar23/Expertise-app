<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\MachineRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Définition de la route principale pour ce contrôleur
#[Route('/type')]
class TypeController extends AbstractController
{
    // Route pour afficher la liste de tous les types
    #[Route('/', name: 'app_type_index', methods: ['GET'])]
    public function index(TypeRepository $typeRepository): Response
    {
        // Rendu de la vue Twig 'type/index.html.twig' avec la liste des types
        return $this->render('type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    // Route pour créer un nouveau type
    #[Route('/new', name: 'app_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeRepository $typeRepository): Response
    {
        // Création d'une nouvelle instance de Type
        $type = new Type();
        // Création du formulaire associé
        $form = $this->createForm(TypeType::class, $type);
        // Traitement de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Si les tensions du stator ou du rotor sont nulles, les définir à 0
            if ($type->getStatorTension2() == null) {
                $type->setStatorTension2(0);
            }
            if ($type->getStatorTension() == null) {
                $type->setStatorTension(0);
            }
            if ($type->getRotorTension2() == null) {
                $type->setRotorTension2(0);
            }
            if ($type->getRotorTension() == null) {
                $type->setRotorTension(0);
            }

            // Sauvegarde du type dans le dépôt
            $typeRepository->save($type, true);
            // Redirection vers la liste des types
            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu du formulaire pour la création d'un nouveau type
        return $this->renderForm('type/new.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'un type spécifique
    #[Route('/{id}', name: 'app_type_show', methods: ['GET'])]
    public function show(Type $type): Response
    {
        // Rendu de la vue Twig 'type/show.html.twig' avec les détails du type
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    // Route pour éditer un type existant
    #[Route('/{id}/edit', name: 'app_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        // Création du formulaire associé
        $form = $this->createForm(TypeType::class, $type);
        // Traitement de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde des modifications du type dans le dépôt
            $typeRepository->save($type, true);
            // Redirection vers la liste des types
            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendu du formulaire pour l'édition du type
        return $this->renderForm('type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un type
    #[Route('/delete/{id}', name: 'app_type_delete', methods: ['GET'])]
    public function delete(Request $request, Type $type, TypeRepository $typeRepository, MachineRepository $machineRepository): Response
    {
        // Recherche des machines associées à ce type
        $machines = $machineRepository->findByType($type);

        // Vérification de l'existence du type et des machines associées
        if ($type) {
            if (!$machines) {
                // Si aucune machine n'est associée, suppression du type
                $typeRepository->remove($type, true);
                return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Si des machines sont associées, affichage d'un message d'erreur
                $this->addFlash('danger', "Désolé, vous ne pouvez pas supprimer ce type, car il y a des machines associées !");
                return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        // Redirection vers la liste des types
        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
