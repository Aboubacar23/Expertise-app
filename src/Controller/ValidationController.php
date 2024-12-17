<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\Signature;
use App\Repository\AdminRepository;
use App\Service\MailerService;
use App\Repository\ParametreRepository;
use App\Service\PdfServiceP;
use App\Service\RapportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Définition de la route principale pour ce contrôleur
#[Route('/validation')]
class ValidationController extends AbstractController
{
    // Route pour l'index de la validation
    #[Route('/index', name: 'app_validation_index')]
    public function index(ParametreRepository $parametreRepository): Response
    {
        // Récupération de tous les paramètres en ordre décroissant par ID
        $lists = $parametreRepository->findBy([], ['id' => 'desc']);
        $parametres  = [];
        $parametres2  = [];
        $tabs  = [];

        // Filtrage des paramètres basés sur certaines conditions
        foreach ($lists as $item) {
            if ($item->isStatut() == null && $item->isExpertiseElectiqueAvantLavage() == 1 && $item->isExpertiseElectiqueApresLavage() == 1 && $item->isExpertiseMecanique() == 1) {
                array_push($parametres, $item);
            }
        }

        // Filtrage des paramètres pour un autre ensemble de conditions
        foreach ($lists as $item) {
            if ($item->isStatutFinal() == null && $item->isRemontage() == 1 && $item->isEssaisFinaux() == 1 && $item->isStatut() == 1) {
                array_push($tabs, $item);
            }
        }

        // Vérification de l'état des affaires associées aux paramètres
        foreach ($tabs as $item) {
            if ($item->getAffaire()->isEtat() == 0) {
                array_push($parametres2, $item);
            }
        }

        // Rendu de la vue Twig 'validation/index.html.twig' avec les paramètres filtrés
        return $this->render('validation/index.html.twig', [
            'parametres' => $parametres,
            'parametres2' => $parametres2,
        ]);
    }

    // Route pour afficher un paramètre spécifique
    #[Route('/show/{id}', name: 'app_validation_show')]
    public function show(Parametre $parametre): Response
    {
        if ($parametre) {
            return $this->render('validation/show.html.twig', [
                'parametre' => $parametre,
            ]);
        }
    }

    // Route pour afficher un paramètre spécifique dans une vue finale
    #[Route('/show-final/{id}', name: 'app_validation_show_final')]
    public function showFinal(Parametre $parametre): Response
    {
        if ($parametre) {
            return $this->render('validation/show_final.html.twig', [
                'parametre' => $parametre,
            ]);
        }
    }

