<?php

namespace App\Controller;

use App\Entity\Machine;
use App\Form\MachineType;
use App\Repository\MachineRepository;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Déclare la classe MachineController qui hérite d'AbstractController
#[Route('/machine')]
class MachineController extends AbstractController
{
    // Route pour afficher l'index des machines et permettre la création d'une nouvelle machine
    #[Route('/', name: 'app_machine_index', methods: ['GET','POST'])]
    public function index(MachineRepository $machineRepository,Request $request): Response
    {
        // Crée une nouvelle instance de Machine
        $machine = new Machine();
        // Crée le formulaire pour la Machine
        $form = $this->createForm(MachineType::class, $machine);
        // Gère la requête du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Sauvegarde la machine dans le repository
            $machineRepository->save($machine, true);
            // Ajoute un message flash de succès
            $this->addFlash('success', "Machine a été créée");
            // Redirige vers la route app_machine_index
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue avec les machines existantes et le formulaire
        return $this->render('machine/index.html.twig', [
            'machines' => $machineRepository->findAll(),
            'form' => $form->createView(),
            'machine' => $machine
        ]);
    }

    // Route pour créer une nouvelle machine
    #[Route('/new', name: 'app_machine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MachineRepository $machineRepository): Response
    {
        // Crée une nouvelle instance de Machine
        $machine = new Machine();
        // Crée le formulaire pour la Machine
        $form = $this->createForm(MachineType::class, $machine);
        // Gère la requête du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Sauvegarde la machine dans le repository
            $machineRepository->save($machine, true);
            // Ajoute un message flash de succès
            $this->addFlash('success', "Machine a été créée");
            // Redirige vers la route app_machine_index
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue avec le formulaire
        return $this->renderForm('machine/new.html.twig', [
            'machine' => $machine,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'une machine spécifique
    #[Route('/{id}', name: 'app_machine_show', methods: ['GET'])]
    public function show(Machine $machine): Response
    {
        // Rend la vue avec les détails de la machine
        return $this->render('machine/show.html.twig', [
            'machine' => $machine,
        ]);
    }

    // Route pour éditer une machine existante
    #[Route('/{id}/edit', name: 'app_machine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Machine $machine, MachineRepository $machineRepository): Response
    {
        // Crée le formulaire pour la Machine
        $form = $this->createForm(MachineType::class, $machine);
        // Gère la requête du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Si la sous-catégorie 3 est nulle, la définit à une chaîne vide
            if ($machine->getSousCategorie3() == null)
            {
                $machine->setSousCategorie3(' ');
            }

            // Si la sous-catégorie 2 est nulle, la définit à une chaîne vide
            if ($machine->getSousCategorie2() == null)
            {
                $machine->setSousCategorie2(' ');
            }
            // Sauvegarde la machine dans le repository
            $machineRepository->save($machine, true);
            // Redirige vers la route app_machine_index
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rend la vue avec le formulaire
        return $this->renderForm('machine/edit.html.twig', [
            'machine' => $machine,
            'form' => $form,
        ]);
    }

    // Route pour supprimer une machine existante
    #[Route('/delete/{id}', name: 'app_machine_delete', methods: ['GET'])]
    public function delete(Request $request, Machine $machine, MachineRepository $machineRepository, ParametreRepository $parametreRepository): Response
    {
        // Trouve les paramètres associés à la machine
        $parametre = $parametreRepository->findByMachine($machine);
        if ($machine)
        {
            // Si aucun paramètre n'est associé, supprime la machine
            if (!$parametre)
            {
                $machineRepository->remove($machine, true);
                return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
            }else{
                // Ajoute un message flash de danger si des paramètres sont associés
                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cette machine, car il y a des paramètres sur la machine !");
                return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
    }
}
