<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Repository\AdminRepository;
use App\Service\MailerService;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/validation')]
class ValidationController extends AbstractController
{
    #[Route('/index', name: 'app_validation_index')]
    public function index(ParametreRepository $parametreRepository): Response
    {
        $lists = $parametreRepository->findBy([], ['id' => 'desc']);
        $parametres  = [];
        $parametres2  = [];
        $tabs  = [];

        foreach ($lists as $item) {
            if ($item->isStatut() == null && $item->isExpertiseElectiqueAvantLavage() == 1 && $item->isExpertiseElectiqueApresLavage() == 1 && $item->isExpertiseMecanique() == 1) {
                array_push($parametres, $item);
            }
        }

        foreach ($lists as $item) {
            if ($item->isStatutFinal() == null && $item->isRemontage() == 1 && $item->isEssaisFinaux() == 1 && $item->isStatut() == 1) {
                array_push($tabs, $item);
            }
        }

        foreach ($tabs as $item) {
            if ($item->getAffaire()->isEtat() == 0) {
                array_push($parametres2, $item);
            }
        }

        return $this->render('validation/index.html.twig', [
            'parametres' => $parametres,
            'parametres2' => $parametres2,
        ]);
    }


    #[Route('/show/{id}', name: 'app_validation_show')]
    public function show(Parametre $parametre): Response
    {
        if ($parametre) {
            return $this->render('validation/show.html.twig', [
                'parametre' => $parametre,
            ]);
        }
    }

    #[Route('/show-final/{id}', name: 'app_validation_show_final')]
    public function showFinal(Parametre $parametre): Response
    {
        if ($parametre) {
            return $this->render('validation/show_final.html.twig', [
                'parametre' => $parametre,
            ]);
        }
    }

    #[Route('/validation-expertise/{id}', name: 'app_validation_valide_expertise')]
    public function validationExpertise(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $em, MailerService $mailerService): Response
    {
        if ($parametre) {
            $dossier = 'email/email.html.twig';
            $subject = "Validation de rapport Expertise";

            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "Vous avez une validation du rapport d'expertise";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = " Num d'affaire : " . $parametre->getAffaire()->getNumAffaire();

            $admins = $adminRepository->findAll();
            foreach ($admins as $admin) {
                foreach ($admin->getRoles() as $role) {
                    if ($role == 'ROLE_AGENT_MAITRISE') {
                        //envoyer le mail
                        $email = $admin->getEmail();
                        $cdp = $admin->getNom() . ' ' . $admin->getPrenom();
                        $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);
                    };
                }
            }

            //envoyer le mail
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            $parametre->setStatut(1);
            $em->persist($parametre);
            $em->flush();
            return $this->redirectToRoute('app_affaire_rapport');
        }
    }

    #[Route('/validation-finale/{id}', name: 'app_validation_valide_finale')]
    public function validationFinale(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $em, MailerService $mailerService): Response
    {
        // dd($parametre->getAffaire());
        $affaire = $parametre->getAffaire();
        if ($parametre) {
            $dossier = 'email/email.html.twig';
            $subject = "Validation de rapport Final";

            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "Vous avez une validation du rapport Final";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = " Num d'affaire : " . $parametre->getAffaire()->getNumAffaire();

            //envoyer le mail
            $admins = $adminRepository->findAll();
            foreach ($admins as $admin) {
                foreach ($admin->getRoles() as $role) {
                    if ($role == 'ROLE_AGENT_MAITRISE') {
                        $email = $admin->getEmail();
                        $cdp = $admin->getNom() . ' ' . $admin->getPrenom();
                        $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);
                    };
                }
            }

            //envoyer le mail
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            $parametre->setStatutFinal(1);
            $affaire->setEtat(1);
            $em->persist($affaire);
            $em->persist($parametre);
            $em->flush();
            return $this->redirectToRoute('app_affaire_rapport');
        }
    }
}