    // Route pour valider l'expertise d'un paramètre
    #[Route('/validation-expertise/{id}', name: 'app_validation_valide_expertise')]
    public function validationExpertise(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $em, MailerService $mailerService): Response
    {
        // Préparation des informations pour l'envoi de l'email
        $dossier = 'email/email.html.twig';
        $subject = "Validation de rapport Expertise";

        $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
            . $parametre->getAffaire()->getSuiviPar()->getPrenom();

        $message = "Le rapport d'expertise a été généré";
        $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
        $num_affaire = " N° d'affaire : " . $parametre->getAffaire()->getNumAffaire();

        // Envoi d'emails aux administrateurs avec le rôle 'ROLE_AGENT_MAITRISE'
        $admins = $adminRepository->findAll();
        foreach ($admins as $admin)
        {
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
        $operateur = $this->getUser();

        // Récupère le nom d'utilisateur de l'opérateur actuellement connecté
        if(is_null($parametre->getSignature()))
        {
            $signature = new Signature();
            $signature->setParametre($parametre);
            $signature->setValidationExp(1);
            $signature->setDateValidationExp($date);
            $signature->setOperateurValidationExp($user);
            $signature->setSignatureValidationExp($operateur->getSignaturePhoto());
            $em->persist($signature);
        }else
        {
            $signature = $parametre->getSignature();
            //dd($signature);
            $signature->setValidationExp(1);
            $signature->setDateValidationExp($date);
            $signature->setOperateurValidationExp($user);
            $signature->setSignatureValidationExp($operateur->getSignaturePhoto());
            $em->persist($signature);
        }


        // Envoi d'un email au responsable de l'affaire
        $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
        $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

        // Mise à jour de l'entité et sauvegarde dans la base de données
        $parametre->setStatut(1);
        $em->persist($parametre);
        $em->flush();
        $this->addFlash('success', "Vous avez validé le rapport d'expertise !");
        return $this->redirectToRoute('app_affaire_rapport');
    }

    // Route pour valider la finalisation d'un paramètre
    #[Route('/validation-finale/{id}', name: 'app_validation_valide_finale')]
    public function validationFinale(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $em, MailerService $mailerService): Response
    {
        $affaire = $parametre->getAffaire();
        if ($parametre) {
            // Préparation des informations pour l'envoi de l'email
            $dossier = 'email/email.html.twig';
            $subject = "Validation de rapport Final";

            //récupérer le nom de celui qui suit l'affaire
            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "Le rapport facile a été généré";
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

            if(is_null($parametre->getSignature()))
            {
                $signature = new Signature();
                $signature->setParametre($parametre);
                $signature->setValidationFinale(1);
                $signature->setDateValidationFinale($date);
                $signature->setSignatureValidationFinale($operateur->getSignaturePhoto());
                $signature->setOperateurValidationFinale($user);
                $em->persist($signature);

            }else
            {
                $signature = $parametre->getSignature();
                $signature->setValidationFinale(1);
                $signature->setDateValidationFinale($date);
                $signature->setSignatureValidationFinale($operateur->getSignaturePhoto());
                $signature->setOperateurValidationFinale($user);
                $em->persist($signature);
            }

            // Envoi d'un email au responsable de l'affaire
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            // Mise à jour des entités et sauvegarde dans la base de données
            $parametre->setStatutFinal(1);
            $affaire->setEtat(1);
            $em->persist($affaire);
            $em->persist($parametre);
            $em->flush();
            $this->addFlash('success', "Vous avez validé le rapport final !");
            return $this->redirectToRoute('app_affaire_rapport');
        }
    }

    // Route pour générer un PDF d'expertise avant validation
    #[Route('/pdf/expertise/{id}', name: 'app_validation_pdf_expertise', methods: ['GET'])]
    public function pdfExpertise(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        // Génération du nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();
        $num_projet = $parametre->getAffaire()->getNumAffaire();
        $num_qualite = $parametre->getNumeroQualite();
        $html = $this->renderView('validation/voir_pdf_expertise.html.twig', [
            'parametre' => $parametre
        ]);
        return $pdfServiceP->showPdfFile($html, $fichier, $num_projet, $num_qualite);
    }

    // Route pour générer un PDF final avant validation
    #[Route('/pdf/final/{id}', name: 'app_validation_pdf_final', methods: ['GET'])]
    public function pdfFinal(Parametre $parametre, RapportService $pdfServiceP): Response
    {
        // Génération du nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();
        $num_projet = $parametre->getAffaire()->getNumAffaire();
        $num_qualite = $parametre->getNumeroQualite();
        $html = $this->renderView('validation/voir_pdf_final.html.twig', [
            'parametre' => $parametre
        ]);
        return $pdfServiceP->showPdfFile($html, $fichier, $num_projet, $num_qualite);
    }

    // Route pour générer un PDF de l'expertise électrique avant lavage
    #[Route('/pdf-expertise-ece/{id}', name : 'app_expertise_ece_print', methods : ['GET'])]
    public function pdfECE(Parametre $parametre, RapportService $rapportService): Response
    {
        // Génération du nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();
        $num_projet = $parametre->getAffaire()->getNumAffaire();
        $num_qualite = $parametre->getNumeroQualite();
        $html = $this->renderView('validation/pdf_expertise_ece.html.twig', [
            'parametre' => $parametre
        ]);
        return $rapportService->showPdfFile($html, $fichier, $num_projet, $num_qualite);
    }
}
