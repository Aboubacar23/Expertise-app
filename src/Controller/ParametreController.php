<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Repository\SettingsRepository; // Importe le repository SettingsRepository
use App\Entity\Affaire; // Importe l'entité Affaire
use App\Entity\Machine; // Importe l'entité Machine
use App\Entity\Parametre; // Importe l'entité Parametre
use App\Entity\Type; // Importe l'entité Type
use App\Form\ParametreType; // Importe le formulaire ParametreType
use App\Repository\PhotoRepository; // Importe le repository PhotoRepository
use App\Repository\ParametreRepository; // Importe le repository ParametreRepository
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour la gestion des entités
use App\Repository\AppareilMesureRepository; // Importe le repository AppareilMesureRepository
use Symfony\Component\HttpFoundation\Request; // Importe la classe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe la classe Response pour gérer les réponses HTTP
use Symfony\Component\Routing\Annotation\Route; // Importe la classe Route pour définir les routes
use App\Repository\ReleveDimmensionnelRepository; // Importe le repository ReleveDimmensionnelRepository
use Symfony\Component\HttpFoundation\JsonResponse; // Importe la classe JsonResponse pour les réponses JSON
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController pour les fonctionnalités de contrôleur

#[Route('/parametre')] // Définit la route de base pour ce contrôleur
class ParametreController extends AbstractController
{
    // Constructeur pour initialiser le repository SettingsRepository
    public function __construct(private  SettingsRepository $settingsRepository)
    {
    }

    #[Route('/', name: 'app_parametre_index', methods: ['GET'])] // Définit la route pour afficher tous les paramètres
    public function index(ParametreRepository $parametreRepository): Response
    {
        // Rendu de la vue index avec les paramètres
        return $this->render('parametre/index.html.twig', [
            'parametres' => $parametreRepository->findAll(), // Récupère tous les paramètres
        ]);
    }

