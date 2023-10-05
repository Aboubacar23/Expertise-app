<?php

namespace App\Controller;

use App\Entity\Appareil;
use App\Entity\Intervention;
use App\Entity\Lintervention;
use App\Form\LinterventionType;
use App\Form\LinterventionTestType;
use App\Repository\AppareilRepository;
use App\Repository\InterventionRepository;
use App\Repository\LinterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffaireMetrologieRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServiceResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/metrologie')]
class MetrologieController extends AbstractController
{
    #[Route('/index-metrologie', name: 'app_metrologie')]
    public function index(
        AppareilRepository $appareilRepository,
        AffaireMetrologieRepository $affaireMetrologieRepository,
        InterventionRepository $interventionRepository,
        ServiceResponsableRepository $serviceResponsableRepository
        ): Response
    {
        $appareils = count($appareilRepository->findAll());
        $affaireMetrologies = count($affaireMetrologieRepository->findAll());
        $interventions = count($interventionRepository->findAll());
        $services = count($serviceResponsableRepository->findAll());
        return $this->render('metrologies/index.html.twig', [
            'appareils' => $appareils,
            'affaireMetrologies' => $affaireMetrologies,
            'interventions' => $interventions,
            'services' => $services,
        ]);
    }


    #[Route('/repere/{id}', name: 'app_repere_get', methods: ['GET'])]
    public function getRepere(Appareil $appareil): JsonResponse
    {
        if (!$appareil)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        return new JsonResponse([
            'designation' => $appareil->getDesignation(),
            'marque' => $appareil->getMarque(),
            'observation' => $appareil->getObservation(),
        ]);
    }

    #[Route('/numero-da/{id}', name: 'app_numero_get', methods: ['GET'])]
    public function getNumeroDa(Intervention $intervention, LinterventionRepository $linterventionRepository): JsonResponse
    {
        if (!$intervention)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }   
        $items = [];    
        $linterventions = $linterventionRepository->findByIntervention($intervention);
        foreach ($linterventions as $item) 
        {
            $items[] = [
                'appareil' => $item->getAppareil()->getNumAppareil(),
                'designation' => $item->getDesignation(),
                'type' => $item->getType(),
                'dateR' => $item->getDateRetour()->format('d-m-Y'),
                'dateEta' => $item->getDateEtalonnage(),
                'marque' => $item->getMarque(),
                'numero' => $item->getNumeroCertificat(),
                'etat' => $item->getEtat(),
                'statut' => $item->getStatut(),
            ];
        }
       // dd($items);
        return new JsonResponse($items);
    }


    #[Route('/aaaaa/{id}', name: 'app_aaaa_new', methods: ['GET', 'POST'])]
    public function testaa(Intervention $intervention,Request $request, LinterventionRepository $linterventionRepository, EntityManagerInterface $em): Response
    {
        $linterventions = $linterventionRepository->findByIntervention($intervention);
     //   dd($linterventions);
        $forms = [];
        foreach ($linterventions as $item) {
            $cloneItem = clone $item;

            $form = $this->createForm(LinterventionTestType::class, $item);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //var_dump($form);
                if ($cloneItem != $item)
                {
                    $em->persist($item);
                    $em->flush();
                    return $this->redirectToRoute('app_aaaa_new', ['id' => $intervention->getId()]);
                }
            }
            $forms[$item->getId()] = $form->createView();
        }
        return $this->render('metrologies/test.html.twig', [
            'forms' => $forms,
        ]);
    }
 
}
