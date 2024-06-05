<?php
/**
 * ----------------------------------------------------------------
 * Projet : Base Métrologie
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 25-05-2023
 * Dernière date de modification : -
 * ----------------------------------------------------------------
 * *******Template **************************
 * Les vues client se trouvent dans le dossier "client" du template
 * ********************** Description *****************************
 * Ce contrôleur est composé de plusieurs fonctions pour gérer différents contrôles :
 * 1- La fonction "index" : pour afficher et envoyer le formulaire de contre expertise.
 * 2- La fonction "deleteIsolement" : pour supprimer un contrôle d'isolement.
 * 3- La fonction "deleteResistance" : pour supprimer un contrôle de résistance.
 * 4- La fonction "controleGeo" : pour afficher et envoyer le formulaire de contrôle géométrique.
 * 5- La fonction "deleteGeo" : pour supprimer un type de contrôle géométrique.
 * 6- La fonction "editIsolement" : pour modifier un contrôle d'isolement existant.
 * 7- La fonction "editResistance" : pour modifier un contrôle de résistance existant.
 */

namespace App\Controller;

use App\Entity\ControleIsolement;
use App\Entity\ControleResistance;
use App\Entity\TypeControleGeo;
use App\Form\ControleGeoType;
use App\Form\ControleIsolementType;
use App\Form\ControleResistanceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleResistanceRepository;
use App\Repository\TypeControleGeoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/controles')]
class ControleController extends AbstractController
{
    // Fonction pour afficher et envoyer le formulaire de contre expertise
    #[Route('/controle-mesure-index', name: 'app_controle_index')]
    public function index(Request $request, ControleIsolementRepository $controleIsolementRepository, ControleResistanceRepository $controleResistanceRepository): Response
    {
        // Récupère tous les contrôles d'isolement et de résistance
        $isolements = $controleIsolementRepository->findAll();
        $resistances = $controleResistanceRepository->findAll();

        // Crée de nouvelles instances de ControleIsolement et ControleResistance
        $controleIsolement = new ControleIsolement();
        $controleResistance = new ControleResistance();

        // Crée les formulaires pour ControleIsolement et ControleResistance
        $form1 = $this->createForm(ControleIsolementType::class, $controleIsolement);
        $form2 = $this->createForm(ControleResistanceType::class, $controleResistance);

        // Gère la soumission des formulaires
        $form1->handleRequest($request);
        $form2->handleRequest($request);

        // Vérifie si le formulaire de contrôle d'isolement est soumis et valide
        if ($form1->isSubmitted() && $form1->isValid()) {
            // Sauvegarde le contrôle d'isolement et ajoute un message flash
            $controleIsolementRepository->save($controleIsolement, true);
            $message = "Contrôle d'isolement " . $controleIsolement->getLibelle() . " ajouté avec succès";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('app_controle_index');
        }

        // Vérifie si le formulaire de contrôle de résistance est soumis et valide
        if ($form2->isSubmitted() && $form2->isValid()) {
            // Sauvegarde le contrôle de résistance et ajoute un message flash
            $controleResistanceRepository->save($controleResistance, true);
            $message = "Contrôle de résistance " . $controleResistance->getLibelle() . " ajouté avec succès";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('app_controle_index');
        }

        // Rend la vue avec les contrôles d'isolement et de résistance, et les formulaires
        return $this->render('controle/index.html.twig', [
            'isolements' => $isolements,
            'resistances' => $resistances,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    // Fonction pour supprimer un contrôle d'isolement
    #[Route('/delete-isolement/{id}', name: 'app_delete_isolement')]
    public function deleteIsolement(ControleIsolement $controleIsolement, ControleIsolementRepository $controleIsolementRepository): Response
    {
        if ($controleIsolement) {
            // Supprime le contrôle d'isolement
            $controleIsolementRepository->remove($controleIsolement, true);
            return $this->redirectToRoute('app_controle_index');
        }
    }

    // Fonction pour supprimer un contrôle de résistance
    #[Route('/delete-resistance/{id}', name: 'app_delete_resistance')]
    public function deleteResistance(ControleResistance $controleResistance, ControleResistanceRepository $controleResistanceRepository): Response
    {
        if ($controleResistance) {
            // Supprime le contrôle de résistance
            $controleResistanceRepository->remove($controleResistance, true);
            return $this->redirectToRoute('app_controle_index');
        }
    }

    // Fonction pour afficher et envoyer le formulaire de contrôle géométrique
    #[Route('/type-controle-geometrique', name: 'app_type_geo_index')]
    public function controleGeo(Request $request, TypeControleGeoRepository $typeControleGeoRepository): Response
    {
        // Crée une nouvelle instance de TypeControleGeo
        $type = new TypeControleGeo();

        // Crée le formulaire pour TypeControleGeo
        $form = $this->createForm(ControleGeoType::class, $type);
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde le type de contrôle géométrique
            $typeControleGeoRepository->save($type, true);
            return $this->redirectToRoute('app_type_geo_index');
        }

        // Rend la vue avec les types de contrôles géométriques et le formulaire
        return $this->render('controle/type.html.twig', [
            'types' => $typeControleGeoRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    // Fonction pour supprimer un type de contrôle géométrique
    #[Route('/delete-geo/{id}', name: 'app_delete_type_geo_index')]
    public function deleteGeo(TypeControleGeo $typeControleGeo, TypeControleGeoRepository $typeControleGeoRepository): Response
    {
        if ($typeControleGeo) {
            // Supprime le type de contrôle géométrique
            $typeControleGeoRepository->remove($typeControleGeo, true);
            return $this->redirectToRoute('app_type_geo_index');
        }
    }

    // Fonction pour modifier un contrôle d'isolement existant
    #[Route('/edit/controle-isolement/{id}', name: 'app_edit_isolement_controle')]
    public function editIsolement(ControleIsolement $controleIsolement, Request $request, ControleIsolementRepository $controleIsolementRepository): Response
    {
        // Crée le formulaire pour ControleIsolement
        $form1 = $this->createForm(ControleIsolementType::class, $controleIsolement);
        $form1->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form1->isSubmitted() && $form1->isValid()) {
            // Sauvegarde le contrôle d'isolement modifié et ajoute un message flash
            $controleIsolementRepository->save($controleIsolement, true);
            $message = "Contrôle d'isolement " . $controleIsolement->getLibelle() . " modifié avec succès";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('app_controle_index');
        }

        // Rend la vue avec le formulaire de modification du contrôle d'isolement
        return $this->render('controle/edit_isolement.html.twig', [
            'controleIsolement' => $controleIsolement,
            'form' => $form1->createView(),
        ]);
    }

    // Fonction pour modifier un contrôle de résistance existant
    #[Route('/edit/controle-resistance/{id}', name: 'app_edit_resistance_controle')]
    public function editResistance(ControleResistance $controleResistance, Request $request, ControleResistanceRepository $controleResistanceRepository): Response
    {
        // Crée le formulaire pour ControleResistance
        $form = $this->createForm(ControleResistanceType::class, $controleResistance);
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde le contrôle de résistance modifié et ajoute un message flash
            $controleResistanceRepository->save($controleResistance, true);
            $message = "Contrôle de résistance " . $controleResistance->getLibelle() . " modifié avec succès";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('app_controle_index');
        }

        // Rend la vue avec le formulaire de modification du contrôle de résistance
        return $this->render('controle/edit_resistance.html.twig', [
            'controleResistance' => $controleResistance,
            'form' => $form->createView(),
        ]);
    }
}
