<?php

namespace App\Controller;

use App\Entity\Appareil;
use App\Entity\Affectation;
use App\Entity\Intervention;
use App\Entity\Lintervention;
use App\Form\LinterventionType;
use App\Entity\AffaireMetrologie;
use App\Form\LinterventionTestType;
use App\Repository\AppareilRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use App\Repository\InterventionRepository;
use App\Repository\LaffectationRepository;
use App\Repository\LinterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AffaireMetrologieRepository;
use App\Repository\RetourAffectationRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RetourInterventionRepository;
use App\Repository\ServiceResponsableRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Déclare la classe MetrologieController qui hérite d'AbstractController
#[Route('/metrologie')]
class MetrologieController extends AbstractController
{
    // Route pour l'index de la métrologie
    #[Route('/index-metrologie', name: 'app_metrologie')]
    public function index(
        AppareilRepository $appareilRepository,
        AffaireMetrologieRepository $affaireMetrologieRepository,
        InterventionRepository $interventionRepository,
        ServiceResponsableRepository $serviceResponsableRepository,
        RetourInterventionRepository $retourInterventionRepository,
        AffectationRepository $affectationRepository,
        RetourAffectationRepository $retourAffectationRepository,
    ): Response
    {
        // Récupère tous les appareils
        $items = $appareilRepository->findAll();
        // Compte les appareils
        $appareils = count($items);
        // Compte les affaires de métrologie
        $affaireMetrologies = count($affaireMetrologieRepository->findAll());
        // Compte les interventions
        $interventions = count($interventionRepository->findAll());
        // Compte les services responsables
        $services = count($serviceResponsableRepository->findAll());
        // Compte les retours d'intervention
        $retours = count($retourInterventionRepository->findAll());
        // Compte les affectations
        $affectations = count($affectationRepository->findAll());
        // Compte les retours d'affectation
        $retourA = count($retourAffectationRepository->findAll());

        // Initialise les compteurs d'état des appareils
        $hors_validite = 0;
        $conformes = 0 ;
        $fonctionnels =0;
        $perdu = 0;
        $hs = 0;

        // Boucle à travers tous les appareils pour compter leurs états
        foreach($items as $item)
        {
            if ($item->getEtat() == 'Fonctionnel')
            {
                $fonctionnels = $fonctionnels + 1;
            }
            if ($item->getEtat() == 'Hors Validite')
            {
                $hors_validite = $hors_validite + 1;
            }
            if ($item->getEtat() == 'Perdu')
            {
                $perdu = $perdu + 1;
            }
            if ($item->getEtat() == 'HS')
            {
                $hs = $hs + 1;
            }
            if ($item->getStatut() == 'Conforme')
            {
                $conformes = $conformes + 1;
            }
        }

        // Rend la vue avec les statistiques des appareils
        return $this->render('metrologies/index.html.twig', [
            'appareils' => $appareils,
            'affaireMetrologies' => $affaireMetrologies,
            'interventions' => $interventions,
            'services' => $services,
            'affectations' => $affectations,
            'retours' => $retours,
            'retourA' => $retourA,
            'hors_validite' => $hors_validite,
            'conformes' => $conformes,
            'fonctionnels' => $fonctionnels,
            'perdu' => $perdu,
            'hs' => $hs,
        ]);
    }

    // Route pour obtenir les informations d'un appareil par son ID
    #[Route('/repere/{id}', name: 'app_repere_get', methods: ['GET'])]
    public function getRepere(Appareil $appareil): JsonResponse
    {
        if (!$appareil)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        // Retourne les détails de l'appareil en format JSON
        return new JsonResponse([
            'designation' => $appareil->getDesignation(),
            'marque' => $appareil->getMarque(),
            'observation' => $appareil->getObservation(),
            'type' => $appareil->getType(),
            'numero_serie' => $appareil->getNumeroSerie(),
        ]);
    }

    // Route pour obtenir les informations d'une affaire de métrologie par son ID
    #[Route('/affaire/{id}', name: 'app_affaire_get', methods: ['GET'])]
    public function getAffaire(AffaireMetrologie $affaire): JsonResponse
    {
        if (!$affaire)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        // Retourne le nom de l'affaire en format JSON
        return new JsonResponse([
            'nom' => $affaire->getNomAffaire(),
        ]);
    }

