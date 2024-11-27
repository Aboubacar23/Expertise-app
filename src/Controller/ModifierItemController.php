<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\AccessoireSupplementaire; // Importe l'entité AccessoireSupplementaire
use App\Entity\LMesureIsolement; // Importe l'entité LMesureIsolement
use App\Entity\LMesureIsolementEssai; // Importe l'entité LMesureIsolementEssai
use App\Entity\LMesureResistance; // Importe l'entité LMesureResistance
use App\Entity\LMesureResistanceEssai; // Importe l'entité LMesureResistanceEssai
use App\Entity\LSondeBobinage; // Importe l'entité LSondeBobinage
use App\Entity\LStatorApresLavage; // Importe l'entité LStatorApresLavage
use App\Entity\ReleveDimmensionnel; // Importe l'entité ReleveDimmensionnel
use App\Entity\SondeBobinage; // Importe l'entité SondeBobinage
use App\Entity\StatorApresLavage; // Importe l'entité StatorApresLavage
use App\Entity\Synoptique; // Importe l'entité Synoptique
use App\Form\AccessoireSupplementaireType; // Importe le formulaire AccessoireSupplementaireType
use App\Form\LMesureIsolementEditType; // Importe le formulaire LMesureIsolementEditType
use App\Form\LMesureIsolementEssaiEditType; // Importe le formulaire LMesureIsolementEssaiEditType
use App\Form\LMesureIsolementType; // Importe le formulaire LMesureIsolementType
use App\Form\LMesureResistanceEditType; // Importe le formulaire LMesureResistanceEditType
use App\Form\LMesureResistanceEssaiEditType; // Importe le formulaire LMesureResistanceEssaiEditType
use App\Form\LMesureResistanceType; // Importe le formulaire LMesureResistanceType
use App\Form\LSondeBobinageEditType; // Importe le formulaire LSondeBobinageEditType
use App\Form\LStatorApresLavageEditType; // Importe le formulaire LStatorApresLavageEditType
use App\Form\ReleveDimmensionnelType; // Importe le formulaire ReleveDimmensionnelType
use App\Form\SynoptiqueType; // Importe le formulaire SynoptiqueType
use App\Repository\AccessoireSupplementaireRepository; // Importe le repository AccessoireSupplementaireRepository
use App\Repository\ControleIsolementRepository; // Importe le repository ControleIsolementRepository
use App\Repository\LMesureIsolementEssaiRepository; // Importe le repository LMesureIsolementEssaiRepository
use App\Repository\LMesureIsolementRepository; // Importe le repository LMesureIsolementRepository
use App\Repository\LMesureResistanceEssaiRepository; // Importe le repository LMesureResistanceEssaiRepository
use App\Repository\LMesureResistanceRepository; // Importe le repository LMesureResistanceRepository
use App\Repository\LSondeBobinageRepository; // Importe le repository LSondeBobinageRepository
use App\Repository\LStatorApresLavageRepository; // Importe le repository LStatorApresLavageRepository
use App\Repository\ReleveDimmensionnelRepository; // Importe le repository ReleveDimmensionnelRepository
use App\Repository\StatorApresLavageRepository; // Importe le repository StatorApresLavageRepository
use App\Repository\SynoptiqueRepository; // Importe le repository SynoptiqueRepository
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour la gestion des entités
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController pour les fonctionnalités de contrôleur
use Symfony\Component\HttpFoundation\Request; // Importe la classe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe la classe Response pour gérer les réponses HTTP
use Symfony\Component\Routing\Annotation\Route; // Importe la classe Route pour définir les routes

#[Route('/modifier-item')] // Définit la route de base pour ce contrôleur
class ModifierItemController extends AbstractController
{
    #[Route('/modifier/{id}/synoptique', name: 'app_edit_synoptique', methods: ['GET','POST'])] // Définit la route pour éditer un synoptique
    public function synoptique(Synoptique $synoptique, SynoptiqueRepository $synoptiqueRepository, Request $request) : Response
    {
        $form = $this->createForm(SynoptiqueType::class, $synoptique); // Crée le formulaire pour Synoptique
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            $synoptiqueRepository->save($synoptique, true); // Sauvegarde le synoptique
            return $this->redirectToRoute('app_synoptique', ['id' => $synoptique->getParametre()->getId()]); // Redirige vers la vue du synoptique
        }

