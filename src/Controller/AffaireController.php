<?php

/**
 * ----------------------------------------------------------------
 * Projet : Base Expertise
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 18-05-2023
 * Dérniere date de modification : 08-08-2023
 * ----------------------------------------------------------------
 * ********************** Déscription *****************************
 * ## À savoir que l'accès à la page affaire est obligatoire
 * Base de données : 
 *      + nom table : affaire
 * 
 * template :
 *      chaque fonction pointe sur une page vue du projet dans le dossier 
 * 
 * Dans ce controleur vous avez 9 fonctions qui assure le bon fonctionnement du module affaire.
 *      1- la fonction "index", qui permet d'afficher la liste des affaires encours.
 *      2- la fonction "listes",qui affiche la liste de toutes les affaires
 *      3- la fonction "new", pour ajouter une nouvelle affaire dans la base de données
 *      4- la fonction "show", affiche les informations d'une seule affaire en fonction de son ID
 *      5- la fonction "edit", permet de modifier une affaire
 *      6- la fonction "delete", permet de supprimer une affaire
 *      7- la fonction "rapports", qui nous affiche la liste des affaires terminer
 *      8- la fonction  "bloque", qui permet d'activer et déactiver une affaire c'est à dire de verrouiller
 *      9- la fonction "corbeille", qui permet de mettre une affaire dans la corbeille
 */

namespace App\Controller;

