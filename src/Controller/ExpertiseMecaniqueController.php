<?php

namespace App\Controller;

use App\Entity\Coussinet;
use App\Entity\HydroAero;
use App\Entity\ImagePlan;
use App\Entity\Parametre;
use App\Entity\Roulement;
use App\Entity\PhotoRotor;
use App\Entity\Signature;
use App\Entity\Synoptique;
use App\Form\CoussinetType;
use App\Form\HydroAeroType;
use App\Form\ImagePlanType;
use App\Form\RoulementType;
use App\Form\SynoptiqueType;
use App\Entity\ConstatMecanique;
use App\Form\ConstatMecaniqueType;
use App\Entity\ControleGeometrique;
use App\Entity\ControleRecensement;
use App\Entity\ReleveDimmensionnel;
use App\Form\ControleGeometriqueType;
use App\Form\ControleRecensementType;
use App\Form\ReleveDimmensionnelType;
use App\Entity\AppareilMesureMecanique;
use App\Entity\ControleVisuelMecanique;
use App\Entity\PhotoExpertiseMecanique;
use App\Repository\CoussinetRepository;
use App\Repository\HydroAeroRepository;
use App\Repository\ImagePlanRepository;
use App\Repository\RoulementRepository;
use App\Entity\AccessoireSupplementaire;
use App\Entity\ControleMontageConssinet;
use App\Entity\ControleMontageRoulement;
use App\Repository\PhotoRotorRepository;
use App\Repository\SynoptiqueRepository;
use App\Service\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppareilMesureMecaniqueType;
use App\Form\ControleVisuelMecaniqueType;
use App\Form\PhotoExpertiseMecaniqueType;
use App\Form\AccessoireSupplementaireType;
use App\Form\ControleMontageCoussinetType;
use App\Form\ControleMontageRoulementType;
use App\Form\PhotoRotorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ConstatMecaniqueRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleGeometriqueRepository;
use App\Repository\ControleRecensementRepository;
use App\Repository\ReleveDimmensionnelRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\ControleVisuelMecaniqueRepository;
use App\Repository\PhotoExpertiseMecaniqueRepository;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\AdminRepository;
use App\Repository\ControleMontageConssinetRepository;
use App\Repository\ControleMontageRoulementRepository;
use App\Service\MailerService;
use App\Service\RedimensionneService;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

// Déclaration de la classe de contrôleur avec annotation de route
#[Route('/expertiseMecanique')]
class ExpertiseMecaniqueController extends AbstractController
{
    // Constructeur de la classe injectant divers services nécessaires
    public function __construct(private EntityManagerInterface $entityManager,
                                private RedimensionneService $redimensionneService,
                                private ImageService $imageService,
                                private ImagePlanRepository $imagePlanRepository,
                                private SluggerInterface $slugger
    )
    {
    }

    // Route pour afficher la page d'index de l'expertise mécanique
    #[Route('/index/{id}/mecanique', name: 'app_expertise_mecanique')]
    public function index(Parametre $parametre, Request $request,): Response
    {
        // Rendu du template avec le paramètre passé à la vue
        return $this->render('expertise_mecanique/index.html.twig', ['parametre' => $parametre,]);
    }