        // Rendu du formulaire d'édition de Synoptique
        return $this->render('modifier_item/synoptique.html.twig', [
            'synoptique' => $synoptique,
            'form' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id}/controle', name: 'app_edit_controle', methods: ['GET','POST'])] // Définit la route pour éditer un contrôle visuel
    public function consoleVisuel(AccessoireSupplementaire $accessoireSupplementaire, Request $request, AccessoireSupplementaireRepository $accessoireSupplementaireRepository): Response
    {
        $form = $this->createForm(AccessoireSupplementaireType::class, $accessoireSupplementaire); // Crée le formulaire pour AccessoireSupplementaire
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isSubmitted())
        {
            $accessoireSupplementaireRepository->save($accessoireSupplementaire, true); // Sauvegarde l'accessoire supplémentaire
            return  $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $accessoireSupplementaire->getControleVisuelMecanique()->getParametre()->getId()]); // Redirige vers la vue du contrôle visuel mécanique
        }

        // Rendu du formulaire d'édition de AccessoireSupplementaire
        return $this->render('modifier_item/controle_visuel.html.twig', [
            'form' => $form->createView(),
            'accessoireSupplementaire' => $accessoireSupplementaire,
        ]);
    }

    #[Route('/modifier/{id}/releve', name: 'app_edit_releve', methods: ['GET','POST'])] // Définit la route pour éditer un relevé dimensionnel
    public function releveDimensionnel(ReleveDimmensionnelRepository $releveDimmensionnelRepository, ReleveDimmensionnel $releveDimmensionnel, Request $request): Response
    {
        // La partie relevés dimensionnels rotor et paliers
        $formReleveDimmensionnel = $this->createForm(ReleveDimmensionnelType::class, $releveDimmensionnel); // Crée le formulaire pour ReleveDimmensionnel
        $formReleveDimmensionnel->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($formReleveDimmensionnel->isSubmitted() && $formReleveDimmensionnel->isValid())
        {
            $releveDimmensionnelRepository->save($releveDimmensionnel, true); // Sauvegarde le relevé dimensionnel
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $releveDimmensionnel->getParametre()->getId()]); // Redirige vers la vue du relevé dimensionnel
        }

        // Rendu du formulaire d'édition de ReleveDimmensionnel
        return $this->render('modifier_item/releve_dimensionnels.html.twig', [
            'releveDimmensionnel' => $releveDimmensionnel,
            'formReleveDimmensionnel' => $formReleveDimmensionnel->createView()
        ]);
    }

    // Modification de mesure d'isolement avant lavage
    #[Route('/modifier-isolement/{id}', name: 'app_edit_mesure_isolement', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure d'isolement avant lavage
    public function mesureIsolement(LMesureIsolement $lmesureIsolement, Request $request, LMesureIsolementRepository $lMesureIsolementRepository): Response
    {
        $form = $this->createForm(LMesureIsolementEditType::class, $lmesureIsolement); // Crée le formulaire pour LMesureIsolement
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            if (is_int($lmesureIsolement->getValeur()))
            {
                $valeur = $lmesureIsolement->getValeur(); // Récupère la valeur de l'isolement
            } else {
                $valeur = $lmesureIsolement->getValeur();
            }

            if (is_int($lmesureIsolement->getTempCorrection()))
            {
                $temp = $lmesureIsolement->getTempCorrection(); // Récupère la température de correction
            } else {
                $temp = $lmesureIsolement->getTempCorrection();
            }

            $lmesureIsolement->setValeur($valeur); // Définit la valeur de l'isolement
            $lmesureIsolement->setTempCorrection($temp); // Définit la température de correction
            $lMesureIsolementRepository->save($lmesureIsolement, true); // Sauvegarde la mesure d'isolement
            return $this->redirectToRoute('app_mesure_isolement', ['id' => $lmesureIsolement->getMesureIsolement()->getParametre()->getId()]); // Redirige vers la vue de la mesure d'isolement
        }

        // Rendu du formulaire d'édition de LMesureIsolement
        return $this->render('modifier_item/mesure_isolement.html.twig', [
            'form' => $form->createView(),
            'LmesureIsolement' => $lmesureIsolement,
            'mesureIsolement' => $lmesureIsolement->getMesureIsolement(),
            'parametre' => $lmesureIsolement->getMesureIsolement()->getParametre(),
        ]);
    }

    // Modification de mesure d'isolement après lavage
    #[Route('/modifier-isolement-apres-lavage/{id}', name: 'app_edit_mesure_isolement_apres_lavage', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure d'isolement après lavage
    public function mesureIsolementApresLavage(LStatorApresLavage $lstatorApresLavage, Request $request, LStatorApresLavageRepository $lstatorApresLavageRepository): Response
    {
        $form = $this->createForm(LStatorApresLavageEditType::class, $lstatorApresLavage); // Crée le formulaire pour LStatorApresLavage
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            if (is_int($lstatorApresLavage->getValeur()))
            {
                $valeur = $lstatorApresLavage->getValeur(); // Récupère la valeur de l'isolement après lavage
            } else {
                $valeur = $lstatorApresLavage->getValeur();
            }

            if (is_int($lstatorApresLavage->getTempCorrection()))
            {
                $temp = $lstatorApresLavage->getTempCorrection(); // Récupère la température de correction après lavage
            } else {
                $temp = number_format($lstatorApresLavage->getTempCorrection(), 0, '.', '');
            }

            $lstatorApresLavage->setValeur($valeur); // Définit la valeur de l'isolement après lavage
            $lstatorApresLavage->setTempCorrection($temp); // Définit la température de correction après lavage
            $lstatorApresLavageRepository->save($lstatorApresLavage, true); // Sauvegarde la mesure d'isolement après lavage
            return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $lstatorApresLavage->getStatorApresLavage()->getParametre()->getId()]); // Redirige vers la vue de la mesure d'isolement après lavage
        }

        // Rendu du formulaire d'édition de LStatorApresLavage
        return $this->render('modifier_item/mesure_isolement_apres_lavage.html.twig', [
            'form' => $form->createView(),
            'lstatorApresLavage' => $lstatorApresLavage,
            'statorApresLavage' => $lstatorApresLavage->getStatorApresLavage(),
            'parametre' => $lstatorApresLavage->getStatorApresLavage()->getParametre(),
        ]);
    }

    // Modification de mesure de résistance avant lavage
    #[Route('/modifier-resistance/{id}', name: 'app_edit_mesure_resistance', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure de résistance avant lavage
    public function mesureResistance(LMesureResistance $lmesureResistance, Request $request, LMesureResistanceRepository $lMesureResistanceRepository): Response
    {
        $form = $this->createForm(LMesureResistanceEditType::class, $lmesureResistance); // Crée le formulaire pour LMesureResistance
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            $lMesureResistanceRepository->save($lmesureResistance, true); // Sauvegarde la mesure de résistance
            return $this->redirectToRoute('app_mesure_resistance', ['id' => $lmesureResistance->getMesureResistance()->getParametre()->getId()]); // Redirige vers la vue de la mesure de résistance
        }

        // Rendu du formulaire d'édition de LMesureResistance
        return $this->render('modifier_item/mesure_resistance.html.twig', [
            'form' => $form->createView(),
            'lmesureResistance' => $lmesureResistance,
            'mesureResistance' => $lmesureResistance->getMesureResistance(),
            'parametre' => $lmesureResistance->getMesureResistance()->getParametre(),
        ]);
    }

    // Modification de résistance après lavage
    #[Route('/modifier-resistance-apres-lavage/{id}', name: 'app_edit_mesure_resistance_apres_lavage', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure de résistance après lavage
    public function mesureResistanceApresLavage(LSondeBobinage $lSondeBobinage, Request $request, LSondeBobinageRepository $lSondeBobinageRepository): Response
    {
        $form = $this->createForm(LSondeBobinageEditType::class, $lSondeBobinage); // Crée le formulaire pour LSondeBobinage
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            $lSondeBobinageRepository->save($lSondeBobinage, true); // Sauvegarde la mesure de résistance après lavage
            return $this->redirectToRoute('app_sonde_bobinage', ['id' => $lSondeBobinage->getSondeBobinage()->getParametre()->getId()]); // Redirige vers la vue de la mesure de résistance après lavage
        }

        // Rendu du formulaire d'édition de LSondeBobinage
        return $this->render('modifier_item/sonde.html.twig', [
            'form' => $form->createView(),
            'lSondeBobinage' => $lSondeBobinage,
            'sondeBobinage' => $lSondeBobinage->getSondeBobinage(),
            'parametre' => $lSondeBobinage->getSondeBobinage()->getParametre(),
        ]);
    }

    // Modification de mesure d'isolement essai finaux
    #[Route('/modifier-isolement-essais-finaux/{id}', name: 'app_edit_mesure_isolement_essais_finaux', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure d'isolement essai finaux
    public function mesureIsolementEssais(LMesureIsolementEssai $lMesureIsolementEssai, Request $request, LMesureIsolementEssaiRepository $lMesureIsolementEssaiRepository): Response
    {
        $form = $this->createForm(LMesureIsolementEssaiEditType::class, $lMesureIsolementEssai); // Crée le formulaire pour LMesureIsolementEssai
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            if (is_int($lMesureIsolementEssai->getValeur()))
            {
                $valeur = $lMesureIsolementEssai->getValeur(); // Récupère la valeur de l'isolement essai finaux
            } else {
                $valeur = $lMesureIsolementEssai->getValeur();
            }

            if (is_int($lMesureIsolementEssai->getTempCorrection()))
            {
                $temp = $lMesureIsolementEssai->getTempCorrection(); // Récupère la température de correction essai finaux
            } else {
                $temp = number_format($lMesureIsolementEssai->getTempCorrection(), 0, '.', '');
            }

            $lMesureIsolementEssai->setValeur($valeur); // Définit la valeur de l'isolement essai finaux
            $lMesureIsolementEssai->setTempCorrection($temp); // Définit la température de correction essai finaux
            $lMesureIsolementEssaiRepository->save($lMesureIsolementEssai, true); // Sauvegarde la mesure d'isolement essai finaux

            return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $lMesureIsolementEssai->getMesureIsolementEssai()->getParametre()->getId()]); // Redirige vers la vue de la mesure d'isolement essai finaux
        }

        // Rendu du formulaire d'édition de LMesureIsolementEssai
        return $this->render('modifier_item/mesure_isolement_essai_finaux.html.twig', [
            'form' => $form->createView(),
            'lMesureIsolementEssai' => $lMesureIsolementEssai,
            'mesureIsolementEssai' => $lMesureIsolementEssai->getMesureIsolementEssai(),
            'parametre' => $lMesureIsolementEssai->getMesureIsolementEssai()->getParametre(),
        ]);
    }

    // Modification de mesure de résistance essai finaux
    #[Route('/modifier-resistance-essas-finaux/{id}', name: 'app_edit_mesure_resistance_essais_finaux', methods: ['POST', 'GET'])] // Définit la route pour éditer une mesure de résistance essai finaux
    public function mesureResistanceEssai(LMesureResistanceEssai $lMesureResistanceEssai, Request $request, LMesureResistanceEssaiRepository $lMesureIsolementEssaiRepository): Response
    {
        $form = $this->createForm(LMesureResistanceEssaiEditType::class, $lMesureResistanceEssai); // Crée le formulaire pour LMesureResistanceEssai
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            $lMesureIsolementEssaiRepository->save($lMesureResistanceEssai, true); // Sauvegarde la mesure de résistance essai finaux
            return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $lMesureResistanceEssai->getMesureReistanceEssai()->getParametre()->getId()]); // Redirige vers la vue de la mesure de résistance essai finaux
        }

        // Rendu du formulaire d'édition de LMesureResistanceEssai
        return $this->render('modifier_item/mesure_resistance_essai_finaux.html.twig', [
            'form' => $form->createView(),
            'lMesureResistanceEssai' => $lMesureResistanceEssai,
            'mesureResistanceEssai' => $lMesureResistanceEssai->getMesureReistanceEssai(),
            'parametre' => $lMesureResistanceEssai->getMesureReistanceEssai()->getParametre(),
        ]);
    }
}
