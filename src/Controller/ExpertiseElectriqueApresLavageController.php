<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\PontDiode;
use App\Entity\Signature;
use App\Form\PontDiodeType;
use App\Entity\SondeBobinage;
use App\Entity\LSondeBobinage;
use App\Service\MailerService;
use App\Entity\Caracteristique;
use App\Entity\Equirepartition;
use App\Form\SondeBobinageType;
use App\Form\LSondeBobinageType;
use App\Entity\StatorApresLavage;
use App\Form\CaracteristiqueType;
use App\Form\EquirepartitionType;
use App\Entity\LStatorApresLavage;
use App\Entity\PointFonctionnement;
use App\Form\StatorApresLavageType;
use App\Repository\AdminRepository;
use App\Entity\AutreCaracteristique;
use App\Form\LStatorApresLavageType;
use App\Form\AutreCarateristiqueType;
use App\Service\RedimensionneService;
use App\Repository\PontDiodeRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Entity\AppareilMesureElectrique;
use App\Entity\PointFonctionnementRotor;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppareilMesureElectriqueType;
use App\Form\PointFonctionnementRotorType;
use App\Repository\SondeBobinageRepository;
use App\Entity\ConstatElectriqueApresLavage;
use App\Repository\LSondeBobinageRepository;
use App\Entity\AutrePointFonctionnementRotor;
use App\Repository\CaracteristiqueRepository;
use App\Repository\EquirepartitionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ConstatElectriqueApresLavageType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\AutrePointFonctionnementRotorType;
use App\Repository\ControleIsolementRepository;
use App\Repository\StatorApresLavageRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LStatorApresLavageRepository;
use App\Repository\AutreCaracteristiqueRepository;
use App\Repository\AppareilMesureElectriqueRepository;
use App\Repository\PointFonctionnementRotorRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\ConstatElectriqueApresLavageRepository;
use App\Repository\AutrePointFonctionnementRotorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/expertiseEpAL')]
class ExpertiseElectriqueApresLavageController extends AbstractController
{
    public function __construct(Private RedimensionneService $redimensionneService)
    {
        
    }
    #[Route('/index/{id}', name: 'app_expertise_electrique_apres_lavage')]
    public function index(Parametre $parametre): Response
    {
        return $this->render('expertise_electrique_apres_lavage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    //ajout de mesure équirepartition
    #[Route('/equirepartition/{id}', name: 'app_eequirepartition_new')]
    public function equi(Parametre $parametre, Request $request, EntityManagerInterface $entityManager, EquirepartitionRepository $equirepartitionRepository): Response
    {
        // Création d'une nouvelle instance de Equirepartition
        $equirepartition = new Equirepartition();
        // Création du formulaire pour l'entité Equirepartition
        $form = $this->createForm(EquirepartitionType::class, $equirepartition);
        // Traitement de la requête par le formulaire
        $form->handleRequest($request);

        // Initialisation des variables de tension et courant
        $tension = 0;
        $courant = 0;
        /*  Récupération des equirepartitions depuis le paramètre
            $items = $parametre->getEquirepartitions();
            if ($items[0]) {
                // Si le premier élément existe, on récupère ses valeurs de tension et courant
                $tension = $items[0]->getTensionAlimentation();
                $courant = $items[0]->getCourantAbsorbe();
            }
        */

        // Création d'un compteur pour le pôle
        $nb = count($parametre->getEquirepartitions());
        // Initialisation du compteur
        $count = 0;
        // Si aucun equirepartition n'existe, le compteur est à 1, sinon on incrémente le compteur
        if ($nb == 0) {
            $count = 1;
        } else {
            $count = $nb + 1;
        }
        // Définition du nom du pôle
        $pole = 'Pôle ' . $count;

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // On associe l'equirepartition au paramètre
            $equirepartition->setParametre($parametre);
            // On persiste l'entité dans l'EntityManager
            $entityManager->persist($equirepartition);
            // On effectue les changements dans la base de données
            $entityManager->flush();
            // Redirection vers la route de création de nouvelle equirepartition
            return $this->redirectToRoute('app_eequirepartition_new', ['id' => $parametre->getId()]);
        }

        return $this->render('expertise_electrique_apres_lavage/equirepartition.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView(),
            'pole' => $pole,
            'tension' => $tension,
            'courant' => $courant
        ]);
    }
    //ajout de mesure équirepartition
    #[Route('/edit-equirepartition/{id}/{idEq}', name: 'app_eequirepartition_edit')]
    public function editEqui(Parametre $parametre, $idEq, Request $request, EntityManagerInterface $entityManager, EquirepartitionRepository $equirepartitionRepository): Response
    {
        // Recherche de l'equirepartition par son identifiant
        $item = $equirepartitionRepository->findById($idEq);
        // Récupération du premier élément de la recherche
        $equirepartition = $item[0];
        // Création du formulaire pour l'entité Equirepartition
        $form = $this->createForm(EquirepartitionType::class, $equirepartition);
        // Traitement de la requête par le formulaire
        $form->handleRequest($request);
        // Récupération du pôle de l'equirepartition
        $pole = $equirepartition->getPole();

        // Récupération des valeurs de tension et courant de l'equirepartition
        $tension = $equirepartition->getTensionAlimentation();
        $courant = $equirepartition->getCourantAbsorbe();

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On associe l'equirepartition au paramètre
            $equirepartition->setParametre($parametre);
            // On persiste l'entité dans l'EntityManager
            $entityManager->persist($equirepartition);
            // On effectue les changements dans la base de données
            $entityManager->flush();
            // Redirection vers la route de création de nouvelle equirepartition
            return $this->redirectToRoute('app_eequirepartition_new', ['id' => $parametre->getId()]);
        }

