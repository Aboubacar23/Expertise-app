<?php

namespace App\Controller;

// Importation des différentes entités, services, formulaires et autres nécessaires pour le contrôleur
use App\Entity\Parametre;
use App\Entity\Signature;
use App\Service\MailerService;
use App\Entity\AppareilMesureEssais;
use App\Entity\MesureIsolementEssai;
use App\Entity\LMesureIsolementEssai;
use App\Entity\MesureResistanceEssai;
use App\Entity\LMesureResistanceEssai;
use App\Entity\MesureVibratoireEssais;
use App\Form\AppareilMesureEssaisType;
use App\Form\MesureIsolementEssaiType;
use App\Entity\PointFonctionnementVide;
use App\Form\LMesureIsolementEssaiType;
use App\Form\LMesureReistanceEssaiType;
use App\Form\MesureResistanceEssaiType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Form\MesureVibratoireEssaisType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PointFonctionnementVideType;
use App\Repository\AdminRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AppareilMesureEssaisRepository;
use App\Repository\MesureIsolementEssaiRepository;
use App\Repository\LMesureIsolementEssaiRepository;
use App\Repository\MesureResistanceEssaiRepository;
use App\Repository\LMesureResistanceEssaiRepository;
use App\Repository\MesureVibratoireEssaisRepository;
use App\Repository\PointFonctionnementVideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

