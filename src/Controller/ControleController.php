<?php

namespace App\Controller;

use App\Entity\ControleIsolement;
use App\Entity\ControleResistance;
use App\Form\ControleIsolementType;
use App\Form\ControleResistanceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleResistanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/controles')]
class ControleController extends AbstractController
{
    #[Route('/controle-mesure-index', name: 'app_controle_index')]
    public function index(Request $request,ControleIsolementRepository $controleIsolementRepository, ControleResistanceRepository $controleResistanceRepository): Response
    {
        $isolements = $controleIsolementRepository->findAll();
        $resistances = $controleResistanceRepository->findAll();

        $controleIsolement = new ControleIsolement();
        $controleResistance = new ControleResistance();

        $form1 = $this->createForm(ControleIsolementType::class, $controleIsolement);
        $form2 = $this->createForm(ControleResistanceType::class, $controleResistance);

        $form1->handleRequest($request);
        $form2->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid())
        {
            $controleIsolementRepository->save($controleIsolement, true);
            return $this->redirectToRoute('app_controle_index');
        }

        if($form2->isSubmitted() && $form2->isValid())
        {
            $controleResistanceRepository->save($controleResistance, true);
            return $this->redirectToRoute('app_controle_index');
        }

        return $this->render('controle/index.html.twig', [
            'isolements' => $isolements,
            'resistances' => $resistances,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    #[Route('delete-isolement/{id}', name : 'app_delete_isolement')]
    public function deleteIsolement(ControleIsolement $controleIsolement, ControleIsolementRepository $controleIsolementRepository)
    {
        if($controleIsolement)
        {
            $controleIsolementRepository->remove($controleIsolement, true);
            return $this->redirectToRoute('app_controle_index');
        }
    }

    #[Route('delete-resistance/{id}', name : 'app_delete_resistance')]
    public function deleteResistance(ControleResistance $controleResistance, ControleResistanceRepository $controleResistanceRepository)
    {
        if($controleResistance)
        {
            $controleResistanceRepository->remove($controleResistance, true);
            return $this->redirectToRoute('app_controle_index');
        }
        
    }
}
