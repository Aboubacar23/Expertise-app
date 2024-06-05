<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\Parametre; // Importe l'entité Parametre
use App\Entity\RemontagePhoto; // Importe l'entité RemontagePhoto
use App\Service\MailerService; // Importe le service MailerService
use App\Entity\RemontagePalier; // Importe l'entité RemontagePalier
use App\Form\RemontagePhotoType; // Importe le formulaire RemontagePhotoType
use App\Entity\RemontageFinition; // Importe l'entité RemontageFinition
use App\Form\RemontagePalierType; // Importe le formulaire RemontagePalierType
use App\Form\RemontageFinitionType; // Importe le formulaire RemontageFinitionType
use App\Repository\AdminRepository; // Importe le repository AdminRepository
use App\Entity\RemontageEquilibrage; // Importe l'entité RemontageEquilibrage
use App\Service\RedimensionneService; // Importe le service RedimensionneService
use App\Form\RemontageEquilibrageType; // Importe le formulaire RemontageEquilibrageType
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour les opérations de base de données
use App\Repository\RemontagePhotoRepository; // Importe le repository RemontagePhotoRepository
use App\Repository\RemontagePalierRepository; // Importe le repository RemontagePalierRepository
use Symfony\Component\HttpFoundation\Request; // Importe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe Response pour gérer les réponses HTTP
use App\Repository\RemontageFinitionRepository; // Importe le repository RemontageFinitionRepository
use Symfony\Component\Routing\Annotation\Route; // Importe Route pour la définition des routes
use App\Repository\RemontageEquilibrageRepository; // Importe le repository RemontageEquilibrageRepository
use Symfony\Component\String\Slugger\SluggerInterface; // Importe SluggerInterface pour créer des slugs
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController comme classe de base
use Symfony\Component\HttpFoundation\File\Exception\FileException; // Importe FileException pour gérer les exceptions de fichiers

// Déclare une route principale pour ce contrôleur
#[Route('/remontage')]
class RemontageController extends AbstractController
{
    // Constructeur pour injecter le service de redimensionnement d'image
    public function __construct(private RedimensionneService $redimensionneService)
    {
    }

