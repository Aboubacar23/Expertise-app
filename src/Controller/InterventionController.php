<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Entity\Lintervention;
use App\Form\InterventionType;
use App\Form\LinterventionElectriqueType;
use App\Form\LinterventionMecaniqueType;
use App\Form\LinterventionType;
use App\Repository\AppareilRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InterventionRepository;
use App\Service\PdfServiceP;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Déclare la classe InterventionController qui hérite d'AbstractController
#[Route('/intervention')]
class InterventionController extends AbstractController
{
    // Route pour afficher l'index des interventions
    #[Route('/index-sortie', name: 'app_intervention_index', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        // Rend la vue avec les interventions triées par ordre décroissant d'id
        return $this->render('metrologies/intervention/index.html.twig', [
            'interventions' => $interventionRepository->findBy([],['id' => 'desc']),
        ]);
    }

    // Route pour créer une nouvelle intervention
    #[Route('/new-add', name: 'app_intervention_new', methods: ['POST','GET'])]
    public function create(Request $request, InterventionRepository $interventionRepository, EntityManagerInterface $entityManagerInterface, AppareilRepository $appareilRepository): Response
    {
        // Initialisation de variables
        $action = $request->get('action');
        $name = "";
        $intervention = new Intervention();
        $repere = new Lintervention();

        // Gestion des numéros d'intervention
        $listes = $interventionRepository->findAll();
        $compte = 0;
        $date = date('Ym');
        $an = date('Y');
        foreach($listes as $item)
        {
            if ($item->getDateDa()->format("Y") == $an)
            {
                $compte = $compte + 1;
            }
        }

        // Création du formulaire pour Intervention
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        // Création des formulaires spécifiques pour mécanique ou électrique
        if ($action == "mecanique"){
            $f = $this->createForm(LinterventionMecaniqueType::class, $repere);
            $f->handleRequest($request);
            $name = "mecanique";
            $numero_sortie = 'MEC'.'-'.$date.''.$compte;
        }elseif($action == "electrique")
        {
            $f = $this->createForm(LinterventionElectriqueType::class, $repere);
            $f->handleRequest($request);
            $name = "electrique";
            $numero_sortie = 'ELEC'.'-'.$date.''.$compte;
        }

        // Gestion de la session pour les interventions
        $session = $request->getSession();
        $items = $session->get('inters', []);

        // Si les formulaires sont soumis et valides
        if ($f->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton1');
            if ($choix == 'ajouter')
            {
                $i = 0;
                if ($items)
                {
                    foreach($items as $item)
                    {
                        $i = $i + 1;
                        $repere = new Lintervention();
                        $repere->setLig($i);
                        $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                        $repere->setAppareil($appareil);
                        $appareil->setStatus(1);
                        $repere->setDesignation($item->getDesignation());
                        $repere->setMarque($item->getMarque());
                        $repere->setType($appareil->getType());
                        $repere->setEtat($appareil->getEtat());
                        $repere->setStatut($appareil->getStatut());
                        $repere->setTypeIntervention($item->getTypeIntervention());
                        $repere->setDateRetour($item->getDateRetour());
                        $repere->setObservation($item->getObservation());
                        $repere->setIntervention($intervention);
                        $entityManagerInterface->persist($repere);
                    }

                    $intervention->setRetour(0);
                    $interventionRepository->save($intervention, true);
                    $session->clear();
                    return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
                }else
                {
                    $this->addFlash("success", "Vous ne pouvez pas ajouté de DA sans un appareil de mesure");
                    return $this->redirectToRoute('app_intervention_new', [], Response::HTTP_SEE_OTHER);
                }
            }
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $repere->setLig($lig);
                $items[$lig] = $repere;
                $session->set('inters', $items);
            }
        }

        // Rend la vue pour créer une nouvelle intervention
        return $this->renderForm('metrologies/intervention/new.html.twig', [
            'intervention' => $intervention,
            'lintervention' => $repere,
            'form' => $form,
            'f' => $f,
            'items' => $items,
            'numero_sortie' => $numero_sortie,
            'name' => $name
        ]);
    }

    // Route pour afficher les détails d'une intervention spécifique
    #[Route('/show/{id}', name: 'app_intervention_show', methods: ['GET'])]
    public function show(Intervention $intervention): Response
    {
        // Rend la vue avec les détails de l'intervention
        return $this->render('metrologies/intervention/show.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    // Route pour éditer une intervention existante
    #[Route('/{id}/edit', name: 'app_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManagerInterface, Intervention $intervention, InterventionRepository $interventionRepository, AppareilRepository $appareilRepository): Response
    {
        // Création du formulaire pour Intervention
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);
        $repere = new Lintervention();
        $app = $intervention->getLinterventions();
        $item = $app[0];

        $type_service = $item->getAppareil()->getTypeService();

        // Création des formulaires spécifiques pour mécanique ou électrique
        if($type_service == 'electrique')
        {
            $f = $this->createForm(LinterventionElectriqueType::class, $repere);
        }elseif($type_service == 'mecanique')
        {
            $f = $this->createForm(LinterventionMecaniqueType::class, $repere);
        }
        $f->handleRequest($request);

        // Gestion de la session pour les interventions
        $session = $request->getSession();
        $items = $session->get('inters', []);

        // Si les formulaires sont soumis et valides
        if ($form->isSubmitted() && $f->isSubmitted())
        {
            $choix = $request->get('bouton2');
            if ($choix == 'ajouter')
            {
                $i = 0;
                foreach($items as $item)
                {
                    $i = $i + 1;
                    $repere = new Lintervention();
                    $repere->setLig($i);
                    $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                    $repere->setAppareil($appareil);
                    $appareil->setStatus(1);
                    $repere->setDesignation($item->getDesignation());
                    $repere->setMarque($item->getMarque());
                    $repere->setTypeIntervention($item->getTypeIntervention());
                    $repere->setDateRetour($item->getDateRetour());
                    $repere->setObservation($item->getObservation());
                    $repere->setIntervention($intervention);
                    $entityManagerInterface->persist($repere);
                }

                $interventionRepository->save($intervention, true);
                $session->clear();
                return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
            }
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $repere->setLig($lig);
                $items[$lig] = $repere;
                $session->set('inters', $items);
            }
        }

        // Rend la vue pour éditer une intervention
        return $this->renderForm('metrologies/intervention/edit.html.twig', [
            'intervention' => $intervention,
            'lintervention' => $repere,
            'form' => $form,
            'f' => $f,
            'items' => $items,
        ]);
    }

    // Route pour supprimer une intervention existante
    #[Route('/{id}', name: 'app_intervention_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Intervention $intervention, InterventionRepository $interventionRepository, EntityManagerInterface $em): Response
    {
        if ($intervention)
        {
            foreach ($intervention->getLinterventions() as $item)
            {
                $item->getAppareil()->setStatus(0);
                $em->remove($item);
            }
            $em->remove($intervention);
            $em->flush();
            $interventionRepository->remove($intervention, true);
        }

        return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
    }

    // Route pour imprimer le bon de sortie d'une intervention
    #[Route('/print-intervention/{id}', name: 'app_intervention_print', methods: ['POST','GET'])]
    public function print(Intervention $intervention, PdfServiceP $pdfServiceP): Response
    {
        // Rend la vue en HTML pour le PDF
        $html = $this->renderView('metrologies/intervention/print.html.twig', [
            'intervention' => $intervention,
        ]);
        // Génère un nom de fichier
        $fichier = "Intervention : ".$intervention->getNumeroDa();

        // Retourne le PDF généré
        return $pdfServiceP->showPdfFile($html, $fichier);
    }

    // Route pour supprimer une ligne d'intervention dans la session
    #[Route('/delete/{id}', name: 'app_delete_lint')]
    public function supprimeSession($id, Request $request)
    {
        // Gestion de la session
        $session = $request->getSession();
        $items = $session->get('inters', []);
        if (array_key_exists($id, $items))
        {
            unset($items[$id]);
            $session->set('inters', $items);
        }
        return $this->redirectToRoute('app_intervention_new');
    }

    // Route pour supprimer une ligne d'intervention de la base de données
    #[Route('/supprimer/{id}', name: 'app_delete_lintervention')]
    public function supprimeSessionData(Lintervention $lintervention, EntityManagerInterface $entityManagerInterface, Request $request, AppareilRepository $appareilRepository)
    {
        $id = $lintervention->getIntervention()->getId();
        if ($lintervention)
        {
            $appareil = $appareilRepository->findOneBy(array('id'=>$lintervention->getAppareil()));
            $appareil->setStatus(0);
            $entityManagerInterface->remove($lintervention);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_intervention_edit', ['id' => $id]);
        }
        return $this->redirectToRoute('app_intervention_edit', ['id' => $id]);
    }

    // Route pour supprimer une ligne d'intervention dans la session lors de l'édition
    #[Route('/sup-session/{id}/{parID}', name: 'app_delete_ledit')]
    public function supprimeSessionEdit($id, $parID, Request $request)
    {
        // Gestion de la session
        $session = $request->getSession();
        $items = $session->get('inters', []);
        if (array_key_exists($id, $items))
        {
            unset($items[$id]);
            $session->set('inters', $items);
        }
        return $this->redirectToRoute('app_intervention_edit', ['id' => $parID]);
    }
}
