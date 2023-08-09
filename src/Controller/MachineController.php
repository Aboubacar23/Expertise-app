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
    #[Route('/', name: 'app_machine_index', methods: ['GET'])]
    public function index(MachineRepository $machineRepository): Response
    {
        return $this->render('machine/index.html.twig', [
            'machines' => $machineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_machine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MachineRepository $machineRepository, CritereRepository $critereRepository,CorrectionRepository $correctionRepository): Response
    {
        $machine = new Machine();
        $form = $this->createForm(MachineType::class, $machine);
        $form->handleRequest($request);

        $criteres = $critereRepository->findAll();
        $critere = 0;
        foreach ($criteres as $item)
        {
            if ($item->isEtat() == 1)
            {
                $critere = $item->getMontant();
            }
        }
 
        $corrections = $correctionRepository->findAll();
        $correction = 0;
        foreach ($corrections as $item2)
        {
            if ($item2->isEtat() == 1)
            {
                $correction = $item2->getTemperature();
            }
        }

        if ($form->isSubmitted() && $form->isValid()) 
        {
            if ($machine->getStatorTension2() == null)
            {
                $machine->setStatorTension2(0);
            }
            if ($machine->getStatorTension() == null)
            {
                $machine->setStatorTension(0);
            }

            if ($machine->getRotorTension2() == null)
            {
                $machine->setRotorTension2(0);
            } 
            
            if ($machine->getRotorTension() == null)
            {
                $machine->setRotorTension(0);
            } 

            $machineRepository->save($machine, true);
            $this->addFlash('success', "Machine  a été créer");
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('machine/new.html.twig', [
            'machine' => $machine,
            'form' => $form,
            'critere' => $critere,
            'correction' => $correction,
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
        
        //on envoi ici le critère activer on formulaire
        $criteres = $critereRepository->findAll();
        $critere = 0;
        foreach ($criteres as $item)
        {
            if ($item->isEtat() == 1)
            {
                $critere = $item->getMontant();
            }
        }
 
        $corrections = $correctionRepository->findAll();
        $correction = 0;
        foreach ($corrections as $item2)
        {
            if ($item2->isEtat() == 1)
            {
                $correction = $item2->getTemperature();
            }
        }

        if ($form->isSubmitted() && $form->isValid()) 
        {

            /**
            * on vérifiie si l'un de ces attributs sont nulls 
            * pouur les attribuer 0 pour pouvoir calculer les mesures 
            */
            if ($machine->getStatorTension2() == null)
            {
                $machine->setStatorTension2(0);
            }
            if ($machine->getStatorTension() == null)
            {
                $machine->setStatorTension(0);
            }

            if ($machine->getRotorTension2() == null)
            {
                $machine->setRotorTension2(0);
            } 
            
            if ($machine->getRotorTension() == null)
            {
                $machine->setRotorTension(0);
            } 

            $machineRepository->save($machine, true);
            return $this->redirectToRoute('app_machine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('machine/edit.html.twig', [
            'machine' => $machine,
            'form' => $form,
            'critere' => $critere,
            'correction' => $correction
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