use DateTime;
use App\Entity\Affaire;
use App\Entity\Archive;
use App\Entity\Parametre;
use App\Form\AffaireType;
use App\Form\ArchiveType;
use App\Repository\AdminRepository;
use App\Repository\AffaireRepository;
use App\Repository\ArchiveRepository;
use App\Repository\EtudesAchatsRepository;
use App\Repository\ParametreRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/affaire')]
class AffaireController extends AbstractController
{
    //la fonction qui affiche la liste des affaires en cours
    #[Route('/en_cours', name: 'app_affaire_index', methods: ['GET'])]
    public function index(AffaireRepository $affaireRepository): Response
    {
        $affaires = [];
        $tabs = $affaireRepository->findBy([], ['id' => 'desc']);

        //cette boucle permet de retourner un tableau des affaires en cours
        foreach ($tabs as $item) {
            if ($item->isEtat() == 0) {
                array_push($affaires, $item);
            }
        }
        // dd($affaires);
        return $this->render('affaire/en_cours.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    //la fonction qui affiche la liste de toutes les affaires
    #[Route('/listes', name: 'app_affaire_liste', methods: ['GET'])]
    public function listes(AffaireRepository $affaireRepository): Response
    {
        $affaires = $affaireRepository->findBy([], ['id' => 'desc']);
        return $this->render('affaire/index.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    //ajouter une nouvelle affaire
    #[Route('/new', name: 'app_affaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository, MailerService $mailerService, AdminRepository $adminRepository): Response
    {
        //inialiser une variable de classe
        $affaire = new Affaire();

        //créer une variable form, qui contient la classe de du formulaire des affaires
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);
        $date = date("Y-m-d");
        // dd($date);
        //récupérer l'utilisateur connecter 
        $user = $this->getUser()->getNom() . ' ' . $this->getUser()->getPrenom();

        //on vérifie l'envoi du l'ormulaire avant d'ajouté les informations dans la base
        if ($form->isSubmitted() && $form->isValid()) {
            if ($affaire->getDateLivraison()->format('Y-m-d') > $date) {
                //ajouter l'utilisateur sur une affaire
                $affaire->setUser($user);
                $affaire->setEtat(0);

                //enregistrer les informations dans la base de données
                $affaireRepository->save($affaire, true);

                //envoyer un mail aux agent de maitrise aprés la création d'une nouvelle affaire
                $dossier = 'email/email.html.twig';
                $subject = "Création d'une affaire";
                /*  $cdp = $affaire->getSuiviPar()->getNom()." "
                            .$affaire->getSuiviPar()->getPrenom();
                */
                $message = "Une nouvelle affaire a été créée";
                $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
                $num_affaire = "N° d'affaire : " . $affaire->getNumAffaire();


                //envoyer au ageent de maitrise
                $admins = $adminRepository->findAll();
                foreach ($admins as $admin) {
                    foreach ($admin->getRoles() as $role) {
                        if ($role == 'ROLE_AGENT_MAITRISE') {
                            $email = $admin->getEmail();
                            $cdp = $admin->getNom() . ' ' . $admin->getPrenom();
                            //envoyer le mail
                            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);
                        };
                    }
                }
                //redirectionner  après l'ajout
                return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash('error', "Désolé ! La date de livraison est inférieur à la date du jour");
                return $this->redirectToRoute('app_affaire_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('affaire/new.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    //la fonction pour retourner une seule affaire
    #[Route('/show-affaire/{id}', name: 'app_affaire_show', methods: ['GET', 'POST'])]
    public function show(Affaire $affaire, ParametreRepository $parametreRepository, ArchiveRepository $archiveRepository, Request $request, SluggerInterface $slugger): Response
    {
        // Envoyer une variable active pour désactiver et activer le paramètre
        $listes = $parametreRepository->findAll();
        $active = false;
        $fermer = false;
        // Boucle sur tous les paramètres
        foreach ($listes as $item) {
            // Vérifie si l'affaire du paramètre correspond à l'affaire en cours
            if ($item->getAffaire()->getId() == $affaire->getId()) {
                $active = true;
                // Vérifie les conditions de remontage et d'expertises
                if ($item->isRemontage() == true &&
                    $item->isExpertiseElectiqueApresLavage() == true &&
                    $item->isExpertiseElectiqueAvantLavage() == true &&
                    $item->isExpertiseMecanique() == true) {
                    $fermer = true;
                }
            }
        }

        // Traitement des archives
        $archive = new Archive();
        // Création du formulaire pour l'entité Archive
        $form = $this->createForm(ArchiveType::class, $archive);
        // Traitement de la requête par le formulaire
        $form->handleRequest($request);

        // Vérifie s'il existe des versions existantes de cette affaire pour connaître le nombre total
        $num = 0;
        if ($affaire->getArchives()) {
            $num = count($affaire->getArchives()) + 1;
        }

        // Détermination de la lettre correspondant au nombre total
        $lettre = '';
        if ($num == 1) {
            $lettre = 'A';
        } elseif ($num == 2) {
            $lettre = 'B';
        } elseif ($num == 3) {
            $lettre = 'C';
        } elseif ($num == 4) {
            $lettre = 'D';
        } elseif ($num == 5) {
            $lettre = 'E';
        } elseif ($num == 6) {
            $lettre = 'F';
        }
        $version = 'Indice-' . $lettre;

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du fichier uploadé
            $fichier = $form->get('fichier')->getData();
            if ($fichier) {
                // Traitement du nom du fichier
                $originaleFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFichier = $slugger->slug($originaleFichier);
                $newFichierName = $safeFichier . '-' . uniqid() . '.' . $fichier->guessExtension();
                try {
                    // Déplacement du fichier uploadé vers le répertoire défini
                    $fichier->move(
                        $this->getParameter('fichier_archives'),
                        $newFichierName
                    );
                } catch (FileException $e) {
                    // Gestion des exceptions lors du déplacement du fichier
                }
            }
            // Association de l'affaire à l'archive
            $archive->setAffaire($affaire);
            // Association du nom du fichier à l'archive
            $archive->setFichier($newFichierName);
            // Sauvegarde de l'archive dans le dépôt
            $archiveRepository->save($archive, true);
            // Ajout d'un message flash de succès
            $this->addFlash('success', 'Vous avez créé une archive sur cette affaire');
            // Redirection vers la route de l'affaire
            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        //fin d'archiver
        return $this->render('affaire/show.html.twig', [
            'affaire' => $affaire,
            'active' => $active,
            'form' => $form->createView(),
            'archive' => $archive,
            'version' => $version,
            'fermer' => $fermer
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        // Création du formulaire pour l'entité Affaire
        $form = $this->createForm(AffaireType::class, $affaire);
        // Traitement de la requête par le formulaire
        $form->handleRequest($request);

        // Récupération du nom complet de l'utilisateur connecté
        $user = $this->getUser()->getNom() . ' ' . $this->getUser()->getPrenom();

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Association de l'utilisateur à l'affaire
            $affaire->setUser($user);
            // Sauvegarde de l'affaire dans le dépôt
            $affaireRepository->save($affaire, true);
            // Redirection vers la route de l'affaire
            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/edit.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_affaire_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Affaire $affaire, AffaireRepository $affaireRepository, ParametreRepository $parametreRepository, EntityManagerInterface $em, EtudesAchatsRepository $etudesAchatsRepository): Response
    {
        // Recherche des paramètres liés à l'affaire
        $parametre = $parametreRepository->findByAffaire($affaire);

        // Vérification si l'affaire existe
        if ($affaire) {
            // Si aucun paramètre n'est associé à l'affaire
            if (!$parametre) {
                // Vérification si l'affaire a des revues d'enclenchements
                if ($affaire->getRevueEnclenchements()) {
                    // Boucle sur chaque revue d'enclenchement de l'affaire
                    foreach ($affaire->getRevueEnclenchements() as $revue) {
                        // Récupération des achats et ateliers associés à la revue
                        $achats = $revue->getEtudesAchats();
                        $ateliers = $revue->getAteliers();

                        // Suppression des achats associés à la revue
                        if ($achats) {
                            foreach ($achats as $item) {
                                $em->remove($item);
                            }
                        }

                        // Suppression des ateliers associés à la revue
                        if ($ateliers) {
                            foreach ($ateliers as $item) {
                                $em->remove($item);
                            }
                        }
                        // Suppression de la revue
                        $em->remove($revue);
                    }
                }

                // Suppression de l'affaire
                $affaireRepository->remove($affaire, true);
                // Redirection vers la liste des affaires
                return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Ajout d'un message flash d'erreur
                $this->addFlash('danger', "Désolé, vous ne pouvez pas supprimer cette affaire car elle possède des paramètres !");
                // Redirection vers la page de l'affaire
                return $this->redirectToRoute('app_affaire_show', [
                    'id' => $affaire->getId()
                ], Response::HTTP_SEE_OTHER);
            }
        }

        // Redirection vers la liste des affaires si l'affaire n'existe pas
        return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
    }
    
    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/bloque-activer/{id}', name: 'app_bloque', methods: ['GET'])]
    public function bloque(Affaire $affaire, EntityManagerInterface $em): Response
    {
        //on vérifi si l'affaire existe
        if ($affaire) {
            /**
             * si l'attribut bloque est true
             * il lui passe en false
             * si non il lui passe en true
             */
            if ($affaire->isBloque() == 1) {
                $affaire->setBloque(0);
                $em->persist($affaire);
            } else {
                $affaire->setBloque(1);
                $em->persist($affaire);
            }

            $em->flush();
            return $this->redirectToRoute('app_affaire_show', ['id' => $affaire->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_affaire_show', ['id' => $affaire->getId()], Response::HTTP_SEE_OTHER);
    }

    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/corbeille/{id}', name: 'app_corbeille', methods: ['GET'])]
    public function corbeille(Parametre $parametre, EntityManagerInterface $em): Response
    {
        // Vérification si le paramètre existe
        if ($parametre) {
            // Vérification de l'état de la corbeille du paramètre
            if ($parametre->isCorbeille() == 1) {
                // Si le paramètre est dans la corbeille, on le retire de la corbeille
                $parametre->setCorbeille(0);
            } else {
                // Sinon, on le place dans la corbeille
                $parametre->setCorbeille(1);
            }
            // Persistance du changement d'état du paramètre
            $em->persist($parametre);
            // Sauvegarde des changements dans la base de données
            $em->flush();
            // Redirection vers la page de l'affaire associée au paramètre
            return $this->redirectToRoute('app_affaire_show', ['id' => $parametre->getAffaire()->getId()], Response::HTTP_SEE_OTHER);
        }
        // Si le paramètre n'existe pas, redirection vers la page de l'affaire
        return $this->redirectToRoute('app_affaire_show', ['id' => $parametre->getAffaire()->getId()], Response::HTTP_SEE_OTHER);
    }
}