    // Route pour ajouter une photo à la réception
    #[Route('/photo-reception/{id}', name: 'app_photo_reception')]
    public function photoReception(Parametre $parametre, ControleRecensementRepository $controleRecensementRepository, Request $request, SluggerInterface $slugger)
    {
        // Création d'une nouvelle instance de ControleRecensement
        $controleRecensement = new ControleRecensement();
        // Création du formulaire associé à l'entité ControleRecensement
        $formControleRecensement = $this->createForm(ControleRecensementType::class, $controleRecensement);
        // Traitement de la requête HTTP avec les données du formulaire
        $formControleRecensement->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formControleRecensement->isSubmitted() && $formControleRecensement->isValid()) {
            // Vérification de l'unicité de la photo par son libellé
            $trouve = false;
            foreach ($parametre->getControleRecensements() as $item) {
                if ($item->getLibelle() == $controleRecensement->getLibelle()) {
                    $trouve = true;
                }
            }

            // Si la photo n'a pas déjà été ajoutée
            if ($trouve == false) {
                // Gestion de l'image uploadée
                $photo = $formControleRecensement->get('photo')->getData();
                if ($photo)
                {
                    // Récupération de la taille de l'image
                    $size = $photo->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_photo_reception', ['id' => $parametre->getId()]);

                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                        try {
                            $photo->move(
                                $this->getParameter('image_controle_recensement'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_controle_recensement'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $controleRecensement->setPhoto($newPhotoname);
                    }
                }

                // Association du controle recensement au paramètre et sauvegarde dans la base de données
                $controleRecensement->setParametre($parametre);
                $controleRecensementRepository->save($controleRecensement, true);
                return $this->redirectToRoute('app_photo_reception', ['id' => $parametre->getId()]);
            } else {
                // Affichage d'un message si la photo a déjà été ajoutée
                $this->addFlash("message", "oups ! vous avez déjà ajouté cette photo : " . $controleRecensement->getLibelle());
                return $this->redirectToRoute('app_photo_reception', ['id' => $parametre->getId()]);
            }
        }
        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/controle_recensement.html.twig', [
            'parametre' => $parametre,
            'formControleRecensement' => $formControleRecensement->createView()

        ]);
    }

    // Route pour ajouter une photo du rotor
    #[Route('/photo-rotor-mecanique/{id}', name: 'app_photo_rotor')]
    public function photoRotor(Parametre $parametre, PhotoRotorRepository $photoRotorRepository, Request $request, SluggerInterface $slugger)
    {
        // Création d'une nouvelle instance de PhotoRotor
        $photoRotor = new PhotoRotor();
        // Récupération du nombre de photos du rotor associées au paramètre
        $taille = count($photoRotorRepository->findByParametre($parametre));
        // Création du formulaire associé à l'entité PhotoRotor
        $formPhotoRotor = $this->createForm(PhotoRotorType::class, $photoRotor);
        // Traitement de la requête HTTP avec les données du formulaire
        $formPhotoRotor->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formPhotoRotor->isSubmitted() && $formPhotoRotor->isValid()) {
            // Vérification si aucune photo du rotor n'a déjà été ajoutée
            if ($taille == 0) {

                // Gestion de l'image uploadée
                $photo = $formPhotoRotor->get('libelle')->getData();
                if ($photo)
                {
                    // Récupération de la taille de l'image
                    $size = $photo->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_photo_rotor', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                        try {
                            $photo->move(
                                $this->getParameter('image_rotor'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_rotor'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $photoRotor->setLibelle($newPhotoname);
                    }
                }

                // Association de la photo du rotor au paramètre et sauvegarde dans la base de données
                $photoRotor->setParametre($parametre);
                $photoRotor->setEtat(1);
                $photoRotorRepository->save($photoRotor, true);
                return $this->redirectToRoute('app_photo_rotor', ['id' => $parametre->getId()]);
            } else {
                // Affichage d'un message si une photo du rotor a déjà été ajoutée
                $this->addFlash("danger", "Désolé vous avez déjà ajouté cette photo");
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/photo_rotor.html.twig', [
            'parametre' => $parametre,
            'formPhotoRotor' => $formPhotoRotor->createView()

        ]);
    }

    // Route pour le contrôle visuel et recensement
    #[Route('/controle-visuel/{id}', name: 'app_controle_visuel_mecanique')]
    public function consoleVisuel(AccessoireSupplementaireRepository $accessoireSupplementaireRepository, Parametre $parametre, Request $request, ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,): Response
    {
        // Création d'une nouvelle instance de ControleVisuelMecanique et AccessoireSupplementaire
        $controleVisuelMecanique = new ControleVisuelMecanique();
        $accessoireSupplementaire = new AccessoireSupplementaire();

        // Si le paramètre a déjà un controle visuel mécanique, on le récupère
        if ($parametre->getControleVisuelMecanique()) {
            $controleVisuelMecanique = $parametre->getControleVisuelMecanique()->getParametre()->getControleVisuelMecanique();
        }

        // Création des formulaires associés aux entités ControleVisuelMecanique et AccessoireSupplementaire
        $formControlevisuelMecanque = $this->createForm(ControleVisuelMecaniqueType::class, $controleVisuelMecanique);
        $formAccessoire = $this->createForm(AccessoireSupplementaireType::class, $accessoireSupplementaire);
        // Traitement de la requête HTTP avec les données des formulaires
        $formControlevisuelMecanque->handleRequest($request);
        $formAccessoire->handleRequest($request);

        // Récupération des accessoires supplémentaires avec le numéro de ligne 0
        $tables = $accessoireSupplementaireRepository->findByLig(0);
        // Si les formulaires sont soumis et valides
        if ($formControlevisuelMecanque->isSubmitted() && $formAccessoire->isSubmitted()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton1');
            if ($choix == 'ajouter') {
                // Ajout d'un accessoire supplémentaire
                $accessoireSupplementaire->setLig(0);
                $accessoireSupplementaireRepository->save($accessoireSupplementaire, true);
                return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parametre->getId()]);
            } elseif ($choix == 'controle_visuel_en_cours') {
                // Mise à jour des accessoires supplémentaires et du contrôle visuel en cours
                foreach ($tables as $item) {
                    $item->setLig(1);
                    $item->setControleVisuelMecanique($controleVisuelMecanique);
                }
                // Gestion de l'image uploadée
                $photo = $formControlevisuelMecanque->get('photo_accouplement')->getData();
                if ($photo)
                {
                    // Récupération de la taille de l'image
                    $size = $photo->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $this->slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                        try {
                            $photo->move(
                                $this->getParameter('image_rotor'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_rotor'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $controleVisuelMecanique->setPhotoAccouplement($newPhotoname);
                    }
                }

                $parametre->setControleVisuelMecanique($controleVisuelMecanique);
                $controleVisuelMecanique->setEtat(0);
                $controleVisuelMecaniqueRepository->save($controleVisuelMecanique, true);
                return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parametre->getId()]);
            } elseif ($choix == 'controle_visuel_terminer') {

                // Gestion de l'image uploadée
                $photo = $formControlevisuelMecanque->get('photo_accouplement')->getData();
                if ($photo)
                {
                    // Récupération de la taille de l'image
                    $size = $photo->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $this->slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                        try {
                            $photo->move(
                                $this->getParameter('image_rotor'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_rotor'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $controleVisuelMecanique->setPhotoAccouplement($newPhotoname);
                    }
                }
                // Mise à jour des accessoires supplémentaires et du contrôle visuel terminé
                foreach ($tables as $item) {
                    $item->setLig(1);
                    $item->setControleVisuelMecanique($controleVisuelMecanique);
                }
                $parametre->setControleVisuelMecanique($controleVisuelMecanique);
                $controleVisuelMecanique->setEtat(1);
                $controleVisuelMecaniqueRepository->save($controleVisuelMecanique, true);
                return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données des formulaires et du paramètre
        return $this->render('expertise_mecanique/controle_visuel.html.twig', [
            'parametre' => $parametre,
            'formAccessoire' => $formAccessoire->createView(),
            'controleVisuelMecanique' => $controleVisuelMecanique,
            'formControlevisuelMecanque' => $formControlevisuelMecanque->createView(),
            'accessoires' => $tables,

        ]);
    }

    // Route pour le contrôle de montage de roulement
    #[Route('/controle-montage-roulement/{id}', name: 'app_controle_montage_roulement')]
    public function consoleMontage(ControleMontageRoulementRepository $controleMontageRoulementRepository, Parametre $parametre, Request $request, ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,): Response
    {
        // Création d'une nouvelle instance de ControleMontageRoulement
        $controleMontageRoulement = new ControleMontageRoulement();
        // Si le paramètre a déjà un contrôle de montage de roulement, on le récupère
        if ($parametre->getControleMontageRoulement()) {
            $controleMontageRoulement = $parametre->getControleMontageRoulement()->getParametre()->getControleMontageRoulement();
        }

        // Création du formulaire associé à l'entité ControleMontageRoulement
        $formControlMontageRoulement = $this->createForm(ControleMontageRoulementType::class, $controleMontageRoulement);
        // Traitement de la requête HTTP avec les données du formulaire
        $formControlMontageRoulement->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formControlMontageRoulement->isSubmitted() && $formControlMontageRoulement->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton2');
            if ($choix == 'controle_montage_roulement_en_cours') {
                // Mise à jour du contrôle de montage de roulement en cours
                $parametre->setControleMontageRoulement($controleMontageRoulement);
                $controleMontageRoulement->setEtat(0);
                $controleMontageRoulementRepository->save($controleMontageRoulement, true);
                $this->redirectToRoute('app_controle_montage_roulement', ['id' => $parametre->getId()]);
            } elseif ($choix == 'controle_montage_roulement_terminer') {
                // Mise à jour du contrôle de montage de roulement terminé
                $parametre->setControleMontageRoulement($controleMontageRoulement);
                $controleMontageRoulement->setEtat(1);
                $controleMontageRoulementRepository->save($controleMontageRoulement, true);
                $this->redirectToRoute('app_controle_montage_roulement', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/controle_montage_roulement.html.twig', [
            'parametre' => $parametre,
            'formControlMontageRoulement' => $formControlMontageRoulement->createView()
        ]);
    }

    // Route pour le contrôle de montage de coussinet
    #[Route('/controle-montage-coussinet/{id}', name: 'app_controle_montage_coussinet')]
    public function consoleMontageCoussinet(ControleMontageConssinetRepository $controleMontageConssinetRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance de ControleMontageCoussinet
        $controleMontageCoussinet = new ControleMontageConssinet();
        // Si le paramètre a déjà un contrôle de montage de coussinet, on le récupère
        if ($parametre->getControleMontageCoussinet()) {
            $controleMontageCoussinet = $parametre->getControleMontageCoussinet()->getParametre()->getControleMontageCoussinet();
        }

        // Création du formulaire associé à l'entité ControleMontageCoussinet
        $formControlMontageCoussinet = $this->createForm(ControleMontageCoussinetType::class, $controleMontageCoussinet);
        // Traitement de la requête HTTP avec les données du formulaire
        $formControlMontageCoussinet->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formControlMontageCoussinet->isSubmitted() && $formControlMontageCoussinet->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton3');
            if ($choix == 'controle_montage_coussinet_en_cours') {
                // Mise à jour du contrôle de montage de coussinet en cours
                $parametre->setControleMontageCoussinet($controleMontageCoussinet);
                $controleMontageCoussinet->setEtat(0);
                $controleMontageConssinetRepository->save($controleMontageCoussinet, true);
                $this->redirectToRoute('app_controle_montage_coussinet', ['id' => $parametre->getId()]);
            } elseif ($choix == 'controle_montage_coussinet_terminer') {
                // Mise à jour du contrôle de montage de coussinet terminé
                $parametre->setControleMontageCoussinet($controleMontageCoussinet);
                $controleMontageCoussinet->setEtat(1);
                $controleMontageConssinetRepository->save($controleMontageCoussinet, true);
                $this->redirectToRoute('app_controle_montage_coussinet', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/controle_montage_coussinet.html.twig', [
            'parametre' => $parametre,
            'formControlMontageCoussinet' => $formControlMontageCoussinet->createView(),

        ]);
    }

    // Route pour le relevé dimensionnel
    #[Route('/releve-dimensionnel/{id}', name: 'app_releve_dimensionnel')]
    public function releveDimensionnel(ReleveDimmensionnelRepository $releveDimmensionnelRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance de ReleveDimmensionnel
        $releveDimmensionnel = new ReleveDimmensionnel();
        // Création du formulaire associé à l'entité ReleveDimmensionnel
        $formReleveDimmensionnel = $this->createForm(ReleveDimmensionnelType::class, $releveDimmensionnel);
        // Traitement de la requête HTTP avec les données du formulaire
        $formReleveDimmensionnel->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formReleveDimmensionnel->isSubmitted() && $formReleveDimmensionnel->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton4');
            if ($choix == 'ajouter') {
                // Ajout du relevé dimensionnel au paramètre et sauvegarde dans la base de données
                $releveDimmensionnel->setParametre($parametre);
                $releveDimmensionnelRepository->save($releveDimmensionnel, true);
                $this->redirectToRoute('app_releve_dimensionnel', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/releve_dimensionnels.html.twig', [
            'parametre' => $parametre,
            'formReleveDimmensionnel' => $formReleveDimmensionnel->createView()
        ]);
    }

    // Route pour le contrôle géométrique
    #[Route('/controle-geometrique/{id}', name: 'app_controle_geometrique')]
    public function controleGeometrique(ControleGeometriqueRepository $controleGeometriqueRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance de ControleGeometrique
        $controleGeometrique = new ControleGeometrique();
        // Création du formulaire associé à l'entité ControleGeometrique
        $formControlGeometrique = $this->createForm(ControleGeometriqueType::class, $controleGeometrique);
        // Traitement de la requête HTTP avec les données du formulaire
        $formControlGeometrique->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formControlGeometrique->isSubmitted() && $formControlGeometrique->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton5');
            if ($choix == 'controle_geometrique_en_cours') {
                // Vérification de l'unicité du contrôle géométrique par type et diamètre
                $trouve = false;
                if ($parametre->getControleGeometriques()) {
                    foreach ($parametre->getControleGeometriques() as $item) {
                        if ($item->getType() == $controleGeometrique->getType() and $item->getDiametre() == $controleGeometrique->getDiametre()) {
                            $trouve = true;
                        }
                    }
                }

                // Si le contrôle géométrique n'a pas déjà été ajouté
                if ($trouve == false) {
                    // Ajout du contrôle géométrique au paramètre et sauvegarde dans la base de données
                    $controleGeometrique->setEtat(0);
                    $controleGeometrique->setParametre($parametre);
                    $controleGeometriqueRepository->save($controleGeometrique, true);
                    return $this->redirectToRoute('app_controle_geometrique', ['id' => $parametre->getId()]);
                } else {
                    // Affichage d'un message d'erreur
                    $this->addFlash("error", "Ce contrôle existe déjà ! ");
                }
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/controle_geometrique.html.twig', [
            'parametre' => $parametre,
            'formControlGeometrique' => $formControlGeometrique->createView(),
        ]);
    }

    // Route pour ajouter un appareil de mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_mesure_mecanique')]
    public function appareilMesure(AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance d'AppareilMesureMecanique
        $appareilMesureMecanique = new AppareilMesureMecanique();
        // Création du formulaire associé à l'entité AppareilMesureMecanique
        $formAppareilMesureMecanique = $this->createForm(AppareilMesureMecaniqueType::class, $appareilMesureMecanique);
        // Traitement de la requête HTTP avec les données du formulaire
        $formAppareilMesureMecanique->handleRequest($request);
        $date = date('Y-m-d');
        // Si le formulaire est soumis et valide
        if ($formAppareilMesureMecanique->isSubmitted() && $formAppareilMesureMecanique->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton6');
            if ($choix == 'ajouter') {
                // Vérification de la date de validité de l'appareil
                $dateAppareil = $appareilMesureMecanique->getAppareil()->getDateValidite()->format('Y-m-d');
                if ($dateAppareil < $date) {
                    // Affichage d'un message d'erreur
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : " . $dateAppareil);
                } else {
                    // Ajout de l'appareil de mesure au paramètre et sauvegarde dans la base de données
                    $appareilMesureMecanique->setParametre($parametre);
                    $appareilMesureMecanique->setEtat(0);
                    $appareilMesureMecaniqueRepository->save($appareilMesureMecanique, true);
                    $this->redirectToRoute('app_appareil_mesure_mecanique', ['id' => $parametre->getId()]);
                }
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareilMesureMecanique' => $formAppareilMesureMecanique->createView(),
        ]);
    }

    // Route pour l'expertise Hydro ou Aéro
    #[Route('/hydro-aero/{id}', name: 'app_hydro_aero')]
    public function hydroAero(HydroAeroRepository $hydroAeroRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance d'HydroAero
        $hydroAero = new HydroAero();
        // Si le paramètre a déjà une expertise HydroAero, on la récupère
        if ($parametre->getHydroAero()) {
            $hydroAero =  $parametre->getHydroAero()->getParametre()->getHydroAero();
        }

        // Création du formulaire associé à l'entité HydroAero
        $formHydroAero = $this->createForm(HydroAeroType::class, $hydroAero);
        // Traitement de la requête HTTP avec les données du formulaire
        $formHydroAero->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formHydroAero->isSubmitted() && $formHydroAero->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton7');
            if ($choix == 'hydro_aero_en_cours') {
                // Mise à jour de l'expertise HydroAero en cours
                $parametre->setHydroAero($hydroAero);
                $hydroAero->setEtat(0);
                $hydroAeroRepository->save($hydroAero, true);
                $this->redirectToRoute('app_hydro_aero', ['id' => $parametre->getId()]);
            } elseif ($choix == 'hydro_aero_terminer') {
                // Mise à jour de l'expertise HydroAero terminée
                $parametre->setHydroAero($hydroAero);
                $hydroAero->setEtat(1);
                $hydroAeroRepository->save($hydroAero, true);
                $this->redirectToRoute('app_hydro_aero', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/expertise_hydro_aero.html.twig', [
            'parametre' => $parametre,
            'formHydroAero' => $formHydroAero->createView(),
        ]);
    }

    // Route pour ajouter des photos pour l'expertise mécanique
    #[Route('/photos/{id}', name: 'app_photos_mecanique')]
    public function photo(PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository, SluggerInterface $slugger, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance de PhotoExpertiseMecanique
        $photoExpertiseMecanique = new PhotoExpertiseMecanique();
        // Création du formulaire associé à l'entité PhotoExpertiseMecanique
        $formPhotoExpertiseMecanique = $this->createForm(PhotoExpertiseMecaniqueType::class, $photoExpertiseMecanique);
        // Traitement de la requête HTTP avec les données du formulaire
        $formPhotoExpertiseMecanique->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formPhotoExpertiseMecanique->isSubmitted() && $formPhotoExpertiseMecanique->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton8');
            if ($choix == 'ajouter') {
                // Gestion de l'image uploadée
                $image = $formPhotoExpertiseMecanique->get('image')->getData();
                if ($image) {
                    // Récupération de la taille de l'image
                    $size = $image->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_photos_mecanique', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('image_expertise_mecaniques'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {}

                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_expertise_mecanique'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $photoExpertiseMecanique->setImage($newPhotoname);
                    }
                }

                // Association de la photo à l'expertise mécanique et sauvegarde dans la base de données
                $photoExpertiseMecanique->setParametre($parametre);
                $photoExpertiseMecaniqueRepository->save($photoExpertiseMecanique, true);
                $this->redirectToRoute('app_photos_mecanique', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/photo.html.twig', [
            'parametre' => $parametre,
            'formPhotoExpertiseMecanique' => $formPhotoExpertiseMecanique->createView(),
        ]);
    }

    // Route pour ajouter un constat mécanique
    #[Route('/constat-mecanique/{id}', name: 'app_constat_mecanique')]
    public function constat(ConstatMecaniqueRepository $constatMecaniqueRepository, SluggerInterface $slugger, Parametre $parametre, Request $request): Response
    {
        // Création d'une nouvelle instance de ConstatMecanique
        $constatMecanique = new ConstatMecanique();
        // Création du formulaire associé à l'entité ConstatMecanique
        $formConstatMecanique = $this->createForm(ConstatMecaniqueType::class, $constatMecanique);
        // Traitement de la requête HTTP avec les données du formulaire
        $formConstatMecanique->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formConstatMecanique->isSubmitted() && $formConstatMecanique->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton9');
            if ($choix == 'ajouter') {
                // Gestion de l'image uploadée
                $image = $formConstatMecanique->get('photo')->getData();
                if ($image) {
                    // Récupération de la taille de l'image
                    $size = $image->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_constat_mecanique', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_constat_mecanique'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_mecanique'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $constatMecanique->setPhoto($newPhotoname);
                    }
                }
                // Association du constat mécanique au paramètre et sauvegarde dans la base de données
                $constatMecanique->setParametre($parametre);
                $constatMecaniqueRepository->save($constatMecanique, true);

                $this->redirectToRoute('app_constat_mecanique', ['id' => $parametre->getId()]);
            }
        }
        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/constat.html.twig', [
            'parametre' => $parametre,
            'formConstatMecanique' => $formConstatMecanique->createView(),
        ]);
    }

    // Route pour modifier un constat mécanique
    #[Route('/edit-constat-mecanique/{id}/{idC}', name: 'app_constat_mecanique_edit')]
    public function editConstat(ConstatMecaniqueRepository $constatMecaniqueRepository, SluggerInterface $slugger, Parametre $parametre, $idC, Request $request): Response
    {
        // Récupération du constat mécanique à modifier
        $constat = $constatMecaniqueRepository->findById($idC);
        $constatMecanique = $constat[0];

        // Création du formulaire associé à l'entité ConstatMecanique
        $formConstatMecanique = $this->createForm(ConstatMecaniqueType::class, $constatMecanique);
        // Traitement de la requête HTTP avec les données du formulaire
        $formConstatMecanique->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($formConstatMecanique->isSubmitted() && $formConstatMecanique->isValid()) {
            // Récupération du choix fait par l'utilisateur
            $choix = $request->get('bouton9');
            if ($choix == 'ajouter') {
                // Gestion de l'image uploadée
                $image = $formConstatMecanique->get('photo')->getData();
                if ($image) {
                    // Récupération de la taille de l'image
                    $size = $image->getSize();
                    // Vérification si l'image est supérieure à 2 Mo
                    if($size > 2*1024*1024)
                    {
                        // Affichage d'un message d'erreur
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_constat_mecanique', ['id' => $parametre->getId()]);
                    }else{
                        // Traitement et sauvegarde de l'image
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_constat_mecanique'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_mecanique'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $constatMecanique->setPhoto($newPhotoname);
                    }
                }
                // Mise à jour du constat mécanique et sauvegarde dans la base de données
                $constatMecanique->setParametre($parametre);
                $constatMecaniqueRepository->save($constatMecanique, true);

                return $this->redirectToRoute('app_constat_mecanique', ['id' => $parametre->getId()]);
            }
        }

        // Rendu du template avec les données du formulaire et du paramètre
        return $this->render('expertise_mecanique/constat.html.twig', [
            'parametre' => $parametre,
            'constatMecanique' => $constatMecanique,
            'formConstatMecanique' => $formConstatMecanique->createView(),
        ]);
    }

    // Route pour supprimer un accessoire supplémentaire
    #[Route('/delete/{id}/{parmID}', name: "app_delete_accessoire", methods: ['GET'])]
    public function delete($parmID, AccessoireSupplementaire $accessoireSupplementaire, AccessoireSupplementaireRepository $accessoireSupplementaireRepository)
    {
        // Suppression de l'accessoire supplémentaire et redirection vers la page de contrôle visuel mécanique
        if ($accessoireSupplementaire) {
            $accessoireSupplementaireRepository->remove($accessoireSupplementaire, true);
            return $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $parmID]);
        }
    }

    // Route pour supprimer une photo de l'expertise mécanique
    #[Route('/photo/{id}/expertise', name: 'delete_photo_expertise_mecanique', methods: ['GET'])]
    public function deletePhoto(PhotoExpertiseMecanique $photoExpertiseMecanique, PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository): Response
    {
        // Récupère l'ID du paramètre associé à la photo d'expertise mécanique
        $id = $photoExpertiseMecanique->getParametre()->getId();

        // Vérifie si l'objet PhotoExpertiseMecanique est non nul
        if ($photoExpertiseMecanique) {
            // Récupère le nom de l'image associée à la photo d'expertise mécanique
            $nom = $photoExpertiseMecanique->getImage();

            // Supprime le fichier image du système de fichiers
            unlink($this->getParameter('image_expertise_mecaniques') . '/' . $nom);

            // Supprime l'objet PhotoExpertiseMecanique de la base de données
            $photoExpertiseMecaniqueRepository->remove($photoExpertiseMecanique, true);

            // Redirige l'utilisateur vers la route 'app_photos_mecanique' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_photos_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet PhotoExpertiseMecanique est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_photos_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer un constat mécanique
    #[Route('/constat/{id}/mecanique', name: 'delete_constat_mecanique', methods: ['GET'])]
    public function deleteConstat(ConstatMecanique $constatMecanique, ConstatMecaniqueRepository $constatMecaniqueRepository): Response
    {
        // Récupère l'ID du paramètre associé au constat mécanique
        $id = $constatMecanique->getParametre()->getId();

        // Vérifie si l'objet ConstatMecanique n'est pas nul
        if ($constatMecanique) {
            // Récupère le nom de la photo associée au constat mécanique
            $nom = $constatMecanique->getPhoto();

            // Vérifie si le nom de la photo n'est pas nul
            if ($nom != null) {
                // Supprime le fichier image du système de fichiers
                unlink($this->getParameter('images_constat_mecanique') . '/' . $nom);
            }

            // Supprime l'objet ConstatMecanique de la base de données
            $constatMecaniqueRepository->remove($constatMecanique, true);

            // Redirige l'utilisateur vers la route 'app_constat_mecanique' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_constat_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet ConstatMecanique est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_constat_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer un relevé dimensionnel
    #[Route('releve/dimmensionnel/{id}', name: 'delete_releve_dimmensionnel', methods: ['GET'])]
    public function deleteReleve(ReleveDimmensionnel $releveDimmensionnel, ReleveDimmensionnelRepository $releveDimmensionnelRepository): Response
    {
        // Récupère l'ID du paramètre associé au relevé dimensionnel
        $id = $releveDimmensionnel->getParametre()->getId();

        // Vérifie si l'objet ReleveDimmensionnel n'est pas nul
        if ($releveDimmensionnel) {
            // Supprime l'objet ReleveDimmensionnel de la base de données
            $releveDimmensionnelRepository->remove($releveDimmensionnel, true);

            // Redirige l'utilisateur vers la route 'app_releve_dimensionnel' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet ReleveDimmensionnel est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour valider une expertise mécanique
    #[Route('validation/{id}', name: 'valider_expertise_mecanique', methods: ['GET'])]
    public function validation(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        // Vérifie si l'objet Parametre n'est pas nul
        if ($parametre) {
            // Déclaration des variables pour l'email
            $dossier = 'email/email.html.twig';
            $subject = "Expertise mécanique";
            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " " . $parametre->getAffaire()->getSuiviPar()->getPrenom();
            $message = "L'expertise mécanique a été validée";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = "N° d'affaire : " . $parametre->getAffaire()->getNumAffaire();

            // Envoie d'email aux agents de maîtrise
            $admins = $adminRepository->findAll();
            foreach ($admins as $admin) {
                foreach ($admin->getRoles() as $role) {
                    if ($role == 'ROLE_AGENT_MAITRISE') {
                        // Envoie de l'email
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
                $signature->setExpMeca(1);
                $signature->setDateExpMeca($date);
                $signature->setOperateurExpMeca($operateur);
                $entityManager->persist($signature);

            }else
            {
                $signature = $parametre->getSignature();
                $signature->setExpMeca(1);
                $signature->setDateExpMeca($date);
                $signature->setOperateurExpMeca($operateur);
                $entityManager->persist($signature);
            }

            // Envoie de l'email au suivi de l'affaire
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            // Mise à jour du paramètre et sauvegarde
            $parametre->setExpertiseMecanique(1);
            $entityManager->persist($parametre);
            $entityManager->flush();

            // Ajoute un message flash de succès
            $this->addFlash("success", "L'expertise validée avec succès");

            // Redirection après succès
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            // Redirection si Parametre est nul
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    // La fonction qui supprime une photo à la réception
    #[Route('/recetpion/{id}', name: 'app_delete_controle_recensement', methods: ['GET'])]
    public function deletePhotoReception(ControleRecensement $controleRecensement, ControleRecensementRepository $controleRecensementRepository): Response
    {
        // Récupère l'ID du paramètre associé au contrôle de recensement
        $id = $controleRecensement->getParametre()->getId();

        // Vérifie si l'objet ControleRecensement n'est pas nul
        if ($controleRecensement) {
            // Récupère le nom de la photo associée au contrôle de recensement
            $nom = $controleRecensement->getPhoto();

            // Supprime le fichier image du système de fichiers
            unlink($this->getParameter('image_controle_recensement') . '/' . $nom);

            // Supprime l'objet ControleRecensement de la base de données
            $controleRecensementRepository->remove($controleRecensement, true);

            // Redirige l'utilisateur vers la route 'app_photo_reception' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_photo_reception', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet ControleRecensement est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_photo_reception', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //coussinet CA & COA
    #[Route('/coussinet/{id}', name: 'app_coussinet')]
    public function coussinet(CoussinetRepository $coussinetRepository, Parametre $parametre, Request $request, SluggerInterface $slugger): Response
    {
        $coussinet = new Coussinet();
        if ($parametre->getCoussinet()) {
            $coussinet =  $parametre->getCoussinet()->getParametre()->getCoussinet();
        }

        $formCoussinet = $this->createForm(CoussinetType::class, $coussinet);
        $formCoussinet->handleRequest($request);
        if ($formCoussinet->isSubmitted() && $formCoussinet->isValid()) {
            $choix = $request->get('bouton003');
            if ($choix == 'coussinet_en_cours') {
                //photo coussinet ca
                $photo_ca = $formCoussinet->get('photo_ca')->getData();
                if ($photo_ca) 
                {
                    //récuperer la taille de l'image à inserrer
                    $size = $photo_ca->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
                    }else{
                        $originalePhoto = pathinfo($photo_ca->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_ca->guessExtension();
                        try {
                            $photo_ca->move(
                                $this->getParameter('image_coussinet'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_coussinet'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $coussinet->setPhotoCa($newPhotoname);
                    }
                }

                //photo coussinet coa
                $photo_coa = $formCoussinet->get('photo_coa')->getData();
                if ($photo_coa) {
                    //récuperer la taille de l'image à inserrer
                    $size = $photo_coa->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
                    }else{
                        $originalePhoto = pathinfo($photo_coa->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_coa->guessExtension();
                        try {
                            $photo_coa->move(
                                $this->getParameter('image_coussinet'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_coussinet'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $coussinet->setPhotoCoa($newPhotoname);
                    }
                }

                $parametre->setCoussinet($coussinet);
                $coussinet->setEtat(0);
                $coussinetRepository->save($coussinet, true);
                $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
            } elseif ($choix == 'coussinet_terminer') {

                //photo coussinet ca
                $photo_ca = $formCoussinet->get('photo_ca')->getData();
                if ($photo_ca) {
                    //récuperer la taille de l'image à inserrer
                    $size = $photo_ca->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
                    }else{
                        $originalePhoto = pathinfo($photo_ca->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_ca->guessExtension();
                        try {
                            $photo_ca->move(
                                $this->getParameter('image_coussinet'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_coussinet'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $coussinet->setPhotoCa($newPhotoname);
                    }
                }

                //photo coussinet coa
                $photo_coa = $formCoussinet->get('photo_coa')->getData();
                if ($photo_coa) {
                    //récuperer la taille de l'image à inserrer
                    $size = $photo_coa->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
                    }else{
                        $originalePhoto = pathinfo($photo_coa->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_coa->guessExtension();
                        try {
                            $photo_coa->move(
                                $this->getParameter('image_coussinet'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_coussinet'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $coussinet->setPhotoCoa($newPhotoname);
                    }
                }

                $parametre->setCoussinet($coussinet);
                $coussinet->setEtat(1);
                $coussinetRepository->save($coussinet, true);
                $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
            }
        }


        return $this->render('expertise_mecanique/coussinet.html.twig', [
            'parametre' => $parametre,
            'coussinet' => $coussinet,
            'formCoussinet' => $formCoussinet->createView(),
        ]);
    }

    // Route pour gérer le roulement CA & COA
    #[Route('/roulement/{id}', name: 'app_roulement')]
    public function roulement(RoulementRepository $roulementRepository, Parametre $parametre, Request $request): Response
    {
        // Création d'un nouvel objet Roulement
        $roulement = new Roulement();

        // Vérifie si le paramètre a un roulement existant
        if ($parametre->getRoulement()) {
            $roulement =  $parametre->getRoulement()->getParametre()->getRoulement();
        }

        // Création du formulaire de roulement
        $formRoulement = $this->createForm(RoulementType::class, $roulement);
        $formRoulement->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($formRoulement->isSubmitted() && $formRoulement->isValid()) {
            // Récupère le choix de l'utilisateur
            $choix = $request->get('bouton004');

            // Action selon le choix de l'utilisateur
            if ($choix == 'roulement_en_cours') {
                $parametre->setRoulement($roulement);
                $roulement->setEtat(0);
                $roulementRepository->save($roulement, true);
                $this->redirectToRoute('app_roulement', ['id' => $parametre->getId()]);
            } elseif ($choix == 'roulement_terminer') {
                $parametre->setRoulement($roulement);
                $roulement->setEtat(1);
                $roulementRepository->save($roulement, true);
                $this->redirectToRoute('app_roulement', ['id' => $parametre->getId()]);
            }
        }

        // Affiche le formulaire et les données du roulement
        return $this->render('expertise_mecanique/roulement.html.twig', [
            'parametre' => $parametre,
            'roulement' => $roulement,
            'formRoulement' => $formRoulement->createView(),
        ]);
    }
    //synoptiques 
    // Route pour la gestion du synoptique
    #[Route('/synoptique/{id}', name: 'app_synoptique')]
    public function synoptique(Parametre $parametre, SynoptiqueRepository $synoptiqueRepository, Request $request)
    {
        // Création de nouveaux objets Synoptique et ImagePlan
        $synoptique = new Synoptique();
        $image_plan = new ImagePlan();

        // Création des formulaires pour Synoptique et ImagePlan
        $form = $this->createForm(SynoptiqueType::class, $synoptique);
        $form_image = $this->createForm(ImagePlanType::class, $image_plan);
        $form->handleRequest($request);
        $form_image->handleRequest($request);

        // Gestion du formulaire d'image (CA et COA)
        if ($form_image->isSubmitted() && $form_image->isValid())
        {
            // Récupère les fichiers d'image CA et COA
            $imageFileCA = $form_image->get('image_ca')->getData();
            $imageFileCOA = $form_image->get('image_coa')->getData();

            // Récupère la taille des fichiers d'image
            $size1 = $imageFileCA->getSize();
            $size2 = $imageFileCOA->getSize();

            // Vérifie si la taille de l'image est supérieure à 2 Mo
            if ($size1 > 2 * 1024 * 1024 or $size2 > 2 * 1024 * 1024)
            {
                // Ajoute un message d'erreur et redirige
                $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                return $this->redirectToRoute('app_synoptique', ['id' => $parametre->getId()]);
            }
            else
            {
                // Définit le répertoire de stockage des images
                $directory = $this->getParameter('images_plan');
                // Upload des fichiers d'image CA et COA
                $image_plan->setImageCa($this->imageService->upload($imageFileCA, $directory));
                $image_plan->setImageCoa($this->imageService->upload($imageFileCOA, $directory));
            }

            // Associe l'objet ImagePlan au Parametre
            $image_plan->setParametre($parametre);
            $this->entityManager->persist($image_plan);
            $this->entityManager->flush();
            // Redirige après traitement
            return $this->redirectToRoute('app_synoptique', ['id' => $parametre->getId()]);
        }

        // Gestion du formulaire de synoptique
        if ($form->isSubmitted() && $form->isValid())
        {
            // Associe l'objet Synoptique au Parametre
            $synoptique->setParametre($parametre);
            $synoptiqueRepository->save($synoptique, true);
            // Redirige après traitement
            return $this->redirectToRoute('app_synoptique', ['id' => $parametre->getId()]);
        }

        // Rendu du formulaire et des données dans la vue
        return $this->render('expertise_mecanique/synoptique.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView(),
            'form_image' => $form_image->createView()
        ]);
    }

    //la fonction qui supprime synoptique
    // Route pour supprimer un synoptique
    #[Route('/syno-delete/{id}', name: 'app_delete_synoptique', methods: ['GET'])]
    public function deleteSynoptique(Synoptique $synoptique, SynoptiqueRepository $synoptiqueRepository): Response
    {
        // Récupère l'ID du paramètre associé au synoptique
        $id = $synoptique->getParametre()->getId();

        // Vérifie si l'objet Synoptique n'est pas nul
        if ($synoptique) {
            // Supprime l'objet Synoptique de la base de données
            $synoptiqueRepository->remove($synoptique, true);

            // Redirige l'utilisateur vers la route 'app_synoptique' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_synoptique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet Synoptique est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_synoptique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui supprime controle géometrique
    // La fonction qui supprime un contrôle géométrique
    #[Route('/controle-delete-geo/{id}', name: 'app_delete_geom_controle', methods: ['GET'])]
    public function deleteGeo(ControleGeometrique $controleGeometrique, ControleGeometriqueRepository $controleGeometriqueRepository): Response
    {
        // Récupère l'ID du paramètre associé au contrôle géométrique
        $id = $controleGeometrique->getParametre()->getId();

        // Vérifie si l'objet ControleGeometrique n'est pas nul
        if ($controleGeometrique) {
            // Supprime l'objet ControleGeometrique de la base de données
            $controleGeometriqueRepository->remove($controleGeometrique, true);

            // Redirige l'utilisateur vers la route 'app_controle_geometrique' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_controle_geometrique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            // Si l'objet ControleGeometrique est nul, redirige l'utilisateur vers la même route avec un code de statut HTTP 303
            return $this->redirectToRoute('app_controle_geometrique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    // Route pour supprimer une photo de rotor
    #[Route('/drop-ro-photo/{id}', name: 'drop_ro_ph', methods: ['GET', 'POST'])]
    public function dropPhoto(PhotoRotor $photoRotor, PhotoRotorRepository $photoRotorRepository)
    {
        // Récupère l'ID du paramètre associé à la photo de rotor
        $id = $photoRotor->getParametre()->getId();
        // Débuggage pour afficher l'objet photoRotor
        // dd($photoRotor);

        // Vérifie si l'objet PhotoRotor n'est pas nul
        if ($photoRotor) {
            // Récupère le nom de la photo associée au rotor
            $nom = $photoRotor->getLibelle();

            // Supprime le fichier image du système de fichiers
            unlink($this->getParameter('image_rotor') . '/' . $nom);

            // Supprime l'objet PhotoRotor de la base de données
            $photoRotorRepository->remove($photoRotor, true);

            // Redirige l'utilisateur vers la route 'app_photo_rotor' après suppression avec un code de statut HTTP 303
            return $this->redirectToRoute('app_photo_rotor', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        // Redirige l'utilisateur vers la même route si l'objet PhotoRotor est nul avec un code de statut HTTP 303
        return $this->redirectToRoute('app_photo_rotor', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

}
