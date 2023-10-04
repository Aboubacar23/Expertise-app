<?php

namespace App\Controller;

use App\Entity\Appareil;
use App\Entity\Lintervention;
use App\Repository\AppareilRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffaireMetrologieRepository;
use App\Repository\InterventionRepository;
use Symfony\Component\Routing\Annotation\Route;
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
        ): Response
    {
        $appareils = count($appareilRepository->findAll());
        $affaireMetrologies = count($affaireMetrologieRepository->findAll());
        $interventions = count($interventionRepository->findAll());
        return $this->render('metrologies/index.html.twig', [
            'appareils' => $appareils,
            'affaireMetrologies' => $affaireMetrologies,
            'interventions' => $interventions,
        ]);
    }


    //la fonction qui permet d'activer et réactiver une affaire
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
}
