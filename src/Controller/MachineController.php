<?php

namespace App\Controller;

use App\Entity\Machine;
use App\Form\MachineType;
use App\Repository\CritereRepository;
use App\Repository\MachineRepository;
use App\Repository\CorrectionRepository;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/machine')]
class MachineController extends AbstractController
{
    #[Route('/', name: 'app_machine_index', methods: ['GET','POST'])]
    public function index(MachineRepository $machineRepository,Request $request): Response
    {
        $machine = new Machine();
        $form = $this->createForm(MachineType::class, $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $machineRepository->save($machine, true);
            $this->addFlash('success', "Machine  a été créer");
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('machine/index.html.twig', [
            'machines' => $machineRepository->findAll(),
            'form' => $form->createView(),
            'machine' => $machine
        ]);
    }

    #[Route('/new', name: 'app_machine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MachineRepository $machineRepository, CritereRepository $critereRepository,CorrectionRepository $correctionRepository): Response
    {
        $machine = new Machine();
        $form = $this->createForm(MachineType::class, $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $machineRepository->save($machine, true);
            $this->addFlash('success', "Machine  a été créer");
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('machine/new.html.twig', [
            'machine' => $machine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_machine_show', methods: ['GET'])]
    public function show(Machine $machine): Response
    {
        return $this->render('machine/show.html.twig', [
            'machine' => $machine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_machine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Machine $machine, MachineRepository $machineRepository, CritereRepository $critereRepository,CorrectionRepository $correctionRepository): Response
    {
        $form = $this->createForm(MachineType::class, $machine);
        $form->handleRequest($request);   

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $machineRepository->save($machine, true);
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('machine/edit.html.twig', [
            'machine' => $machine,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_machine_delete', methods: ['GET'])]
    public function delete(Request $request, Machine $machine, MachineRepository $machineRepository, ParametreRepository $parametreRepository): Response
    {
        $parametre = $parametreRepository->findByMachine($machine);
        if ($machine) 
        {
            if (!$parametre)
            {
                $machineRepository->remove($machine, true);
                return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
            }else{ 

                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cette machine, car y a des paramètres sur la machine ! ");
                return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
    }
}