    // Route pour obtenir les informations d'une intervention par son ID
    #[Route('/numero-da/{id}', name: 'app_numero_get', methods: ['GET'])]
    public function getNumeroDa(Intervention $intervention, LinterventionRepository $linterventionRepository): JsonResponse
    {
        if (!$intervention)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        $items = [];
        // Récupère les lignes d'intervention associées à une intervention
        $linterventions = $linterventionRepository->findByIntervention($intervention);
        foreach ($linterventions as $item)
        {
            // Ajoute les détails de chaque ligne d'intervention à la liste
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
        // Retourne les détails des lignes d'intervention en format JSON
        return new JsonResponse($items);
    }

    // Route pour obtenir les informations d'une affectation par son ID
    #[Route('/numero-affaire/{id}', name: 'app_nu_get', methods: ['GET'])]
    public function getNumeroAffaire(Affectation $affectation, LaffectationRepository $laffectationRepository): JsonResponse
    {
        if (!$affectation)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        $items = [];
        // Récupère les lignes d'affectation associées à une affectation
        $laffectations = $laffectationRepository->findByAffectation($affectation);
        foreach ($laffectations as $item)
        {
            // Ajoute les détails de chaque ligne d'affectation à la liste
            $items[] = [
                'appareil' => $item->getAppareil()->getNumAppareil(),
                'designation' => $item->getDesignation(),
                'type' => $item->getType(),
                'dateR' => $item->getDateRetour()->format('d-m-Y'),
                'etat' => $item->getEtat(),
                'observation' => $item->getObservation(),
            ];
        }
        // Retourne les détails des lignes d'affectation en format JSON
        return new JsonResponse($items);
    }

    // Route pour tester l'affichage et la manipulation des lignes d'intervention
    #[Route('/aaaaa/{id}', name: 'app_aaaa_new', methods: ['GET', 'POST'])]
    public function testaa(Intervention $intervention,Request $request, LinterventionRepository $linterventionRepository, EntityManagerInterface $em): Response
    {
        // Récupère les lignes d'intervention associées à une intervention
        $linterventions = $linterventionRepository->findByIntervention($intervention);
        $forms = [];
        foreach ($linterventions as $item) {
            // Clone chaque ligne d'intervention pour comparaison
            $cloneItem = clone $item;

            // Crée un formulaire pour chaque ligne d'intervention
            $form = $this->createForm(LinterventionTestType::class, $item);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Sauvegarde les modifications si la ligne d'intervention a changé
                if ($cloneItem != $item)
                {
                    $em->persist($item);
                    $em->flush();
                    return $this->redirectToRoute('app_aaaa_new', ['id' => $intervention->getId()]);
                }
            }
            // Ajoute le formulaire à la liste des formulaires
            $forms[$item->getId()] = $form->createView();
        }
        // Rend la vue avec les formulaires des lignes d'intervention
        return $this->render('metrologies/test.html.twig', [
            'forms' => $forms,
        ]);
    }

    // Route pour obtenir les appareils disponibles d'un service spécifique
    #[Route('/service/{name}', name: 'app_service_get', methods: ['GET'])]
    public function getAppMetrologie($name, AppareilRepository $appareilRepository): JsonResponse
    {
        // Récupère tous les appareils
        $items2 = $appareilRepository->findAll();
        $appareils = [];
        // Filtre les appareils disponibles d'un service spécifique
        foreach($items2 as $item)
        {
            if ($item->isStatus() == 0 && $item->getStatut() == "Conforme" && $item->getEtat() == "Fonctionnel" && $item->getTypeService() == $name)
            {
                array_push($appareils, $item);
            }
        }

        $items = [];
        // Ajoute les détails de chaque appareil disponible à la liste
        foreach ($appareils as $item)
        {
            $items[] = [
                'id' => $item->getId(),
                'appareil' => $item->getNumAppareil(),
            ];
        }

        // Retourne les détails des appareils disponibles en format JSON
        return new JsonResponse([
            'items' => $items
        ]);
    }
}