        return $this->render('expertise_electrique_apres_lavage/equirepartition.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView(),
            'pole' => $pole,
            'tension' => $tension,
            'courant' => $courant
        ]);
    }

    //stator après lavage
    #[Route('/stator/{id}', name: 'app_stator_apres_lavage')]
    public function stator(Parametre $parametre, Request $request, EntityManagerInterface $em, StatorApresLavageRepository $statorApresLavageRepository, ControleIsolementRepository $controleIsolementRepository): Response
    {
        //stator après lavage
        $statorApresLavage = new StatorApresLavage();
        $lstatorApresLavage = new LStatorApresLavage();
        if ($parametre->getStatorApresLavage()) {
            $statorApresLavage = $parametre->getStatorApresLavage()->getParametre()->getStatorApresLavage();
        }

        $formStatorApresLavage = $this->createForm(StatorApresLavageType::class, $statorApresLavage);
        $form = $this->createForm(LStatorApresLavageType::class, $lstatorApresLavage);
        $formStatorApresLavage->handleRequest($request);
        $form->handleRequest($request);


        $session = $request->getSession();
        $listes = $session->get('stators', []);

        if ($formStatorApresLavage->isSubmitted() && $form->isSubmitted()) {
            $choix = $request->get('bouton1');
            if ($choix == 'stator_en_cours') {
                $i = 0;
                foreach ($listes as $item) {
                    $i = $i + 1;
                    $lstatorApresLavage = new LStatorApresLavage();
                    $lstatorApresLavage->setLig($i);
                    $lstatorApresLavage->setControle($item->getControle());
                    $lstatorApresLavage->setCritere($item->getCritere());

                    $valeur = $item->getValeur();
                    $temp = $item->getTempCorrection();

                    $lstatorApresLavage->setTensionEssai($item->getTensionEssai());
                    $lstatorApresLavage->setValeurRelevee($item->getValeurRelevee());
                    $lstatorApresLavage->setValeur($valeur);
                    $lstatorApresLavage->setTempCorrection($temp);
                    $lstatorApresLavage->setConformite($item->getConformite());
                    $lstatorApresLavage->setType($item->getType());
                    $lstatorApresLavage->setUnite($item->getUnite());
                    $lstatorApresLavage->setStatorApresLavage($statorApresLavage);
                    $em->persist($lstatorApresLavage);
                }

                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(0);
                $session->remove('stators');
                $statorApresLavageRepository->save($statorApresLavage, true);
                return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
            } elseif ($choix == 'stator_terminer') {
                $i = 0;
                foreach ($listes as $item) {
                    $i = $i + 1;
                    $lstatorApresLavage = new LStatorApresLavage();
                    $lstatorApresLavage->setLig($i);
                    $lstatorApresLavage->setControle($item->getControle());
                    $lstatorApresLavage->setCritere($item->getCritere());

                    $valeur = $item->getValeur();
                    $temp = $item->getTempCorrection();

                    $lstatorApresLavage->setTensionEssai($item->getTensionEssai());
                    $lstatorApresLavage->setValeurRelevee($item->getValeurRelevee());
                    $lstatorApresLavage->setValeur($valeur);
                    $lstatorApresLavage->setTempCorrection($temp);
                    $lstatorApresLavage->setConformite($item->getConformite());
                    $lstatorApresLavage->setType($item->getType());
                    $lstatorApresLavage->setUnite($item->getUnite());
                    $lstatorApresLavage->setStatorApresLavage($statorApresLavage);
                    $em->persist($lstatorApresLavage);
                }

                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(1);
                $session->remove('stators');
                $statorApresLavageRepository->save($statorApresLavage, true);
                return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
            } elseif ($choix == 'ajouter')
            {
                $val = 0;

                foreach ($parametre->getMesureIsolement()->getLMesureIsolements() as $item)
                {
                    if ($item->getType() == $lstatorApresLavage->getType() and $item->getControle() == $lstatorApresLavage->getControle() and $item->getTension() == $lstatorApresLavage->getTensionEssai())
                    {
                        if ($item->getControle() == 'IP-UVW/masse' or
                            $item->getControle() == 'IP-U/VW+masse' or
                            $item->getControle() == 'IP-V/UW+masse' or
                            $item->getControle() == 'IP-W/UV+masse')
                        {
                            $val = $item->getValeur();
                        }else{
                            $val = $item->getTempCorrection();
                        }
                    }
                }

                $lig = sizeof($listes) + 1;
                $lstatorApresLavage->setLig($lig);
                $lstatorApresLavage->setValeurRelevee($val);

                foreach ($listes as $i) {
                    if ($i->getType() == $lstatorApresLavage->getType() and $i->getControle() == $lstatorApresLavage->getControle() and $i->getTensionEssai() == $lstatorApresLavage->getTensionEssai()) {
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
                    }
                }

                if ($parametre->getStatorApresLavage()) {
                    foreach ($parametre->getStatorApresLavage()->getLStatorApresLavages() as $j)
                    {
                        if ($j->getType() == $lstatorApresLavage->getType() and $j->getControle() == $lstatorApresLavage->getControle() and $j->getTensionEssai() == $lstatorApresLavage->getTensionEssai()) {
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
                        }
                    }
                }

                $listes[$lig] = $lstatorApresLavage;
                $session->set('stators', $listes);
                //dd($listes);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/stator.html.twig', [
            'parametre' => $parametre,
            'formStatorApresLavage' => $formStatorApresLavage->createView(),
            'form' => $form->createView(),
            'items' => $listes,
            'listes_controles' => $controleIsolementRepository->findAll(),
        ]);
    }

    //sonde à bobinage
    #[Route('/sonde-bobinage/{id}', name: 'app_sonde_bobinage')]
    public function sonde(Parametre $parametre, Request $request, SondeBobinageRepository $sondeBobinageRepository, EntityManagerInterface $em): Response
    {
        //sonde bobinage
        $sondeBobinage = new SondeBobinage();
        $lsondeBobinage = new LSondeBobinage();

        if ($parametre->getSondeBobinage()) {
            $sondeBobinage = $parametre->getSondeBobinage()->getParametre()->getSondeBobinage();
        }

        $formSondeBobinage = $this->createForm(SondeBobinageType::class, $sondeBobinage);
        $formSondeBobinage->handleRequest($request);

        $form = $this->createForm(LSondeBobinageType::class, $lsondeBobinage);
        $form->handleRequest($request);


        $session = $request->getSession();
        $tables = $session->get('sondes', []);

        if ($formSondeBobinage->isSubmitted() && $form->isSubmitted()) {
            $choix = $request->get('bouton2');
            if ($choix == 'sonde_en_cours') {
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lsondeBobinage = new LSondeBobinage();
                    $lsondeBobinage->setLig($i);
                    $lsondeBobinage->setControle($item->getControle());
                    $lsondeBobinage->setCritere($item->getCritere());
                    $temp = $item->getTempCorrection();
                    $lsondeBobinage->setValeurRelevee($item->getValeurRelevee());
                    $lsondeBobinage->setValeur($item->getValeur());
                    $lsondeBobinage->setTempCorrection($temp);
                    $lsondeBobinage->setUnite($item->getUnite());
                    $lsondeBobinage->setType($item->getType());
                    $lsondeBobinage->setConformite($item->getConformite());
                    $lsondeBobinage->setSondeBobinage($sondeBobinage);
                    $em->persist($lsondeBobinage);
                }

                $parametre->setSondeBobinage($sondeBobinage);
                $sondeBobinage->setEtat(0);
                $sondeBobinageRepository->save($sondeBobinage, true);
                $session->clear();
                return $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
            } elseif ($choix == 'sonde_terminer') {
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lsondeBobinage = new LSondeBobinage();
                    $lsondeBobinage->setLig($i);
                    $lsondeBobinage->setControle($item->getControle());
                    $lsondeBobinage->setCritere($item->getCritere());
                    $temp = $item->getTempCorrection();
                    $lsondeBobinage->setValeurRelevee($item->getValeurRelevee());
                    $lsondeBobinage->setValeur($item->getValeur());
                    $lsondeBobinage->setTempCorrection($temp);
                    $lsondeBobinage->setUnite($item->getUnite());
                    $lsondeBobinage->setType($item->getType());
                    $lsondeBobinage->setConformite($item->getConformite());
                    $lsondeBobinage->setSondeBobinage($sondeBobinage);
                    $em->persist($lsondeBobinage);
                }

                $parametre->setSondeBobinage($sondeBobinage);
                $sondeBobinage->setEtat(1);
                $sondeBobinageRepository->save($sondeBobinage, true);
                $session->clear();
                return $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
            } elseif ($choix == 'ajouter') {
                $val = 0;
                foreach ($parametre->getMesureResistance()->getLMesureResistances() as $item) {
                    if ($item->getControle() == $lsondeBobinage->getControle() and $item->getType() == $lsondeBobinage->getType()) {
                        $val = $item->getValeur();
                    }
                }

                $lig = sizeof($tables) + 1;
                $lsondeBobinage->setLig($lig);
                $lsondeBobinage->setValeurRelevee($val);
                foreach ($tables as $i) {
                    if ($i->getType() == $lsondeBobinage->getType() and $i->getControle() == $lsondeBobinage->getControle()) {
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
                    }
                }

                if ($parametre->getSondeBobinage()) {
                    foreach ($parametre->getSondeBobinage()->getLSondeBobinages() as $j) {
                        if ($j->getType() == $lsondeBobinage->getType() and $j->getControle() == $lsondeBobinage->getControle()) {
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
                        }
                    }
                }
                $tables[$lig] = $lsondeBobinage;
                $session->set('sondes', $tables);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/sonde_bobinage.html.twig', [
            'parametre' => $parametre,
            'formSondeBobinage' => $formSondeBobinage->createView(),
            'form' => $form->createView(),
            'items' => $tables,
        ]);
    }

    ///Caractéristique à vide
    #[Route('/caracteristique/{id}', name: 'app_caracteristique')]
    public function caractéristique(Parametre $parametre, Request $request, SluggerInterface $slugger, AutreCaracteristiqueRepository $autreCaracteristiqueRepository, CaracteristiqueRepository $caracteristiqueRepository, EntityManagerInterface $em): Response
    {
        //Caractéristique à vide
        $caracteristique = new Caracteristique();
        $formCarateristique = $this->createForm(CaracteristiqueType::class, $caracteristique);
        $formCarateristique->handleRequest($request);

        if ($formCarateristique->isSubmitted() && $formCarateristique->isValid()) {
            $choix = $request->get('bouton3_1');
            if ($choix == 'ajouter') {
                $image = $formCarateristique->get('image')->getData();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('point_fonctionnement_vide'),
                            $newPhotoname
                        );
                    } catch (FileException $e) {
                    }

                    $caracteristique->setImage($newPhotoname);
                }
                $caracteristique->setParametre($parametre);
                $caracteristiqueRepository->save($caracteristique, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

        //autre caractéristique
        $autreCaracteristique = new AutreCaracteristique();
        if ($parametre->getAutreCaracteristique()) {
            $autreCaracteristique = $parametre->getAutreCaracteristique()->getParametre()->getAutreCaracteristique();
        }

        $formAutreCaracteristique = $this->createForm(AutreCarateristiqueType::class, $autreCaracteristique);
        $formAutreCaracteristique->handleRequest($request);
        if ($formAutreCaracteristique->isSubmitted() && $formAutreCaracteristique->isValid()) {
            $choix = $request->get('bouton3');
            if ($choix == 'carac_en_cours') {
                $parametre->setAutreCaracteristique($autreCaracteristique);
                $autreCaracteristique->setEtat(0);
                $autreCaracteristiqueRepository->save($autreCaracteristique, true);
                $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
            } elseif ($choix == 'carac_terminer') {
                $parametre->setAutreCaracteristique($autreCaracteristique);
                $autreCaracteristique->setEtat(1);
                $autreCaracteristiqueRepository->save($autreCaracteristique, true);
                $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
            }
        }


        return $this->render('essais_finaux/caracteristique_vite.html.twig', [
            'parametre' => $parametre,
            'formCarateristique' => $formCarateristique->createView(),
            'formAutreCaracteristique' => $formAutreCaracteristique->createView(),
        ]);
    }

    //point de fonctionnement
    #[Route('/autre-fonctionnement/{id}', name: 'app_fonctionnement')]
    public function fonctionnement(Parametre $parametre, Request $request, AutrePointFonctionnementRotorRepository $autrePointFonctionnementRotorRepository, PointFonctionnementRotorRepository $pointFonctionnementRotorRepository): Response
    {
        //autre point de fonctionnement rotor
        $autrePointFonctionnementRotor = new AutrePointFonctionnementRotor();
        if ($parametre->getAutrePointFonctionnementRotor()) {
            $autrePointFonctionnementRotor = $parametre->getAutrePointFonctionnementRotor()->getParametre()->getAutrePointFonctionnementRotor();
        }

        $formAutrePointFonctionnementRotor = $this->createForm(AutrePointFonctionnementRotorType::class, $autrePointFonctionnementRotor);
        $formAutrePointFonctionnementRotor->handleRequest($request);
        if ($formAutrePointFonctionnementRotor->isSubmitted() && $formAutrePointFonctionnementRotor->isValid()) {
            $choix = $request->get('bouton4');
            if ($choix == 'autre_en_cours') {
                $parametre->setAutrePointFonctionnementRotor($autrePointFonctionnementRotor);
                $autrePointFonctionnementRotor->setEtat(0);
                $autrePointFonctionnementRotorRepository->save($autrePointFonctionnementRotor, true);
                $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
            } elseif ($choix == 'autre_terminer') {
                $parametre->setAutrePointFonctionnementRotor($autrePointFonctionnementRotor);
                $autrePointFonctionnementRotor->setEtat(1);
                $autrePointFonctionnementRotorRepository->save($autrePointFonctionnementRotor, true);
                $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('essais_finaux/point_fonctionnement_rotor.html.twig', [
            'parametre' => $parametre,
            // 'formPointFonctionnementRotor' => $formPointFonctionnementRotor->createView(),
            'formAutrePointFonctionnementRotor' => $formAutrePointFonctionnementRotor->createView(),
        ]);
    }

    //appareil de mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_mesure_expertise_apres_lavage')]
    public function apparielMesure(Parametre $parametre, Request $request, AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository): Response
    {
        //la partie appareil de mesure
        $appareilMesureElectrique = new AppareilMesureElectrique();

        $formAppareilMesureElectrique = $this->createForm(AppareilMesureElectriqueType::class, $appareilMesureElectrique);
        $formAppareilMesureElectrique->handleRequest($request);
        $date = date('Y-m-d');
        if ($formAppareilMesureElectrique->isSubmitted() && $formAppareilMesureElectrique->isValid()) {
            $choix = $request->get('bouton5');
            if ($choix == 'ajouter') {
                $dateAppareil = $appareilMesureElectrique->getAppareil()->getDateValidite()->format('Y-m-d');
                if ($dateAppareil < $date) {
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : " . $dateAppareil);
                } else {
                    $appareilMesureElectrique->setParametre($parametre);
                    $appareilMesureElectriqueRepository->save($appareilMesureElectrique, true);
                    $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
                }
            }
        }

        return $this->render('expertise_electrique_apres_lavage/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareilMesureElectrique' => $formAppareilMesureElectrique->createView(),
        ]);
    }

    //constat electrique
    #[Route('/Constat/{id}', name: 'app_Constat_expertise_apres_lavage')]
    public function Constat(Parametre $parametre, Request $request, SluggerInterface $slugger, ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository): Response
    {
        //la partie constat electrique après lavage
        $constatElectriqueApresLavage = new ConstatElectriqueApresLavage();
        $formConstatElectriqueApresLavage = $this->createForm(ConstatElectriqueApresLavageType::class, $constatElectriqueApresLavage);
        $formConstatElectriqueApresLavage->handleRequest($request);
        if ($formConstatElectriqueApresLavage->isSubmitted() && $formConstatElectriqueApresLavage->isValid()) {
            $choix = $request->get('bouton6');
            if ($choix == 'ajouter') {
                $image = $formConstatElectriqueApresLavage->get('photo')->getData();
                if ($image) {
                    //récuperer la taille de l'image à inserrer
                    $size = $image->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return  $this->redirectToRoute('app_Constat_expertise_apres_lavage', ['id' => $parametre->getId()]);
                    
                    }else{
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_constat_electrique_apres_lavage'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }

                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_electrique_apres_lavage'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $constatElectriqueApresLavage->setPhoto($newPhotoname);
                    }
                }
                $constatElectriqueApresLavage->setParametre($parametre);
                $constatElectriqueApresLavageRepository->save($constatElectriqueApresLavage, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/constat.html.twig', [
            'parametre' => $parametre,
            'formConstatElectriqueApresLavage' => $formConstatElectriqueApresLavage->createView()
        ]);
    }
    //constat electrique
    #[Route('/edit-Constat/{id}/{idC}', name: 'app_Constat_expertise_apres_lavage_edit')]
    public function editConstat(Parametre $parametre, $idC, Request $request, SluggerInterface $slugger, ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository): Response
    {
        //la partie constat electrique après lavage
        //$constatElectriqueApresLavage = new ConstatElectriqueApresLavage();
        $constat = $constatElectriqueApresLavageRepository->findById($idC);
        $constatElectriqueApresLavage = $constat[0];
        $formConstatElectriqueApresLavage = $this->createForm(ConstatElectriqueApresLavageType::class, $constatElectriqueApresLavage);
        $formConstatElectriqueApresLavage->handleRequest($request);
        if ($formConstatElectriqueApresLavage->isSubmitted() && $formConstatElectriqueApresLavage->isValid()) {
            $choix = $request->get('bouton6');
            if ($choix == 'ajouter') {
                $image = $formConstatElectriqueApresLavage->get('photo')->getData();
                if ($image) {
                    //récuperer la taille de l'image à inserrer
                    $size = $image->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size < 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return  $this->redirectToRoute('app_Constat_expertise_apres_lavage', ['id' => $parametre->getId()]);
                    
                    }else{
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_constat_electrique_apres_lavage'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }

                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_electrique_apres_lavage'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $constatElectriqueApresLavage->setPhoto($newPhotoname);
                    }
                }
                $constatElectriqueApresLavage->setParametre($parametre);
                $constatElectriqueApresLavageRepository->save($constatElectriqueApresLavage, true);
                return $this->redirectToRoute('app_Constat_expertise_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/constat.html.twig', [
            'parametre' => $parametre,
            'constatElectriqueApresLavage' => $constatElectriqueApresLavage,
            'formConstatElectriqueApresLavage' => $formConstatElectriqueApresLavage->createView()
        ]);
    }

    //Supprimer carcatéristique
    #[Route('/caracteristique-delete/{id}', name: 'delete_caracteristique', methods: ['GET'])]
    public function deleteCaract(Caracteristique $caracteristique, CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        $id = $caracteristique->getParametre()->getId();
        if ($caracteristique) {
            $nom = $caracteristique->getImage();
            unlink($this->getParameter('point_fonctionnement_vide') . '/' . $nom);
            $caracteristiqueRepository->remove($caracteristique, true);
            return $this->redirectToRoute('app_caracteristique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_caracteristique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }


    //Supprimer point de fonctionnement
    #[Route('/point/{id}/fonctionnement', name: 'delete_point', methods: ['GET'])]
    public function deletePoint(PointFonctionnementRotor $pointFonctionnementRotor, PointFonctionnementRotorRepository $pointFonctionnementRotorRepository): Response
    {
        $id = $pointFonctionnementRotor->getParametre()->getId();
        if ($pointFonctionnementRotor)
        {
            $pointFonctionnementRotorRepository->remove($pointFonctionnementRotor, true);
            return $this->redirectToRoute('app_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui valide l'expertise
    #[Route('/validation/{id}', name: 'valider_expertise_electrique_apres_lavage', methods: ['GET'])]
    public function validation(AdminRepository $adminRepository, Parametre $parametre, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        if ($parametre) {
            $dossier = 'email/email.html.twig';
            $subject = "Expertise électrique après lavage";
            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "l'expertise électrique après lavage a été validée";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = " N° d'affaire : " . $parametre->getAffaire()->getNumAffaire();

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

            // Initialise la date actuelle avec le fuseau horaire de Paris
            $dateZone = new \DateTimeZone('Europe/Paris');
            $date = new \DateTime('now', $dateZone);
            // Récupère le nom d'utilisateur de l'opérateur actuellement connecté
            $operateur = $this->getUser();

            if(is_null($parametre->getSignature()))
            {
                $signature = new Signature();
                $signature->setParametre($parametre);
                $signature->setExpApresLavage(1);
                $signature->setDateExpApresLavage($date);
                $signature->setOperateurExpApresLavage($operateur);
                $entityManager->persist($signature);

            }else
            {
                $signature = $parametre->getSignature();
                $signature->setExpApresLavage(1);
                $signature->setDateExpApresLavage($date);
                $signature->setOperateurExpApresLavage($operateur);
                $entityManager->persist($signature);
            }
            //envoyer le mail
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email, $subject, $message, $dossier, $user, $cdp, $num_affaire);

            $parametre->setExpertiseElectiqueApresLavage(1);
            $entityManager->persist($parametre);
            $entityManager->flush();
            $this->addFlash("success", "L'expertise validée avec succès");
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui supprime constat
    #[Route('/constat/{id}/electrique', name: 'delete_constat_electrique_apres_lavage', methods: ['GET'])]
    public function deleteConstat(ConstatElectriqueApresLavage $constatElectriqueApresLavage, ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository): Response
    {
        $id = $constatElectriqueApresLavage->getParametre()->getId();
        if ($constatElectriqueApresLavage) {
            $nom = $constatElectriqueApresLavage->getPhoto();
            if ($constatElectriqueApresLavage->getPhoto()) {
                unlink($this->getParameter('images_constat_electrique_apres_lavage') . '/' . $nom);
            }
            $constatElectriqueApresLavageRepository->remove($constatElectriqueApresLavage, true);
            return $this->redirectToRoute('app_Constat_expertise_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_Constat_expertise_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //delete session tables mesures resistance
    #[Route('/stator-apres-session/{id}/{id2}', name: 'delete_stator_session')]
    public function supprimeSessionResistance($id, $id2, Request $request)
    {
        $session = $request->getSession();
        $listes = $session->get('stators', []);
        if (array_key_exists($id, $listes)) {
            unset($listes[$id]);
            $session->set('stators', $listes);
        }
        return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $id2]);
    }

    //delete tables mesures resistance
    #[Route('/stator-apres-lavage/{id}/{id2}', name: 'delete_stator_apres_session_lavage')]
    public function supprimeLResistance2(LStatorApresLavage $lstatorApresLavage, $id2, Request $request, LStatorApresLavageRepository $lstatorApresLavageRepository)
    {
        if ($lstatorApresLavage) {
            $lstatorApresLavageRepository->remove($lstatorApresLavage, true);
            return $this->redirectToRoute('app_stator_apres_lavage', ['id' => $id2]);
        }
    }


    //delete session tables sondes
    #[Route('/sonde-session/{id}/{id2}', name: 'delete_sonde_session')]
    public function supprimeSondeSession($id, $id2, Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('sondes', []);
        if (array_key_exists($id, $tables)) {
            unset($tables[$id]);
            $session->set('sondes', $tables);
        }
        return $this->redirectToRoute('app_sonde_bobinage', ['id' => $id2]);
    }

    //delete tables sondes
    #[Route('/sonde-apres-lavage/{id}/{id2}', name: 'delete_sonde_apres_session_lavage')]
    public function supprimeSondeS(LSondeBobinage $lsondeBobinage, $id2, Request $request, LSondeBobinageRepository $lsondeBobinageRepository)
    {
        if ($lsondeBobinage) {
            $lsondeBobinageRepository->remove($lsondeBobinage, true);
            return $this->redirectToRoute('app_sonde_bobinage', ['id' => $id2]);
        }
    }

    //delete mesure equirepartition
    #[Route('/mesu-equirep/{id}', name: 'app_eequirepartition_delete')]
    public function supEqui(Equirepartition $equirepartition, EquirepartitionRepository $equirepartitionRepository)
    {
        $id = $equirepartition->getParametre()->getId();
        if ($equirepartition) {
            $equirepartitionRepository->remove($equirepartition, true);
            return $this->redirectToRoute('app_eequirepartition_new', ['id' => $id]);
        }
    }

    //ajout de pond diode
    #[Route('/pont-diode/{id}', name: 'app_pont_diode_new')]
    public function diode(Parametre $parametre, Request $request, EntityManagerInterface $entityManager, PontDiodeRepository $pontDiodeRepository): Response
    {
        $pont = new PontDiode();
        $form = $this->createForm(PontDiodeType::class, $pont);
        $form->handleRequest($request);

        //créer un compteur pour le pole
        $nb = count($parametre->getPontDiodes());
        $count = 0;
        if ($nb == 0) {
            $count = 1;
        } else {
            $count = $nb + 1;
        }
        $diode = 'Diode ' . $count;

        if ($form->isSubmitted() && $form->isValid()) {
            $pont->setParametre($parametre);
            $entityManager->persist($pont);
            $entityManager->flush();
            return $this->redirectToRoute('app_pont_diode_new', ['id' => $parametre->getId()]);
        }
        return $this->render('expertise_electrique_apres_lavage/pont_diode.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView(),
            'diode' => $diode
        ]);
    }
    //modifier Pont de diodes
    #[Route('/edit-pont-diode/{id}/{idEq}', name: 'app_pont_diode_edit')]
    public function editDiode(Parametre $parametre, $idEq, Request $request, EntityManagerInterface $entityManager, PontDiodeRepository $pontDiodeRepository): Response
    {
        $item = $pontDiodeRepository->findById($idEq);
        $diode = $item[0];
        $form = $this->createForm(PontDiodeType::class, $diode);
        $form->handleRequest($request);
        $diode_libelle = $diode->getDiode();

        if ($form->isSubmitted() && $form->isValid()) {
            $diode->setParametre($parametre);
            $entityManager->persist($diode);
            $entityManager->flush();
            return $this->redirectToRoute('app_pont_diode_new', ['id' => $parametre->getId()]);
        }
        return $this->render('expertise_electrique_apres_lavage/pont_diode.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView(),
            'diode' => $diode_libelle
        ]);
    }

    //delete Pont de diodes
    #[Route('/diode-mesure_sup/{id}', name: 'app_pont_diode_delete')]
    public function supDidoe(PontDiode $pontDiode, PontDiodeRepository $pontDiodeRepository)
    {
        $id = $pontDiode->getParametre()->getId();
        if ($pontDiode) {
            $pontDiodeRepository->remove($pontDiode, true);
            return $this->redirectToRoute('app_pont_diode_new', ['id' => $id]);
        }
    }
}
