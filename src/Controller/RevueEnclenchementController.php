<?php

namespace App\Controller;

use App\Entity\Affaire;
use App\Entity\Atelier;
use App\Form\AtelierType;
use App\Entity\EtudesAchats;
use App\Form\EtudesAchatsType;
use App\Entity\RevueEnclenchement;
use App\Form\AtelierIndiceType;
use App\Form\RevueEnclenchementType;
use App\Repository\AtelierRepository;
use App\Repository\EtudesAchatsRepository;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RevueEnclenchementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Form\RevueEnclenchement2Type;

// Définition de la route principale pour ce contrôleur
#[Route('/revue/enclenchement')]
class RevueEnclenchementController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    // Route pour afficher la liste de toutes les revues d'enclenchement
    #[Route('/', name: 'app_revue_enclenchement_index', methods: ['GET'])]
    public function index(RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        // Rendu de la vue Twig 'index.html.twig' avec la liste des revues d'enclenchement
        return $this->render('revue_enclenchement/index.html.twig', [
            'revue_enclenchements' => $revueEnclenchementRepository->findAll(),
        ]);
    }

    // Route pour créer une nouvelle revue d'enclenchement ou mettre à jour une revue existante pour une affaire spécifique
    #[Route('/new-create/{id}', name: 'app_revue_enclenchement_new', methods: ['GET', 'POST'])]
    public function newIndiceA(Request $request, Affaire $affaire, RevueEnclenchementRepository $revueEnclenchementRepository, ParametreRepository $parametreRepository, EtudesAchatsRepository $etudesAchatsRepository, AtelierRepository $atelierRepository): Response
    {
        $revueEnclenchement = new RevueEnclenchement();

        // Vérification si une revue d'enclenchement existe déjà pour l'affaire
        if (count($affaire->getRevueEnclenchements()) != 0) {
            $revueEn = $revueEnclenchementRepository->findByAffaire($affaire);
            $revueEnclenchement = $revueEn[0];
        }

        $form = $this->createForm(RevueEnclenchementType::class, $revueEnclenchement);
        $form->handleRequest($request);

        $user = $this->getUser()->getNom() . ' ' . $this->getUser()->getPrenom();

        $etudesAchats = new EtudesAchats();
        $formEtudesAchats = $this->createForm(EtudesAchatsType::class, $etudesAchats);
        $formEtudesAchats->handleRequest($request);

        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach ($listes as $item) {
            if ($item->getAffaire()->getId() == $affaire->getId()) {
                array_push($parametre, $item);
            }
        }

        $atelier = new Atelier();
        $formAtelier = $this->createForm(AtelierType::class, $atelier);
        $formAtelier->handleRequest($request);

        // Soumission et validation du formulaire de revue d'enclenchement
        if ($form->isSubmitted() && $form->isValid()) {
            $revueEnclenchement->setUtilisateur($user);
            $revueEnclenchement->setAffaire($affaire);
            $revueEnclenchement->setIndice('Indice A');
            foreach ($affaire->getParametres() as $item) {
                $item->setEtat(1);
            }

            $revueEnclenchementRepository->save($revueEnclenchement, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Soumission et validation du formulaire d'études et achats
        if ($formEtudesAchats->isSubmitted() && $formEtudesAchats->isValid()) {
            $etudesAchats->setRevueEnclenchement($revueEnclenchement);
            $etudesAchatsRepository->save($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Soumission et validation du formulaire d'atelier
        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) {
            $atelier->setRevueEnclenchement($revueEnclenchement);
            $atelierRepository->save($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'new.html.twig' avec les formulaires et données nécessaires
        return $this->render('revue_enclenchement/new.html.twig', [
            'affaire' => $affaire,
            'parametre' => $parametre,
            'revue_enclenchement' => $revueEnclenchement,
            'etudes_achats' => $etudesAchats,
            'atelier' => $atelier,
            'form' => $form->createView(),
            'formAtelier' => $formAtelier->createView(),
            'formEtudesAchats' => $formEtudesAchats->createView(),
        ]);
    }

    // Route pour créer une nouvelle revue d'enclenchement avec un indice B pour une affaire spécifique
    #[Route('/indice-revue/{id}', name: 'app_revue_enclenchement_indice', methods: ['GET', 'POST'])]
    public function newIndiceB(Request $request, Affaire $affaire, RevueEnclenchementRepository $revueEnclenchementRepository, ParametreRepository $parametreRepository, EtudesAchatsRepository $etudesAchatsRepository, AtelierRepository $atelierRepository): Response
    {
        $revueEnclenchement = new RevueEnclenchement();
        $revueEn = $revueEnclenchementRepository->findByAffaire($affaire);
        $indice = $revueEn[0];
        $indiceDate = $revueEn[0];

        // Vérification si une revue d'enclenchement existe déjà pour l'affaire
        if (count($affaire->getRevueEnclenchements()) > 1) {
            $revueEnclenchement = $revueEn[1];
            $indice = $revueEn[1];
        }

        $form = $this->createForm(RevueEnclenchement2Type::class, $revueEnclenchement);
        $form->handleRequest($request);

        $user = $this->getUser()->getNom() . ' ' . $this->getUser()->getPrenom();

        $etudesAchats = new EtudesAchats();
        $formEtudesAchats = $this->createForm(EtudesAchatsType::class, $etudesAchats);
        $formEtudesAchats->handleRequest($request);

        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach ($listes as $item) {
            if ($item->getAffaire()->getId() == $affaire->getId()) {
                array_push($parametre, $item);
            }
        }

        $atelier = new Atelier();
        $formAtelier = $this->createForm(AtelierIndiceType::class, $atelier);
        $formAtelier->handleRequest($request);

        // Soumission et validation du formulaire de revue d'enclenchement
        if ($form->isSubmitted() && $form->isValid()) {
            $revueEnclenchement->setUtilisateur($user);
            $revueEnclenchement->setAffaire($affaire);
            $revueEnclenchement->setIndice('Indice B');

            if ($revueEnclenchement->getRe7Client() == null) {
                $revueEnclenchement->setRe7Client($indiceDate->getRe7Client());
            } else {
                $revueEnclenchement->setRe7Client($revueEnclenchement->getRe7Client());
            }

            $revueEnclenchement->setDelaiDemandeClient($indiceDate->getDelaiDemandeClient());
            $revueEnclenchement->setArriveCommande($indiceDate->getArriveCommande());
            $revueEnclenchement->setRevueEnclenchement($indiceDate->getRevueEnclenchement());
            $revueEnclenchement->setArc($indiceDate->getArc());
            $revueEnclenchement->setArriveeMachine($indiceDate->getArriveeMachine());
            $revueEnclenchement->setDateRapportExpertiseFinalise($indiceDate->getDateRapportExpertiseFinalise());

            foreach ($affaire->getParametres() as $item) {
                $item->setEtat(1);
            }

            $revueEnclenchementRepository->save($revueEnclenchement, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Soumission et validation du formulaire d'études et achats
        if ($formEtudesAchats->isSubmitted() && $formEtudesAchats->isValid()) {
            $etudesAchats->setRevueEnclenchement($revueEnclenchement);
            $etudesAchatsRepository->save($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Soumission et validation du formulaire d'atelier
        if ($formAtelier->isSubmitted() && $formAtelier->isValid())
        {
            //dd($atelier);
            $atelier->setRevueEnclenchement($revueEnclenchement);
            $this->entityManager->persist($atelier);
            $this->entityManager->flush();
           // dd('bien joue');
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Rendu de la vue Twig 'new_indice.html.twig' avec les formulaires et données nécessaires
        return $this->render('revue_enclenchement/new_indice.html.twig', [
            'affaire' => $affaire,
            'parametre' => $parametre,
            'revue_enclenchement' => $revueEnclenchement,
            'indice' => $indice,
            'etudes_achats' => $etudesAchats,
            'atelier' => $atelier,
            'form' => $form->createView(),
            'formAtelier' => $formAtelier->createView(),
            'formEtudesAchats' => $formEtudesAchats->createView(),
        ]);
    }

    // Route pour afficher les détails d'une revue d'enclenchement spécifique
    #[Route('/show-revue/{id}', name: 'app_revue_enclenchement_show', methods: ['GET'])]
    public function show(RevueEnclenchement $revueEnclenchement, ParametreRepository $parametreRepository): Response
    {
        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach ($listes as $item) {
            if ($item->getAffaire()->getId() == $revueEnclenchement->getAffaire()->getId()) {
                array_push($parametre, $item);
            }
        }
        return $this->render('revue_enclenchement/show.html.twig', [
            'revue_enclenchement' => $revueEnclenchement,
            'parametre' => $parametre,
        ]);
    }

    // Route pour éditer une revue d'enclenchement existante
    #[Route('/{id}/edit', name: 'app_revue_enclenchement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RevueEnclenchement $revueEnclenchement, RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        $form = $this->createForm(RevueEnclenchementType::class, $revueEnclenchement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $revueEnclenchementRepository->save($revueEnclenchement, true);
            return $this->redirectToRoute('app_revue_enclenchement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('revue_enclenchement/edit.html.twig', [
            'revue_enclenchement' => $revueEnclenchement,
            'form' => $form,
        ]);
    }

    // Route pour supprimer une revue d'enclenchement existante
    #[Route('/{id}', name: 'app_revue_enclenchement_delete', methods: ['POST'])]
    public function delete(Request $request, RevueEnclenchement $revueEnclenchement, RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $revueEnclenchement->getId(), $request->request->get('_token'))) {
            $revueEnclenchementRepository->remove($revueEnclenchement, true);
        }

        return $this->redirectToRoute('app_revue_enclenchement_index', [], Response::HTTP_SEE_OTHER);
    }

    // Route pour supprimer un élément d'études et achats
    #[Route('/etudes-achats/{id}', name: 'delete_etudes_achats', methods: ['POST', 'GET'])]
    public function deleteEtudes(Request $request, EtudesAchats $etudesAchats, EtudesAchatsRepository $etudesAchatsRepository): Response
    {
        $id = $etudesAchats->getRevueEnclenchement()->getAffaire()->getId();
        if ($etudesAchats) {
            $etudesAchatsRepository->remove($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    // Route pour supprimer un élément d'études et achats avec un indice spécifique
    #[Route('/etudes-achats-indice/{id}', name: 'delete_etudes_achat_indice', methods: ['POST', 'GET'])]
    public function deleteEtudesIndice(Request $request, EtudesAchats $etudesAchats, EtudesAchatsRepository $etudesAchatsRepository): Response
    {
        $id = $etudesAchats->getRevueEnclenchement()->getAffaire()->getId();
        if ($etudesAchats) {
            $etudesAchatsRepository->remove($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    // Route pour supprimer un atelier
    #[Route('/atelier/{id}', name: 'delete_atelier', methods: ['POST', 'GET'])]
    public function atelier(Request $request, Atelier $atelier, AtelierRepository $atelierRepository): Response
    {
        $id = $atelier->getRevueEnclenchement()->getAffaire()->getId();
        if ($atelier) {
            $atelierRepository->remove($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    // Route pour supprimer un atelier avec un indice spécifique
    #[Route('/atelier-indice/{id}', name: 'delete_atelier_indicie', methods: ['POST', 'GET'])]
    public function atelierIndice(Request $request, Atelier $atelier, AtelierRepository $atelierRepository): Response
    {
        $id = $atelier->getRevueEnclenchement()->getAffaire()->getId();
        if ($atelier) {
            $atelierRepository->remove($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    // Route pour générer un PDF de la revue d'enclenchement
    #[Route('/print-revue-enclenchement/{id}', name: 'app_revue_enclenchement_print', methods: ['POST', 'GET'])]
    public function print(RevueEnclenchement $revueEnclenchement, ParametreRepository $parametreRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instanciation de Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);
        $dompdf->setCallbacks([
            'event' => function ($event) use ($dompdf) {
                if ($event['event'] === 'dompdf.page_number') {
                    $dompdf->getCanvas()->page_text(500, 18, 'Page {PAGE_NUM} sur {PAGE_COUNT}', null, 10, [0, 0, 0]);
                }
            }
        ]);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach ($listes as $item) {
            if ($item->getAffaire()->getId() == $revueEnclenchement->getAffaire()->getId()) {
                array_push($parametre, $item);
            }
        }

        $dompdf->setHttpContext($context);
        if ($revueEnclenchement->getIndice() == 'Indice A') {
            $html = $this->renderView('revue_enclenchement/print.html.twig', [
                'parametre' => $parametre,
                'revue_enclenchement' => $revueEnclenchement,
            ]);
        } else {
            $html = $this->renderView('revue_enclenchement/printb.html.twig', [
                'parametre' => $parametre,
                'revue_enclenchement' => $revueEnclenchement,
            ]);
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Génération d'un nom de fichier
        $fichier = "Revue d'enclenchement du projet : " . $revueEnclenchement->getAffaire()->getNumAffaire();

        // Envoi du PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }
}
