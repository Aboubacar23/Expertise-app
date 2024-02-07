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
 * Dérniere date de modification : -
 * ----------------------------------------------------------------
 *******Template **************************
 les views client se trouvent dans le dossier "client" du template
 * ********************** Déscription *****************************
 * Ce controleur est composé d'une seule fonction
 * 1- la fonction "index" : pour afficher et envoyer le formulaire de contre expertise
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

    #[Route('/delete-isolement/{id}', name : 'app_delete_isolement')]
    public function deleteIsolement(ControleIsolement $controleIsolement, ControleIsolementRepository $controleIsolementRepository)
    {
        if($controleIsolement)
        {
            $controleIsolementRepository->remove($controleIsolement, true);
            return $this->redirectToRoute('app_controle_index');
        }
    }

    #[Route('/delete-resistance/{id}', name : 'app_delete_resistance')]
    public function deleteResistance(ControleResistance $controleResistance, ControleResistanceRepository $controleResistanceRepository)
    {
        if($controleResistance)
        {
            $controleResistanceRepository->remove($controleResistance, true);
            return $this->redirectToRoute('app_controle_index');
        }
        
    }


    #[Route('/type-controle-geometrique', name: 'app_type_geo_index')]
    public function controleGeo(Request $request,TypeControleGeoRepository $typeControleGeoRepository): Response
    {
        $type = new TypeControleGeo();
        $form = $this->createForm(ControleGeoType::class, $type);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $typeControleGeoRepository->save($type, true);
            return $this->redirectToRoute('app_type_geo_index');
        }

        return $this->render('controle/type.html.twig', [
            'types' => $typeControleGeoRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/delete-geo/{id}', name : 'app_delete_type_geo_index')]
    public function deleteGeo(TypeControleGeo $typeControleGeo, TypeControleGeoRepository $typeControleGeoRepository)
    {
        if($typeControleGeo)
        {
            $typeControleGeoRepository->remove($typeControleGeo, true);
            return $this->redirectToRoute('app_type_geo_index');
        }
    }

}