// Définition de la route principale pour ce contrôleur
#[Route('/essais-finaux')]
class EssaisFinauxController extends AbstractController
{
    // Définition de la route pour l'index des essais finaux
    #[Route('/index-essais/{id}', name: 'app_essais_finaux', methods: ['GET', 'POST'])]
    public function index(Parametre $parametre): Response
    {
        // Rendu de la vue Twig 'essais_finaux/index.html.twig' avec le paramètre 'parametre'
        return $this->render('essais_finaux/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    // Route pour la création d'une mesure d'isolement
    #[Route('/mesure-isolement/{id}', name: 'app_mesure_isolement_essai', methods: ['POST', 'GET'])]
    public function mesureIso(Parametre $parametre, Request $request, MesureIsolementEssaiRepository $mesureIsolementRepository, EntityManagerInterface $em, ControleIsolementRepository $controleIsolementRepository): Response
    {
        // Initialisation des entités nécessaires
        $mesureIsolement = new MesureIsolementEssai();
        $lmesureIsolement = new LMesureIsolementEssai();
        $val = 0;

        // Si une mesure d'isolement existe déjà, on la récupère
        if ($parametre->getMesureIsolementEssai()) {
            $mesureIsolement = $parametre->getMesureIsolementEssai()->getParametre()->getMesureIsolementEssai();
            $val = 1;
        }

        // Création des formulaires
        $formMesureIsolement = $this->createForm(MesureIsolementEssaiType::class, $mesureIsolement);
        $form = $this->createForm(LMesureIsolementEssaiType::class, $lmesureIsolement);

        // Gestion des requêtes de formulaire
        $formMesureIsolement->handleRequest($request);
        $form->handleRequest($request);

        // Gestion des sessions
        $session = $request->getSession();
        $tablesEssais = $session->get('essais', []);

        // Si les formulaires sont soumis
        if ($formMesureIsolement->isSubmitted() && $form->isSubmitted()) {
            // Récupération du choix de l'utilisateur
            $choix = $request->get('bouton7');

            if ($choix == 'mesure_isolement_en_cours') {
                // Parcours des éléments de la session pour enregistrer les mesures en cours
                $i = 0;
                foreach ($tablesEssais as $item) {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolementEssai();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setTempCorrection($item->getTempCorrection());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolementEssai($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }

                // Mise à jour de l'état et sauvegarde des données
                $parametre->setMesureIsolementEssai($mesureIsolement);
                $mesureIsolement->setEtat(0);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);

            } elseif ($choix == 'mesure_isolement_terminer') {
                // Parcours des éléments de la session pour enregistrer les mesures terminées
                $i = 0;
                foreach ($tablesEssais as $item) {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolementEssai();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setTempCorrection($item->getTempCorrection());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolementEssai($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }

                // Mise à jour de l'état et sauvegarde des données
                $parametre->setMesureIsolementEssai($mesureIsolement);
                $mesureIsolement->setEtat(1);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);

            } elseif ($choix == 'ajouter') {
                // Ajout d'une nouvelle mesure d'isolement
                $lig = sizeof($tablesEssais) + 1;
                $lmesureIsolement->setLig($lig);

                // Vérification des doublons
                foreach ($tablesEssais as $i) {
                    if ($i->getType() == $lmesureIsolement->getType() && $i->getControle() == $lmesureIsolement->getControle() && $i->getTension() == $lmesureIsolement->getTension()) {
                        $this->addFlash("message", "Vous avez déjà ajouté ce contrôle");
                        return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
                    }
                }

                // Vérification des doublons dans les mesures existantes
                if ($parametre->getMesureIsolementEssai()) {
                    foreach ($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais() as $j) {
                        if ($j->getType() == $lmesureIsolement->getType() && $j->getControle() == $lmesureIsolement->getControle() && $j->getTension() == $lmesureIsolement->getTension()) {
                            $this->addFlash("message", "Vous avez déjà ajouté ce contrôle");
                            return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
                        }
                    }
                }

                // Ajout de la nouvelle mesure à la session
                $tablesEssais[$lig] = $lmesureIsolement;
                $session->set('essais', $tablesEssais);
            }
        }

        // Rendu de la vue Twig pour la mesure d'isolement
        return $this->render('essais_finaux/mesure_isolement.html.twig', [
            'parametre' => $parametre,
            'formMesureIsolement' => $formMesureIsolement->createView(),
            'form' => $form->createView(),
            'items' => $tablesEssais,
            'val' => $val,
            'listes_controles' => $controleIsolementRepository->findAll(),
        ]);
    }

    // Route pour la création d'un point de fonctionnement
    #[Route('/point-fonctionnement/{id}', name: 'app_point_fonctionnement_vide', methods: ['POST', 'GET'])]
    public function pointFonctionnement(Parametre $parametre, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // Initialisation de l'entité PointFonctionnementVide
        $pointFonctionnement = new PointFonctionnementVide();

        // Création du formulaire pour le point de fonctionnement
        $formPointFonctionnement = $this->createForm(PointFonctionnementVideType::class, $pointFonctionnement);
        $formPointFonctionnement->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($formPointFonctionnement->isSubmitted() && $formPointFonctionnement->isValid()) {
            $choix = $request->get('bouton9');

            if ($choix == 'ajouter') {
                // Gestion de l'image
                $image = $formPointFonctionnement->get('image')->getData();
                if ($image) {
                    $size = $image->getSize();
                    if ($size > 2 * 1024 * 1024) {
                        // Message d'erreur si la taille de l'image dépasse 2 Mo
                        $this->addFlash("error", "Désolé, la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_point_fonctionnement_vide', ['id' => $parametre->getId()]);
                    } else {
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('point_fonctionnement_vide'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                            // Gestion des exceptions en cas d'erreur de déplacement du fichier
                        }

                        $pointFonctionnement->setImage($newPhotoname);
                    }
                }

                // Mise à jour de l'entité et sauvegarde dans la base de données
                $pointFonctionnement->setParametre($parametre);
                $em->persist($pointFonctionnement);
                $em->flush();
                return $this->redirectToRoute('app_point_fonctionnement_vide', ['id' => $parametre->getId()]);
            }
        }

        // Rendu de la vue Twig pour le point de fonctionnement
        return $this->render('essais_finaux/point_fonctionnement.html.twig', [
            'parametre' => $parametre,
            'formPointFonctionnement' => $formPointFonctionnement->createView(),
        ]);
    }

    // Route pour la création d'une mesure vibratoire
    #[Route('/mesure-vibratoire/{id}', name: 'app_mesure_vibratoire_essais', methods: ['POST', 'GET'])]
    public function mesureVibratoire(Parametre $parametre, Request $request, MesureVibratoireEssaisRepository $mesureVibratoireEssaisRepository): Response
    {
        // Initialisation de l'entité MesureVibratoireEssais
        $mesureVibratoire = new MesureVibratoireEssais();
        if ($parametre->getMesureVibratoireEssais()) {
            $mesureVibratoire = $parametre->getMesureVibratoireEssais()->getParametre()->getMesureVibratoireEssais();
        }

        // Création du formulaire pour la mesure vibratoire
        $formMesureVibratoire = $this->createForm(MesureVibratoireEssaisType::class, $mesureVibratoire);
        $formMesureVibratoire->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($formMesureVibratoire->isSubmitted() && $formMesureVibratoire->isValid()) {
            $choix = $request->get('bouton2');

            if ($choix == 'essai_en_cours') {
                // Mise à jour de l'entité et sauvegarde dans la base de données
                $parametre->setMesureVibratoireEssais($mesureVibratoire);
                $mesureVibratoire->setEtat(0);
                $mesureVibratoireEssaisRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire_essais', ['id' => $parametre->getId()]);
            } elseif ($choix == 'essai_terminer') {
                // Mise à jour de l'entité et sauvegarde dans la base de données
                $parametre->setMesureVibratoireEssais($mesureVibratoire);
                $mesureVibratoire->setEtat(1);
                $mesureVibratoireEssaisRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire_essais', ['id' => $parametre->getId()]);
            }
        }

        // Rendu de la vue Twig pour la mesure vibratoire
        return $this->render('essais_finaux/mesure_vibratoire.html.twig', [
            'parametre' => $parametre,
            'formMesureVibratoire' => $formMesureVibratoire->createView(),
        ]);
    }

    // Route pour la gestion des appareils de mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_essais')]
    public function apparielMesure(Parametre $parametre, Request $request, AppareilMesureEssaisRepository $appareilMesureEssaisRepository): Response
    {
        // Initialisation de l'entité AppareilMesureEssais
        $appareil = new AppareilMesureEssais();

        // Création du formulaire pour l'appareil de mesure
        $formAppareil = $this->createForm(AppareilMesureEssaisType::class, $appareil);
        $formAppareil->handleRequest($request);
        $date = date('Y-m-d');

        // Si le formulaire est soumis et valide
        if ($formAppareil->isSubmitted() && $formAppareil->isValid()) {
            $choix = $request->get('bouton5');

            if ($choix == 'ajouter') {
                // Vérification de la validité de l'appareil
                $dateAppareil = $appareil->getAppareil()->getDateValidite()->format('Y-m-d');
                if ($dateAppareil < $date) {
                    $this->addFlash("message", "L'appareil que vous venez de choisir a expiré et la date de validité est : " . $dateAppareil);
                } else {
                    // Mise à jour de l'entité et sauvegarde dans la base de données
                    $appareil->setParametre($parametre);
                    $appareilMesureEssaisRepository->save($appareil, true);
                    $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
                }
            }
        }

        // Rendu de la vue Twig pour l'appareil de mesure
        return $this->render('essais_finaux/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareil' => $formAppareil->createView(),
        ]);
    }

    // Route pour valider les essais finaux
    #[Route('/validation/{id}', name: 'valider_essais_finaux', methods: ['GET'])]
    public function validation(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        if ($parametre) {
            // Préparation des informations pour l'envoi de l'email
            $dossier = 'email/email.html.twig';
            $subject = "Essais Finaux";
            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " " . $parametre->getAffaire()->getSuiviPar()->getPrenom();
            $message = "L'expertise essais Finaux a été validée";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = " N° d'affaire : " . $parametre->getAffaire()->getNumAffaire();

            // Envoi d'emails aux administrateurs avec le rôle 'ROLE_AGENT_MAITRISE'
            $admins = $adminRepository->findAll();
            foreach ($admins as $admin) {
                foreach ($admin->getRoles() as $role) {
                    if ($role == 'ROLE_AGENT_MAITRISE') {
                        $email = $admin->getEmail();
                        $cdp = $admin->getNom() . ' ' . $admin->getPrenom();
                        $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);
                    }
                }
            }

            // Initialise la date actuelle avec le fuseau horaire de Paris
            $dateZone = new \DateTimeZone('Europe/Paris');
            $date = new \DateTime('now', $dateZone);
            // Récupère le nom d'utilisateur de l'opérateur actuellement connecté
            $operateur = $this->getUser();

           /* if(is_null($parametre->getSignature()))
            {
                $signature = new Signature();
                $signature->setParametre($parametre);
                $signature->setEssaiFinaux(1);
                $signature->setDateEssaiFinaux($date);
                $signature->setOperateurEssaiFinaux($operateur);
                $entityManager->persist($signature);

            }else
            {
                $signature = $parametre->getSignature();
                $signature->setEssaiFinaux(1);
                $signature->setDateEssaiFinaux($date);
                $signature->setOperateurEssaiFinaux($operateur);
                $entityManager->persist($signature);
            }
           */


            // Envoi d'un email au responsable de l'affaire
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            // Mise à jour de l'entité et sauvegarde dans la base de données
            $parametre->setEssaisFinaux(1);
            $entityManager->persist($parametre);
            $entityManager->flush();
            $this->addFlash("success", "L'expertise validée avec succès");
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer un point de fonctionnement
    #[Route('/fonctionnement/{id}/point', name: 'delete_point_fonctionnement_vide', methods: ['GET'])]
    public function deletePointFonctionnement(Request $request, PointFonctionnementVide $pointFonctionnementVide, PointFonctionnementVideRepository $pointFonctionnementVideRepository): Response
    {
        $id = $pointFonctionnementVide->getParametre()->getId();
        if ($pointFonctionnementVide) {
            // Suppression de l'image associée
            $nom = $pointFonctionnementVide->getImage();
            unlink($this->getParameter('point_fonctionnement_vide') . '/' . $nom);

            // Suppression de l'entité dans la base de données
            $pointFonctionnementVideRepository->remove($pointFonctionnementVide, true);
            return $this->redirectToRoute('app_point_fonctionnement_vide', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_point_fonctionnement_vide', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une session de mesure d'isolement
    #[Route('/delete/{id}/{paramID}', name: 'delete_mesure_essai')]
    public function supprimeSession($id, $paramID, Request $request)
    {
        $session = $request->getSession();
        $tablesEssais = $session->get('essais', []);

        // Suppression de la session de mesure spécifique
        if (array_key_exists($id, $tablesEssais)) {
            unset($tablesEssais[$id]);
            $session->set('essais', $tablesEssais);
        }

        return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $paramID]);
    }

    // Route pour supprimer une mesure d'isolement de la base de données
    #[Route('/delete-lmesure-isolement/{id}/{id2}', name: 'delete_lmesure_isolement_essai')]
    public function supprimeLIsolement(LMesureIsolementEssai $lmesureIsolement, $id2, Request $request, LMesureIsolementEssaiRepository $lmesureIsolementRepository)
    {
        if ($lmesureIsolement) {
            // Suppression de l'entité dans la base de données
            $lmesureIsolementRepository->remove($lmesureIsolement, true);
            return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $id2]);
        }
    }

    // Route pour la création d'une mesure de résistance
    #[Route('/mesure-resistance-essai/{id}', name: 'app_mesure_resistance_essai', methods: ['POST', 'GET'])]
    public function mesureResistance(Parametre $parametre, Request $request, MesureResistanceEssaiRepository $mesureResistanceRepository, EntityManagerInterface $em): Response
    {
        // Initialisation des entités nécessaires
        $mesureResistance = new MesureResistanceEssai();
        $lmesureResistance = new LMesureResistanceEssai();

        // Si une mesure de résistance existe déjà, on la récupère
        if ($parametre->getMesureResistanceEssai()) {
            $mesureResistance = $parametre->getMesureResistanceEssai()->getParametre()->getMesureResistanceEssai();
        }

        // Création des formulaires
        $formMesureResistance = $this->createForm(MesureResistanceEssaiType::class, $mesureResistance);
        $formMesureResistance->handleRequest($request);
        $form = $this->createForm(LMesureReistanceEssaiType::class, $lmesureResistance);
        $form->handleRequest($request);

        // Gestion des sessions
        $session = $request->getSession();
        $tables = $session->get('resistances', []);

        // Si les formulaires sont soumis
        if ($formMesureResistance->isSubmitted() && $form->isSubmitted()) {
            // Récupération du choix de l'utilisateur
            $choix = $request->get('bouton8');

            if ($choix == 'mesure_resistance_en_cours') {
                // Parcours des éléments de la session pour enregistrer les mesures en cours
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistanceEssai();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setTempCorrection($item->getTempCorrection());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureReistanceEssai($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                // Mise à jour de l'état et sauvegarde des données
                $parametre->setMesureResistanceEssai($mesureResistance);
                $mesureResistance->setEtat(0);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);

            } elseif ($choix == 'mesure_resistance_terminer') {
                // Parcours des éléments de la session pour enregistrer les mesures terminées
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistanceEssai();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setTempCorrection($item->getTempCorrection());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureReistanceEssai($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                // Mise à jour de l'état et sauvegarde des données
                $parametre->setMesureResistanceEssai($mesureResistance);
                $mesureResistance->setEtat(1);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);

            } elseif ($choix == 'ajouter') {
                // Ajout d'une nouvelle mesure de résistance
                $lig = sizeof($tables) + 1;
                $lmesureResistance->setLig($lig);

                // Vérification des doublons
                foreach ($tables as $i) {
                    if ($i->getType() == $lmesureResistance->getType() && $i->getControle() == $lmesureResistance->getControle()) {
                        $this->addFlash("message", "Vous avez déjà ajouté ce contrôle");
                        return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
                    }
                }

                // Vérification des doublons dans les mesures existantes
                if ($parametre->getMesureResistanceEssai()) {
                    foreach ($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais() as $j) {
                        if ($j->getType() == $lmesureResistance->getType() && $j->getControle() == $lmesureResistance->getControle()) {
                            $this->addFlash("message", "Vous avez déjà ajouté ce contrôle");
                            return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
                        }
                    }
                }

                // Ajout de la nouvelle mesure à la session
                $tables[$lig] = $lmesureResistance;
                $session->set('resistances', $tables);
            }
        }

        // Rendu de la vue Twig pour la mesure de résistance
        return $this->render('essais_finaux/mesure_resistance.html.twig', [
            'parametre' => $parametre,
            'formMesureResistance' => $formMesureResistance->createView(),
            'form' => $form->createView(),
            'items' => $tables,
        ]);
    }

    // Route pour supprimer une session de mesure de résistance
    #[Route('/delete-lmesure-essais-resistance/{id}/{id2}', name: 'delete_lmesure_resistance_essai_session')]
    public function supprimeSessionResistance($id, $id2, Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('resistances', []);

        // Suppression de la session de mesure spécifique
        if (array_key_exists($id, $tables)) {
            unset($tables[$id]);
            $session->set('resistances', $tables);
        }

        return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $id2]);
    }

    // Route pour supprimer une mesure de résistance de la base de données
    #[Route('/delete-lmesure-resistance/{id}/{id2}', name: 'delete_lmesure_essai_resistance')]
    public function supprimeLResistance(LMesureResistanceEssai $lMesureResistance, $id2, Request $request, LMesureResistanceEssaiRepository $lMesureResistanceRepository)
    {
        if ($lMesureResistance) {
            // Suppression de l'entité dans la base de données
            $lMesureResistanceRepository->remove($lMesureResistance, true);
            return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $id2]);
        }
    }
}
