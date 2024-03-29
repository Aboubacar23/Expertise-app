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

#[Route('/type')]
class TypeController extends AbstractController
{
    #[Route('/', name: 'app_type_index', methods: ['GET'])]
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeRepository $typeRepository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type->getStatorTension2() == null)
            {
                $type->setStatorTension2(0);
            }
            if ($type->getStatorTension() == null)
            {
                $type->setStatorTension(0);
            }

            if ($type->getRotorTension2() == null)
            {
                $type->setRotorTension2(0);
            } 
            
            if ($type->getRotorTension() == null)
            {
                $type->setRotorTension(0);
            } 

            $typeRepository->save($type, true);
            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type/new.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_show', methods: ['GET'])]
    public function show(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->save($type, true);

            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_type_delete', methods: ['GET'])]
    public function delete(Request $request, Type $type, TypeRepository $typeRepository,MachineRepository $machineRepository): Response
    {
        $machines = $machineRepository->findByType($type);
        if ($type) {
            if (!$machines)
            {
                $typeRepository->remove($type, true);
                return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
            }
            else{
                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cet type, car y a des machines sur la machine ! ");
                return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);

            }
        }
        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
