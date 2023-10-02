<?php

namespace App\Controller;

use App\Entity\ServiceResponsable;
use App\Form\ServiceResponsableType;
use App\Repository\ServiceResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/responsable')]
class ServiceResponsableController extends AbstractController
{
    #[Route('/', name: 'app_service_responsable_index', methods: ['GET'])]
    public function index(ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        return $this->render('metrologies/service_responsable/index.html.twig', [
            'service_responsables' => $serviceResponsableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_responsable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        $serviceResponsable = new ServiceResponsable();
        $form = $this->createForm(ServiceResponsableType::class, $serviceResponsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceResponsableRepository->save($serviceResponsable, true);

            return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('metrologies/service_responsable/new.html.twig', [
            'service_responsable' => $serviceResponsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_responsable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceResponsable $serviceResponsable, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        $form = $this->createForm(ServiceResponsableType::class, $serviceResponsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceResponsableRepository->save($serviceResponsable, true);

            return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('metrologies/service_responsable/edit.html.twig', [
            'service_responsable' => $serviceResponsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_responsable_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, ServiceResponsable $serviceResponsable, ServiceResponsableRepository $serviceResponsableRepository): Response
    {
        if ($serviceResponsable)
        {
            $serviceResponsableRepository->remove($serviceResponsable, true);
            $this->addFlash('danger', 'Service supprimer avec succès');
        }
        return $this->redirectToRoute('app_service_responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
