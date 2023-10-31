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

#[Route('/metrologie')]
class MetrologieController extends AbstractController
{
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
        $items = $appareilRepository->findAll();
        $appareils = count($items);
        $affaireMetrologies = count($affaireMetrologieRepository->findAll());
        $interventions = count($interventionRepository->findAll());
        $services = count($serviceResponsableRepository->findAll());
        $retours = count($retourInterventionRepository->findAll());
        $affectations = count($affectationRepository->findAll());
        $retourA = count($retourAffectationRepository->findAll());

        $hors_validite = 0;
        $conformes = 0 ;
        $fonctionnels =0;
        $perdu = 0;
        $hs = 0;
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
            'type' => $appareil->getType(),
            'numero_serie' => $appareil->getNumeroSerie(),
        ]);
    }


    #[Route('/affaire/{id}', name: 'app_affaire_get', methods: ['GET'])]
    public function getAffaire(AffaireMetrologie $affaire): JsonResponse
    {
        if (!$affaire)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }
        return new JsonResponse([
            'nom' => $affaire->getNomAffaire(),
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


    #[Route('/numero-affaire/{id}', name: 'app_nu_get', methods: ['GET'])]
    public function getNumeroAffaire(Affectation $affectation, LaffectationRepository $laffectationRepository): JsonResponse
    {
        if (!$affectation)
        {
            return new JsonResponse(['erreur' => 'appareil non trouvée'], 404);
        }   
        $items = [];    
        $laffectations = $laffectationRepository->findByAffectation($affectation);
        foreach ($laffectations as $item) 
        {
            $items[] = [
                'appareil' => $item->getAppareil()->getNumAppareil(),
                'designation' => $item->getDesignation(),
                'type' => $item->getType(),
                'dateR' => $item->getDateRetour()->format('d-m-Y'),
                'etat' => $item->getEtat(),
                'observation' => $item->getObservation(),
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

    #[Route('/service/{name}', name: 'app_service_get', methods: ['GET'])]
    public function getAppMetrologie($name, AppareilRepository $appareilRepository): JsonResponse
    {
        $items2 = $appareilRepository->findAll();
        $appareils = []; 
        foreach($items2 as $item)
        {
            if ($item->isStatus() == 0 && $item->getStatut() == "Conforme" && $item->getEtat() == "Fonctionnel" && $item->getTypeService() == $name)
            {
                array_push($appareils, $item);
            }
        }    
        
        foreach ($appareils as $item) 
        {
            $items[] = [
                'id' => $item->getId(),
                'appareil' => $item->getNumAppareil(),
            ]; 
        }

        return new JsonResponse([
            'items' => $items
        ]);
    }
 
}