    // Route pour afficher la page d'index du remontage
    #[Route('/index/{id}', name: 'app_remontage_index')]
    public function index(Parametre $parametre): Response
    {
        // Renvoie la vue 'index.html.twig' avec le paramètre
        return $this->render('remontage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    // Route pour gérer le remontage de palier
    #[Route('/remontage-palier/{id}', name: 'app_remontage_palier', methods: ['GET', 'POST'])]
    public function remontagePalier(Parametre $parametre, Request $request, RemontagePalierRepository $remontagePalierRepository): Response
    {
        $remontagePalier = new RemontagePalier(); // Crée une nouvelle instance de RemontagePalier
        if ($parametre->getRemontagePalier()) {
            $remontagePalier = $parametre->getRemontagePalier()->getParametre()->getRemontagePalier();
        }

        $formRemontagePalier = $this->createForm(RemontagePalierType::class, $remontagePalier); // Crée le formulaire
        $formRemontagePalier->handleRequest($request); // Gère la requête

        if ($formRemontagePalier->isSubmitted() && $formRemontagePalier->isValid()) {
            $choix = $request->get('bouton1'); // Récupère le choix de l'utilisateur
            if ($choix == 'remontage_palier_en_cours') {
                $parametre->setRemontagePalier($remontagePalier);
                $remontagePalier->setEtat(0); // Définit l'état à "en cours"
                $remontagePalierRepository->save($remontagePalier, true); // Sauvegarde dans la base de données
                $this->redirectToRoute('app_remontage_palier', ['id' => $parametre->getId()]);
            } elseif ($choix == 'remontage_palier_terminer') {
                $parametre->setRemontagePalier($remontagePalier);
                $remontagePalier->setEtat(1); // Définit l'état à "terminé"
                $remontagePalierRepository->save($remontagePalier, true);
                $this->redirectToRoute('app_remontage_palier', ['id' => $parametre->getId()]);
            }
        }

        // Renvoie la vue 'remontage.html.twig' avec les paramètres nécessaires
        return $this->render('remontage/remontage.html.twig', [
            'parametre' => $parametre,
            'remontagePalier' => $remontagePalier,
            'formRemontagePalier' => $formRemontagePalier->createView(),
        ]);
    }

    // Route pour gérer l'équilibrage
    #[Route('/equilibrage/{id}', name: 'app_equilibrage', methods: ['GET', 'POST'])]
    public function equilibrage(Parametre $parametre, Request $request, RemontageEquilibrageRepository $remontageEquilibrageRepository): Response
    {
        $remontageEquilibrage = new RemontageEquilibrage(); // Crée une nouvelle instance de RemontageEquilibrage
        if ($parametre->getRemontageEquilibrage()) {
            $remontageEquilibrage = $parametre->getRemontageEquilibrage()->getParametre()->getRemontageEquilibrage();
        }

        $formRemontageEquilibrage = $this->createForm(RemontageEquilibrageType::class, $remontageEquilibrage); // Crée le formulaire
        $formRemontageEquilibrage->handleRequest($request); // Gère la requête

        if ($formRemontageEquilibrage->isSubmitted() && $formRemontageEquilibrage->isValid()) {
            $choix = $request->get('bouton2'); // Récupère le choix de l'utilisateur
            if ($choix == 'remontage_equilibrage_en_cours') {
                $parametre->setRemontageEquilibrage($remontageEquilibrage);
                $remontageEquilibrage->setEtat(0); // Définit l'état à "en cours"
                $remontageEquilibrageRepository->save($remontageEquilibrage, true); // Sauvegarde dans la base de données
                $this->redirectToRoute('app_equilibrage', ['id' => $parametre->getId()]);
            } elseif ($choix == 'remontage_equilibrage_terminer') {
                $parametre->setRemontageEquilibrage($remontageEquilibrage);
                $remontageEquilibrage->setEtat(1); // Définit l'état à "terminé"
                $remontageEquilibrageRepository->save($remontageEquilibrage, true);
                $this->redirectToRoute('app_equilibrage', ['id' => $parametre->getId()]);
            }
        }

        // Renvoie la vue 'equilibrage.html.twig' avec les paramètres nécessaires
        return $this->render('remontage/equilibrage.html.twig', [
            'parametre' => $parametre,
            'formRemontageEquilibrage' => $formRemontageEquilibrage->createView(),
        ]);
    }

    // Route pour gérer le remontage de finition
    #[Route('/remontage-finition/{id}', name: 'app_remontage_finition', methods: ['GET', 'POST'])]
    public function remontageFinitions(Parametre $parametre, Request $request, RemontageFinitionRepository $remontageFinitionRepository): Response
    {
        $remontageFinition = new RemontageFinition(); // Crée une nouvelle instance de RemontageFinition
        if ($parametre->getRemontageFinition()) {
            $remontageFinition = $parametre->getRemontageFinition()->getParametre()->getRemontageFinition();
        }

        $formRemontageFinition = $this->createForm(RemontageFinitionType::class, $remontageFinition); // Crée le formulaire
        $formRemontageFinition->handleRequest($request); // Gère la requête

        if ($formRemontageFinition->isSubmitted() && $formRemontageFinition->isValid()) {
            $choix = $request->get('bouton3'); // Récupère le choix de l'utilisateur
            if ($choix == 'remontage_finition_en_cours') {
                $parametre->setRemontageFinition($remontageFinition);
                $remontageFinition->setEtat(0); // Définit l'état à "en cours"
                $remontageFinitionRepository->save($remontageFinition, true); // Sauvegarde dans la base de données
                $this->redirectToRoute('app_remontage_finition', ['id' => $parametre->getId()]);
            } elseif ($choix == 'remontage_finition_terminer') {
                $parametre->setRemontageFinition($remontageFinition);
                $remontageFinition->setEtat(1); // Définit l'état à "terminé"
                $remontageFinitionRepository->save($remontageFinition, true);
                $this->redirectToRoute('app_remontage_finition', ['id' => $parametre->getId()]);
            }
        }

        // Renvoie la vue 'remontage_finitions.html.twig' avec les paramètres nécessaires
        return $this->render('remontage/remontage_finitions.html.twig', [
            'parametre' => $parametre,
            'formRemontageFinition' => $formRemontageFinition->createView()
        ]);
    }

    // Route pour gérer l'ajout de photos de remontage
    #[Route('/photo-remontage/{id}', name: 'app_photo_remontage', methods: ['GET', 'POST'])]
    public function photo(Parametre $parametre, Request $request, SluggerInterface $slugger, RemontagePhotoRepository $remontagePhotoRepository): Response
    {
        $remontagePhoto = new RemontagePhoto(); // Crée une nouvelle instance de RemontagePhoto

        $formRemontagePhoto = $this->createForm(RemontagePhotoType::class, $remontagePhoto); // Crée le formulaire
        $formRemontagePhoto->handleRequest($request); // Gère la requête

        if ($formRemontagePhoto->isSubmitted() && $formRemontagePhoto->isValid()) {
            $choix = $request->get('bouton4'); // Récupère le choix de l'utilisateur
            $image = $formRemontagePhoto->get('image')->getData(); // Récupère l'image
            if ($choix == 'ajouter') {
                if ($image) {
                    // Récupère la taille de l'image à insérer
                    $size = $image->getSize();
                    // Vérifie si l'image est supérieure à 2 Mo
                    if ($size > 2 * 1024 * 1024) {
                        // Affiche un message d'erreur si l'image est trop grande
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_photo_remontage', ['id' => $parametre->getId()]);
                    } else {
                        // Génère un nouveau nom pour l'image
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            // Déplace l'image vers le répertoire de stockage
                            $image->move(
                                $this->getParameter('image_remontages'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                            // Gère les exceptions de fichiers
                        }

                        $directory = $this->getParameter('kernel.project_dir') . '/public/photo_remontages' . '/' . $newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $remontagePhoto->setImage($newPhotoname);
                    }
                }
                $remontagePhoto->setParametre($parametre); // Associe la photo au paramètre
                $remontagePhotoRepository->save($remontagePhoto, true); // Sauvegarde dans la base de données
                $this->redirectToRoute('app_photo_remontage', ['id' => $parametre->getId()]);
            }
        }

        // Renvoie la vue 'photos.html.twig' avec les paramètres nécessaires
        return $this->render('remontage/photos.html.twig', [
            'parametre' => $parametre,
            'formRemontagePhoto' => $formRemontagePhoto->createView(),
        ]);
    }

    // Fonction qui supprime une photo ajoutée
    #[Route('/photo/{id}/remontage', name: 'delete_photo_remontage', methods: ['GET'])]
    public function deletePhoto(RemontagePhoto $remontagePhoto, RemontagePhotoRepository $remontagePhotoRepository): Response
    {
        $id = $remontagePhoto->getParametre()->getId(); // Récupère l'ID du paramètre associé
        if ($remontagePhoto) {
            $nom = $remontagePhoto->getImage(); // Récupère le nom de l'image
            unlink($this->getParameter('image_remontages') . '/' . $nom); // Supprime l'image du répertoire de stockage
            $remontagePhotoRepository->remove($remontagePhoto, true); // Supprime la photo de la base de données
            return $this->redirectToRoute('app_photo_remontage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_photo_remontage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Fonction qui valide le remontage
    #[Route('validation/{id}/rapport', name: 'valider_remontage', methods: ['GET'])]
    public function validation(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        if ($parametre) {
            $dossier = 'email/email.html.twig'; // Chemin du template d'email
            $subject = "Remontage"; // Sujet de l'email

            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom(); // Nom du chef de projet

            $message = "Le remontage de la machine est terminé !"; // Message de l'email
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom(); // Nom de l'utilisateur actuel
            $num_affaire = " N° d'affaire : " . $parametre->getAffaire()->getNumAffaire(); // Numéro de l'affaire

            $admins = $adminRepository->findAll(); // Récupère tous les administrateurs
            foreach ($admins as $admin) {
                foreach ($admin->getRoles() as $role) {
                    if ($role == 'ROLE_AGENT_MAITRISE') {
                        // Envoie l'email à l'agent de maîtrise
                        $email = $admin->getEmail();
                        $cdp = $admin->getNom() . ' ' . $admin->getPrenom();
                        $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);
                    };
                }
            }

            // Envoie l'email au chef de projet
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            $parametre->setRemontage(1); // Définit le statut de remontage à terminé
            $entityManager->persist($parametre); // Persiste le paramètre
            $entityManager->flush(); // Sauvegarde dans la base de données
            $this->addFlash("success", "L'expertise validée avec succès"); // Affiche un message de succès
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }
    }
}