    #[Route('/new/{id}', name: 'app_parametre_new', methods: ['GET', 'POST'])] // Définit la route pour créer un nouveau paramètre
    public function new(Request $request, Affaire $affaire, ParametreRepository $parametreRepository): Response
    {
        $parametre = new Parametre(); // Crée une nouvelle instance de Parametre
        $form = $this->createForm(ParametreType::class, $parametre); // Crée le formulaire pour Parametre
        $form->handleRequest($request); // Traite la requête

        // Initialiser les valeurs des critères et température de correction via settings
        $setting = $this->settingsRepository->findOneBy([]); // Récupère les paramètres de réglage
        $critere = $setting->getCritere(); // Récupère le critère
        $correction = $setting->getTemperature(); // Récupère la température de correction
        $numero_qualite = $setting->getNumeroQualite(); // Récupère le numéro de qualité

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier et initialiser les valeurs des tensions si elles sont nulles
            $parametre->setStatorTension2($parametre->getStatorTension2() ?? 0);
            $parametre->setStatorTension($parametre->getStatorTension() ?? 0);
            $parametre->setRotorTension2($parametre->getRotorTension2() ?? 0);
            $parametre->setRotorTension($parametre->getRotorTension() ?? 0);

            // Définir le numéro de qualité et l'affaire
            $parametre->setNumeroQualite($numero_qualite);
            $parametre->setAffaire($affaire);

            // Sauvegarder les modifications dans le repository
            $parametreRepository->save($parametre, true);
            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER); // Redirige vers la vue de l'affaire
        }

        // Rendu du formulaire de création de Parametre
        return $this->renderForm('parametre/new.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
            'affaire' => $affaire,
            'critere' => $critere,
            'correction' => $correction,
        ]);
    }

    #[Route('/{id}', name: 'app_parametre_show', methods: ['GET'])] // Définit la route pour afficher un paramètre
    public function show(Parametre $parametre): Response
    {
        // Rendu de la vue show avec le paramètre
        return $this->render('parametre/show.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametre_edit', methods: ['GET', 'POST'])] // Définit la route pour éditer un paramètre
    public function edit(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        $form = $this->createForm(ParametreType::class, $parametre); // Crée le formulaire pour Parametre
        $form->handleRequest($request); // Traite la requête

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier et initialiser les valeurs des tensions si elles sont nulles
            if ($parametre->getStatorTension2() == null) {
                $parametre->setStatorTension2(0);
            }
            if ($parametre->getStatorTension() == null) {
                $parametre->setStatorTension(0);
            }

            if ($parametre->getRotorTension2() == null) {
                $parametre->setRotorTension2(0);
            }

            if ($parametre->getRotorTension() == null) {
                $parametre->setRotorTension(0);
            }

            // Sauvegarde les modifications
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $parametre->getAffaire()->getId()
            ], Response::HTTP_SEE_OTHER); // Redirige vers la vue de l'affaire
        }

        // Rendu du formulaire d'édition de Parametre
        return $this->renderForm('parametre/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    #[Route('delete-parametre/{id}', name: 'app_parametre_delete', methods: ['GET'])] // Définit la route pour supprimer un paramètre
    public function delete(
        Request $request,
        Parametre $parametre,
        EntityManagerInterface $em,
        ParametreRepository $parametreRepository,
        AppareilMesureRepository $appareilMesureRepository,
        ReleveDimmensionnelRepository $releveDimmensionnelRepository,
        PhotoRepository $photoRepository,
    ): Response {
        if ($parametre) {
            $id = $parametre->getAffaire()->getId(); // Récupère l'id de l'affaire

            // Appareil de mesure mécanique
            foreach ($parametre->getAppareilMesureMecaniques() as $item) {
                $em->remove($item, true);
            }

            // Photos d'expertise mécanique
            foreach ($parametre->getPhotoExpertiseMecaniques() as $item) {
                $em->remove($item, true);
            }

            // Constat électrique après lavage
            foreach ($parametre->getConstatElectriqueApresLavages() as $item) {
                $em->remove($item, true);
            }
            // Constat mécanique
            foreach ($parametre->getConstatMecaniques() as $item) {
                $em->remove($item, true);
            }

            // Constat électrique avant lavage
            foreach ($parametre->getConstatElectriques() as $item) {
                $em->remove($item, true);
            }
            // Caractéristique
            foreach ($parametre->getCaracteristiques() as $item) {
                $em->remove($item, true);
            }

            // Point de fonctionnement
            foreach ($parametre->getPointFonctionnements() as $item) {
                $em->remove($item);
            }

            // Point de fonctionnement à vide
            foreach ($parametre->getPointFonctionnementVides() as $item) {
                $em->remove($item);
            }

            // Point de fonctionnement rotor
            foreach ($parametre->getPointFonctionnementRotors() as $item) {
                $em->remove($item);
            }

            // Remontage photo
            foreach ($parametre->getRemontagePhotos() as $item) {
                $em->remove($item);
            }

            // Plaque
            foreach ($parametre->getPlaques() as $item) {
                $em->remove($item);
            }
            // Contrôle de recensement
            foreach ($parametre->getControleRecensements() as $item) {
                $em->remove($item);
            }

            // Photo
            if ($parametre->getPhoto()) {
                if ($parametre->getPhoto()->getImages()) {
                    foreach ($parametre->getPhoto()->getImages() as $item) {
                        $em->remove($item);
                    }
                }

                foreach ($photoRepository->findAll() as $ph) {
                    if ($ph->getParametre()->getId() == $parametre->getId()) {
                        $em->remove($ph);
                    }
                }
            }

            // Mesure isolement
            if ($parametre->getMesureIsolement()) {
                if ($parametre->getMesureIsolement()->getLMesureIsolements()) {
                    foreach ($parametre->getMesureIsolement()->getLMesureIsolements() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureIsolement());
            }

            // Mesure essais
            if ($parametre->getMesureIsolementEssai()) {
                if ($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais()) {
                    foreach ($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureIsolementEssai());
            }

            // Mesure essais
            if ($parametre->getMesureResistanceEssai()) {
                if ($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais()) {
                    foreach ($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureResistanceEssai());
            }

            // Mesure résistance
            if ($parametre->getMesureResistance()) {
                if ($parametre->getMesureResistance()->getLMesureResistances()) {
                    foreach ($parametre->getMesureResistance()->getLMesureResistances() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureResistance());
            }

            // Sonde et bobinage
            if ($parametre->getSondeBobinage()) {
                if ($parametre->getSondeBobinage()->getLSondeBobinages()) {
                    foreach ($parametre->getSondeBobinage()->getLSondeBobinages() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getSondeBobinage());
            }

            // Stator après lavage
            if ($parametre->getStatorApresLavage()) {
                if ($parametre->getStatorApresLavage()->getLStatorApresLavages()) {
                    foreach ($parametre->getStatorApresLavage()->getLStatorApresLavages() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getStatorApresLavage());
            }

            // Contrôle visuel
            if ($parametre->getControleVisuelMecanique()) {
                if ($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires()) {
                    foreach ($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getControleVisuelMecanique());
            }

            foreach ($releveDimmensionnelRepository->findAll() as $item) {
                if ($item->getParametre()->getId() == $parametre->getId()) {
                    $em->remove($item);
                }
                $em->remove($item);
            }

            foreach ($parametre->getAppareilMesureElectriques() as $item) {
                $em->remove($item);
            }

            if ($parametre->getAppareilMesures()) {
                foreach ($appareilMesureRepository->findAll() as $item) {
                    if ($item->getParametre()->getId() ==  $parametre->getId()) {
                        $em->remove($item);
                    }
                }
            }

            $em->remove($parametre); // Supprime le paramètre
            $em->flush(); // Applique les changements à la base de données
        }

        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER); // Redirige vers la vue de l'affaire
    }

    #[Route('/reunion-validation/{id}', name: 'app_parametre_valided', methods: ['GET'])] // Définit la route pour valider un paramètre en réunion
    public function reunion(Request $request, Parametre $parametre, ParametreRepository $parametreRepository, EntityManagerInterface $em): Response
    {
        $id = $parametre->getAffaire()->getId(); // Récupère l'id de l'affaire
        if ($parametre) {
            $parametre->setEtat(1); // Met à jour l'état du paramètre
            $em->persist($parametre); // Persiste le paramètre
            $em->flush(); // Applique les changements à la base de données
        }
        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER); // Redirige vers la vue de l'affaire
    }

    #[Route('/info/{id}', name: 'get_info', methods: ['GET'])] // Définit la route pour obtenir les informations d'un type de machine
    public function test(Type $machine): JsonResponse
    {
        if (!$machine) {
            return new JsonResponse(['erreur' => 'type machine non trouvée'], 404); // Retourne une erreur si la machine n'est pas trouvée
        }
        return new JsonResponse([
            'machine' => $machine->getMachine()->getId(),
            'type_machine' => $machine->getTypeMachine(),
            'puissance' => $machine->getPuissance(),
            'montage' => $machine->getMontage(),
            'fabricant' => $machine->getFabricant(),
            'vitesse' => $machine->getVitesse(),
            'masse' => $machine->getMasse(),
            'type_palier' => $machine->getTypepalier(),
            'presence_balais' => $machine->isPresenceBalais(),
            'presence_masse_balais' => $machine->isPresenceBalaisMasse(),
            'stator_tension' => $machine->getStatorTension(),
            'stator_tension2' => $machine->getStatorTension2(),
            'stator_frequence' => $machine->getStatorFrequence(),
            'stator_courant' => $machine->getStatorCourant(),
            'stator_couplage' => $machine->getStatorCouplage(),
            'date_arrivee' => $machine->getDateArrivee(),
            'rotor_tension' => $machine->getRotorTension(),
            'rotor_tension2' => $machine->getRotorTension2(),
            'rotor_expertise_refrigeant' => $machine->getRotorExpertiseRefrigeant(),
            'rotor_courant' => $machine->getRotorCourant(),
            'presence_plans' => $machine->isPresencePlans(),
        ]); // Retourne les informations de la machine sous forme de JSON
    }

    #[Route('/frequence/{id}', name: 'app_frequence', methods: ['GET'])] // Définit la route pour obtenir la fréquence d'une machine
    public function frequence(Machine $machine): JsonResponse
    {
        if (!$machine) {
            return new JsonResponse(['erreur' => 'Machine non trouvée'], 404); // Retourne une erreur si la machine n'est pas trouvée
        }
        return new JsonResponse([
            'name' => $machine->getCategorie(), // Retourne la catégorie de la machine
        ]);
    }
}
