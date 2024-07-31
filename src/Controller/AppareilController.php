<?php
/**
 * ----------------------------------------------------------------
 * Projet : Base Métrologie & Base Métrologie
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 09-05-2023
 * Dernière date de modification : 01-09-2023
 * ----------------------------------------------------------------
 * ********************** Description *****************************
 * ## À savoir que l'accès à la page appareil est obligatoire
 * Base de données :
 *      + nom table : appareil
 * template :
 *       c'est le dossier "appareil" qui contient toutes les pages vues des fonctions de contrôleurs
 *
 * Dans ce contrôleur, vous avez 14 fonctions qui assurent le bon fonctionnement du module appareil.
 * ----------------------------------------------------------------
 */

namespace App\Controller;

use App\Entity\Appareil;
use App\Entity\Certificat;
use App\Form\AppareilType;
use App\Form\CertificatType;
use App\Service\PdfServiceP;
use App\Entity\AppareilMesure;
use App\Entity\AppareilMesureEssais;
use App\Repository\AppareilRepository;
use App\Entity\AppareilMesureMecanique;
use App\Entity\AppareilMesureElectrique;
use App\Repository\AppareilMesureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AppareilMesureEssaisRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\AppareilMesureElectriqueRepository;
use App\Repository\CertificatRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/appareil')]
class AppareilController extends AbstractController
{
    // Route pour afficher la liste des appareils fonctionnels et conformes
    #[Route('/index', name: 'app_appareil_index', methods: ['GET'])]
    public function index(AppareilRepository $appareilRepository): Response
    {
        // Récupère tous les éléments de l'entrepôt "appareil", triés par identifiant de manière décroissante
        $items = $appareilRepository->findBy([], ['id' => 'desc']);

        // Initialise un tableau vide pour stocker les appareils filtrés
        $appareils = [];

        // Parcourt chaque élément récupéré
        foreach($items as $item)
        {
            // Vérifie si l'état de l'élément est "Fonctionnel" et si le statut est "Conforme"
            if ($item->getEtat() == 'Fonctionnel' && $item->getStatut() == 'Conforme')
            {
                // Ajoute l'élément au tableau des appareils filtrés
                array_push($appareils, $item);
            }
        }

        // Retourne la vue 'appareil/index.html.twig' avec les appareils filtrés
        return $this->render('appareil/index.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    // Route pour afficher les appareils hors validité
    #[Route('/hors-validite/index', name: 'app_appareil_hv_index', methods: ['GET'])]
    public function horsValidite(AppareilRepository $appareilRepository): Response
    {
        // Récupère tous les éléments de l'entrepôt "appareil", triés par identifiant de manière décroissante
        $items = $appareilRepository->findBy([],['id' => 'desc']);

        // Initialise un tableau vide pour stocker les appareils hors validité
        $appareils = [];

        // Parcourt chaque élément récupéré
        foreach($items as $item)
        {
            // Vérifie si l'état de l'élément est "Hors Validite"
            if ($item->getEtat() == 'Hors Validite')
            {
                // Ajoute l'élément au tableau des appareils hors validité
                array_push($appareils, $item);
            }
        }

        // Retourne la vue 'appareil/hv.html.twig' avec les appareils hors validité
        return $this->render('appareil/hv.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    // Route pour afficher les appareils perdus
    #[Route('/perdu/index', name: 'app_appareil_perdu_index', methods: ['GET'])]
    public function perdu(AppareilRepository $appareilRepository): Response
    {
        // Récupère tous les éléments de l'entrepôt "appareil", triés par identifiant de manière décroissante
        $items = $appareilRepository->findBy([],['id' => 'desc']);

        // Initialise un tableau vide pour stocker les appareils perdus
        $appareils = [];

        // Parcourt chaque élément récupéré
        foreach($items as $item)
        {
            // Vérifie si l'état de l'élément est "Perdu"
            if ($item->getEtat() == 'Perdu')
            {
                // Ajoute l'élément au tableau des appareils perdus
                array_push($appareils, $item);
            }
        }

        // Retourne la vue 'appareil/perdu.html.twig' avec les appareils perdus
        return $this->render('appareil/perdu.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    // Route pour afficher les appareils hors service
    #[Route('/hs/index', name: 'app_appareil_hs_index', methods: ['GET'])]
    public function hs(AppareilRepository $appareilRepository): Response
    {
        // Récupère tous les éléments de l'entrepôt "appareil", triés par identifiant de manière décroissante
        $items = $appareilRepository->findBy([],['id' => 'desc']);

        // Initialise un tableau vide pour stocker les appareils hors service
        $appareils = [];

        // Parcourt chaque élément récupéré
        foreach($items as $item)
        {
            // Vérifie si l'état de l'élément est "HS"
            if ($item->getEtat() == 'HS')
            {
                // Ajoute l'élément au tableau des appareils hors service
                array_push($appareils, $item);
            }
        }

        // Retourne la vue 'appareil/hs.html.twig' avec les appareils hors service
        return $this->render('appareil/hs.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    // Route pour afficher les appareils en réserve
    #[Route('/reserve/index', name: 'app_appareil_reserve_index', methods: ['GET'])]
    public function reserve(AppareilRepository $appareilRepository): Response
    {
        // Récupère tous les éléments de l'entrepôt "appareil", triés par identifiant de manière décroissante
        $items = $appareilRepository->findBy([],['id' => 'desc']);

        // Initialise un tableau vide pour stocker les appareils en réserve
        $appareils = [];

        // Parcourt chaque élément récupéré
        foreach($items as $item)
        {
            // Vérifie si l'affectation de l'élément est "Réserve"
            if ($item->getAffectation() == 'Réserve')
            {
                // Ajoute l'élément au tableau des appareils en réserve
                array_push($appareils, $item);
            }
        }

        // Retourne la vue 'appareil/reserve.html.twig' avec les appareils en réserve
        return $this->render('appareil/reserve.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    // Route pour ajouter un nouvel appareil
    #[Route('/new', name: 'app_appareil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppareilRepository $appareilRepository): Response
    {
        // Crée un nouvel objet Appareil
        $appareil = new Appareil();

        // Crée un formulaire pour l'ajout de l'appareil
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Définit le statut de l'appareil à 0 (nouveau)
            $appareil->setStatus(0);
            $periodicite = intval($appareil->getPeriodicite());
            $date_depuis  = $appareil->getDateEtat();
            if ($date_depuis && $periodicite)
            {
                $dateValidite = clone $date_depuis;
                $dateValidite->modify('+'.$periodicite. 'months');
                $appareil->setDateValidite($dateValidite);
            }
            // Sauvegarde l'appareil dans la base de données
            $appareilRepository->save($appareil, true);

            // Redirige vers la liste des appareils
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);

            /*
                // Calcule la date_validite
                if ($dateDepuis && $periodicite) {
                    $dateValidite = clone $dateDepuis; // Clone pour éviter de modifier l'objet original
                    $dateValidite->modify('+' . $periodicite . ' months');
                    $appareil->setDateValidite($dateValidite);
                }

             */
        }

        // Affiche le formulaire d'ajout d'un nouvel appareil
        return $this->renderForm('appareil/new.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'un appareil spécifique
    #[Route('/show-app/{id}', name: 'app_appareil_show', methods: ['GET','POST'])]
    public function show(Appareil $appareil, Request $request, SluggerInterface $slugger, CertificatRepository $certificatRepository): Response
    {
        // Crée un nouvel objet Certificat
        $certificat = new Certificat();

        // Crée un formulaire pour l'ajout du certificat
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère le document téléchargé
            $document = $form->get('document')->getData();
            if ($document) {
                // Traite le nom du fichier
                $originalePhoto = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $document->guessExtension();

                // Tente de déplacer le fichier vers le répertoire des certificats
                try {
                    $document->move(
                        $this->getParameter('certificats'),
                        $newPhotoname
                    );
                } catch (FileException $e){
                    // Gestion des exceptions en cas d'erreur lors du déplacement du fichier
                }

                // Définit le document du certificat
                $certificat->setDocument($newPhotoname);
            }

            // Lie le certificat à l'appareil
            $certificat->setAppareil($appareil);

            // Sauvegarde le certificat dans la base de données
            $certificatRepository->save($certificat, true);

            // Redirige vers la page de détails de l'appareil
            return $this->redirectToRoute('app_appareil_show', ['id' => $appareil->getId()]);
        }

        // Affiche la vue 'appareil/show.html.twig' avec les détails de l'appareil et le formulaire de certificat
        return $this->render('appareil/show.html.twig', [
            'appareil' => $appareil,
            'form' => $form->createView()
        ]);
    }

    // Route pour éditer un appareil existant
    #[Route('/{id}/edit', name: 'app_appareil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appareil $appareil, AppareilRepository $appareilRepository): Response
    {
        // Crée un formulaire pour la modification de l'appareil
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde les modifications de l'appareil dans la base de données
            $periodicite = intval($appareil->getPeriodicite());
            $date_depuis  = $appareil->getDateEtat();
            if ($date_depuis && $periodicite)
            {
                $dateValidite = clone $date_depuis;
                $dateValidite->modify('+'.$periodicite. 'months');
                $appareil->setDateValidite($dateValidite);
            }
            $appareilRepository->save($appareil, true);

            // Redirige vers la liste des appareils
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affiche le formulaire d'édition de l'appareil
        return $this->renderForm('appareil/edit.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un appareil
    #[Route('/delete/{id}', name: 'app_appareil_delete', methods: ['GET'])]
    public function delete(Request $request, Appareil $appareil,
       AppareilRepository $appareilRepository,
       AppareilMesureRepository $appareilMesureRepository,
       AppareilMesureEssaisRepository $appareilMesureEssaisRepository,
       AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository,
       AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository): Response
    {
        // Récupère les mesures associées à l'appareil
        $appareilMesure1 = $appareilMesureRepository->findByAppareil($appareil);
        $appareilMesure2 = $appareilMesureEssaisRepository->findByAppareil($appareil);
        $appareilMesure3 = $appareilMesureMecaniqueRepository->findByAppareil($appareil);
        $appareilMesure4 = $appareilMesureElectriqueRepository->findByAppareil($appareil);

        // Vérifie si l'appareil peut être supprimé (aucune mesure associée)
        if($appareil)
        {
            if(!$appareilMesure1 and !$appareilMesure2 and !$appareilMesure3 and !$appareilMesure4)
            {
                // Supprime l'appareil de la base de données
                $appareilRepository->remove($appareil, true);

                // Redirige vers la liste des appareils
                return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
            }
            else
            {
                // Affiche un message d'erreur si l'appareil ne peut pas être supprimé
                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cet Appareil, car y a des expertise sur l'appareil ! ");
                return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        else
        {
            // Redirige vers la liste des appareils si l'appareil n'existe pas
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une mesure d'appareil
    #[Route('mesure/{id}', name: 'delete_appareil', methods: ['GET'])]
    public function deleteAppareilMesure(Request $request, AppareilMesure $appareilMesure, AppareilMesureRepository $appareilMesureRepository): Response
    {
        $idApp = $appareilMesure;
        $id = $idApp->getParametre()->getId();

        // Supprime la mesure de l'appareil si elle existe
        if($appareilMesure)
        {
            $appareilMesureRepository->remove($appareilMesure, true);
            return $this->redirectToRoute('app_appareil_mesure', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_appareil_mesure', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une mesure mécanique d'appareil
    #[Route('mesureMecanique/{id}', name: 'delete_appareil_mecanique', methods: ['GET'])]
    public function deleteAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique, AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository): Response
    {
        $idApp = $appareilMesureMecanique;
        $id = $idApp->getParametre()->getId();

        // Supprime la mesure mécanique de l'appareil si elle existe
        if($appareilMesureMecanique)
        {
            $appareilMesureMecaniqueRepository->remove($appareilMesureMecanique, true);
            return $this->redirectToRoute('app_expertise_mecanique', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_expertise_mecanique', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une mesure électrique d'appareil
    #[Route('mesureElectrique/{id}', name: 'delete_appareil_electrique', methods: ['GET'])]
    public function deleteAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique, AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository): Response
    {
        $idApp = $appareilMesureElectrique;
        $id = $idApp->getParametre()->getId();

        // Supprime la mesure électrique de l'appareil si elle existe
        if($appareilMesureElectrique)
        {
            $appareilMesureElectriqueRepository->remove($appareilMesureElectrique, true);
            return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une mesure d'essai d'appareil
    #[Route('delete-essais/{id}', name: 'delete_appareil_essais', methods: ['GET'])]
    public function deleteAppareilMesureEssais(AppareilMesureEssais $appareilMesureEssais, AppareilMesureEssaisRepository $appareilMesureEssaisRepository): Response
    {
        $idApp = $appareilMesureEssais;
        $id = $idApp->getParametre()->getId();

        // Supprime la mesure d'essai de l'appareil si elle existe
        if($appareilMesureEssais)
        {
            $appareilMesureEssaisRepository->remove($appareilMesureEssais, true);
            return $this->redirectToRoute('app_appareil_essais', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_appareil_essais', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour imprimer la fiche de vie d'un appareil
    #[Route('/print-fiche-de-vie/{id}', name: 'app_print_fiche_de_vie', methods: ['POST','GET'])]
    public function print(Appareil $appareil, PdfServiceP $pdfServiceP): Response
    {
        // Génère la vue HTML pour la fiche de vie de l'appareil
        $html = $this->renderView('appareil/print.html.twig', ['appareil' => $appareil]);

        // Définit le nom du fichier PDF
        $fichier = "Fiche de vie de l'appareil n° : ".$appareil->getNumAppareil();

        // Affiche le fichier PDF
        return $pdfServiceP->showPdfFile($html, $fichier);
    }
}
