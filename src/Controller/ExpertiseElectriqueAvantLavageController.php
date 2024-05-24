<?php

namespace App\Controller;

use App\Entity\BoiteBorne;
use App\Entity\Photo;
use App\Entity\Images;
use App\Entity\Plaque;
use App\Entity\LPlaque;
use App\Entity\PressionBalais;
use App\Entity\PressionMasseBalais;
use App\Form\BoiteBorneType;
use App\Form\PhotoType;
use App\Form\PlaqueType;
use App\Entity\Parametre;
use App\Form\LPlaqueType;
use App\Entity\AutreControle;
use App\Entity\AppareilMesure;
use App\Form\PressionBalaisType;
use App\Form\PressionMasseBalaisType;
use App\Repository\BoiteBorneRepository;
use App\Repository\PressionBalaisRepository;
use App\Repository\PressionMasseBalaisRepository;
use App\Service\MailerService;
use App\Entity\MesureIsolement;
use App\Form\AutreControleType;
use App\Entity\ControleBobinage;
use App\Entity\LMesureIsolement;
use App\Entity\MesureResistance;
use App\Entity\MesureVibratoire;
use App\Form\AppareilMesureType;
use App\Entity\ConstatElectrique;
use App\Entity\LMesureResistance;
use App\Entity\LMesureVibratoire;
use App\Form\MesureIsolementType;
use App\Form\ControleBobinageType;
use App\Form\LMesureIsolementType;
use App\Form\MesureResistanceType;
use App\Form\MesureVibratoireType;
use App\Entity\PointFonctionnement;
use App\Form\ConstatElectriqueType;
use App\Form\LMesureResistanceType;
use App\Form\LmesureVibratoireType;
use App\Repository\AdminRepository;
use App\Repository\PhotoRepository;
use App\Repository\ImagesRepository;
use App\Repository\PlaqueRepository;
use Symfony\Component\Asset\Package;
use App\Form\PointFonctionnementType;
use App\Repository\LPlaqueRepository;
use App\Service\RedimensionneService;
use App\Entity\ControleVisuelElectrique;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ControleVisuelElectriqueType;
use App\Repository\AutreControleRepository;
use App\Repository\AppareilMesureRepository;
use App\Repository\MesureIsolementRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ControleBobinageRepository;
use App\Repository\LMesureIsolementRepository;
use App\Repository\MesureResistanceRepository;
use App\Repository\MesureVibratoireRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ConstatElectriqueRepository;
use App\Repository\ControleIsolementRepository;
use App\Repository\LMesureResistanceRepository;
use App\Repository\LMesureVibratoireRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PointFonctionnementRepository;
use App\Repository\ControleVisuelElectriqueRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/expertiseEAL')]
class ExpertiseElectriqueAvantLavageController extends AbstractController
{
    /** 
     * A- Dans cette partie nous allons mettre tout ce qui concerne le traitement 
     * de la partie controle Visuel.
     * 1- instancier un objet de type ControleVisuel
     * 2-Dans cette partie nous allons verifie si le controle Visuel est lié à un paramêtre
     * si oui on ajoute les données dans l'objet créer, si non on envoi un objet vide à notre formulaire.
     * 3- on crée un formulaire qui va prendre l'objet créer
     * 4- On rendre ici si on click sur le bouton en cours ou terminer
     * 5- on recupère le choix selon les deux actions sur le formulaire ( en cours et terminer)
     *  + si le choix est en cours : on ajout les données dans la base de donnée et met l'etat à 0
     * + si le choix est terminer : on ajout les données dans la base de donnée et on met l'etat à 1
     * 6 - envoyer les variables à la view twig
     * NB : c'est les mêmes étapes pour les autres aussi
     */

    public function __construct(Private RedimensionneService $redimensionneService, Private EntityManagerInterface $entityManager)
    {
        
    }

    #[Route('/electrique/avant/lavage/{id}', name: 'app_expertise_electrique_avant_lavage', methods: ['POST', 'GET'])]
    public function index(Parametre $parametre, Request $request, ConstatElectriqueRepository $constatElectriqueRepository, SluggerInterface $slugger,): Response
    {
        return $this->render('expertise_electrique_avant_lavage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    //creation de Contrôle visuel et recensement
    #[Route('/controle/visuel/recensement/{id}', name: 'app_controle_visuel_recensement')]
    public function controleVisuel(Parametre $parametre, Request $request, ControleVisuelElectriqueRepository $controleVisuelElectriqueRepository, SluggerInterface $slugger): Response
    {        //1 
        $controleVisuelElectrique = new ControleVisuelElectrique();
        //2
        if ($parametre->getControleVisuelElectrique()) {
            $controleVisuelElectrique = $parametre->getControleVisuelElectrique()->getParametre()->getControleVisuelElectrique();
        }

        //3
        $formControleVisuelElectique = $this->createForm(ControleVisuelElectriqueType::class, $controleVisuelElectrique);
        $formControleVisuelElectique->handleRequest($request);

        //4
        if ($formControleVisuelElectique->isSubmitted() && $formControleVisuelElectique->isValid()) {
            //5
            $choix = $request->get('bouton');
            if ($choix == 'controle_visuel_en_cours') {
                $image = $formControleVisuelElectique->get('photo')->getData();
                if ($image) {
                    $size = $image->getSize();
                    if ($size > 2 * 1024 * 1024) {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo");
                        return $this->redirectToRoute('app_controle_visuel_recensement', ['id' => $parametre->getId()]);
                    } else {

                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '' . uniqid() . '.' . $image->guessExtension();
                        //dd($newPhotoname);
                        try {
                            $image->move(
                                $this->getParameter('image_boite_borne'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $controleVisuelElectrique->setPhoto($newPhotoname);
                    }
                }
                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(0);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_controle_visuel_recensement', ['id' => $parametre->getId()]);

            } elseif ($choix == 'controle_visuel_terminer')
            {
                $image = $formControleVisuelElectique->get('photo')->getData();
                if ($image) {
                    $size = $image->getSize();
                    if ($size > 2 * 1024 * 1024) {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo");
                        return $this->redirectToRoute('app_controle_visuel_recensement', ['id' => $parametre->getId()]);
                    } else {

                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('image_boite_borne'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $controleVisuelElectrique->setPhoto($newPhotoname);
                    }
                }

                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(1);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_controle_visuel_recensement', ['id' => $parametre->getId()]);
            }
        }
        //fin du contrôle visuel

        return $this->render('expertise_electrique_avant_lavage/controle_visuel_recensement.html.twig', [
            'parametre' => $parametre,
            'formControleVisuelElectique' => $formControleVisuelElectique->createView(),
        ]);
    }

    //création de mesure d'isolement
    #[Route('/mesure/isolement/{id}', name: 'app_mesure_isolement', methods: ['POST', 'GET'])]
    public function mesureIso(Parametre $parametre, Request $request, MesureIsolementRepository $mesureIsolementRepository, EntityManagerInterface $em, ControleIsolementRepository $controleIsolementRepository): Response
    {
        //Mesure d'isolement
        $mesureIsolement = new MesureIsolement();
        $lmesureIsolement = new LMesureIsolement();
        $val = 0;
        if ($parametre->getMesureIsolement()) {
            $mesureIsolement = $parametre->getMesureIsolement()->getParametre()->getMesureIsolement();
            $val = 1;
        }
        $formMesureIsolement = $this->createForm(MesureIsolementType::class, $mesureIsolement);
        $form = $this->createForm(LMesureIsolementType::class, $lmesureIsolement);
        $formMesureIsolement->handleRequest($request);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tables = $session->get('mesures', []);

        if ($formMesureIsolement->isSubmitted() && $form->isSubmitted()) {
            $choix = $request->get('bouton7');
            if ($choix == 'mesure_isolement_en_cours') {
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolement();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $valeur = 0;
                    $temp = 0;
                    if (is_int($item->getValeur()))
                    {
                        $valeur = $item->getValeur();
                    }else{
                        $valeur =  number_format($item->getValeur(), 1, '.', '');
                    }

                    if (is_int($item->getTempCorrection()))
                    {
                        $temp = $item->getTempCorrection();
                    }else{
                        $temp =  number_format($item->getTempCorrection(), 1, '.', '');
                    }

                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setTempCorrection($temp);
                    $lmesureIsolement->setValeur($valeur);
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolement($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(0);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
            } elseif ($choix == 'mesure_isolement_terminer') {
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolement();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $valeur = 0;
                    $temp = 0;
                    if (is_int($item->getValeur()))
                    {
                        $valeur = $item->getValeur();
                    }else{
                        $valeur =  number_format($item->getValeur(), 1, '.', '');
                    }

                    if (is_int($item->getTempCorrection()))
                    {
                        $temp = $item->getTempCorrection();
                    }else{
                        $temp =  number_format($item->getTempCorrection(), 1, '.', '');
                    }

                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setTempCorrection($temp);
                    $lmesureIsolement->setValeur($valeur);
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolement($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(1);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
            } elseif ($choix == 'ajouter') {
                $lig = sizeof($tables) + 1;
                $lmesureIsolement->setLig($lig);
                foreach ($tables as $i) {
                    if ($i->getType() == $lmesureIsolement->getType() and $i->getControle() == $lmesureIsolement->getControle() and $i->getTension() == $lmesureIsolement->getTension()) {
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
                    }
                }
                if ($parametre->getMesureIsolement()) {
                    foreach ($parametre->getMesureIsolement()->getLMesureIsolements() as $j) {
                        if ($j->getType() == $lmesureIsolement->getType() and $j->getControle() == $lmesureIsolement->getControle() and $j->getTension() == $lmesureIsolement->getTension()) {
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
                        }
                    }
                }

                $tables[$lig] = $lmesureIsolement;
                $session->set('mesures', $tables);
            }
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/mesure_isolement.html.twig', [
            'parametre' => $parametre,
            'formMesureIsolement' => $formMesureIsolement->createView(),
            'form' => $form->createView(),
            'items' => $tables,
            'val' => $val,
            'listes_controles' => $controleIsolementRepository->findAll(),
        ]);
    }

    //création de mesure d'resistance
    #[Route('/mesure-resistance/{id}', name: 'app_mesure_resistance', methods: ['POST', 'GET'])]
    public function mesureResistance(Parametre $parametre, Request $request, MesureResistanceRepository $mesureResistanceRepository, EntityManagerInterface $em): Response
    {
        //Mesure de resistance
        $mesureResistance = new MesureResistance();
        $lmesureResistance = new LMesureResistance();
        if ($parametre->getMesureResistance()) {
            $mesureResistance = $parametre->getMesureResistance()->getParametre()->getMesureResistance();
        }

        $formMesureResistance = $this->createForm(MesureResistanceType::class, $mesureResistance);
        $formMesureResistance->handleRequest($request);
        $form = $this->createForm(LMesureResistanceType::class, $lmesureResistance);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tables = $session->get('resistances', []);


        if ($formMesureResistance->isSubmitted() && $form->isSubmitted()) {
            $choix = $request->get('bouton8');
            if ($choix == 'mesure_resistance_en_cours') {
                //  dd($choix);
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistance();

                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());

                    $temp = 0;
                    if (is_int($item->getTempCorrection()))
                    {
                        $temp = $item->getTempCorrection();
                    }else{
                        $temp =  number_format($item->getTempCorrection(), 1, '.', '');
                    }
                    $lmesureResistance->setTempCorrection($temp);
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureResistance($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(0);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
            } elseif ($choix == 'mesure_resistance_terminer') {
                $i = 0;
                foreach ($tables as $item) {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistance();

                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());

                    $temp = 0;
                    if (is_int($item->getTempCorrection()))
                    {
                        $temp = $item->getTempCorrection();
                    }else{
                        $temp =  number_format($item->getTempCorrection(), 1, '.', '');
                    }
                    $lmesureResistance->setTempCorrection($temp);
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureResistance($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(1);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
            } elseif ($choix == 'ajouter') {
                $lig = sizeof($tables) + 1;
                $lmesureResistance->setLig($lig);

                foreach ($tables as $i) {
                    if ($i->getType() == $lmesureResistance->getType() and $i->getControle() == $lmesureResistance->getControle()) {
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
                    }
                }

                if ($parametre->getMesureResistance()) {
                    foreach ($parametre->getMesureResistance()->getLMesureResistances() as $j) {
                        if ($j->getType() == $lmesureResistance->getType() and $j->getControle() == $lmesureResistance->getControle()) {
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
                        }
                    }
                }

                $tables[$lig] = $lmesureResistance;
                $session->set('resistances', $tables);
            }
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/mesure_resistance.html.twig', [
            'parametre' => $parametre,
            'formMesureResistance' => $formMesureResistance->createView(),
            'form' => $form->createView(),
            'items' => $tables,
        ]);
    }

    //création de point de fonctionnement
    #[Route('/point/fonctionnement/{id}', name: 'app_point_fonctionnement', methods: ['POST', 'GET'])]
    public function pointFonctionnement(Parametre $parametre, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        /** 
         * la partie point de fonctionnement
         * Initialiser la classe de point de fonctionnement
         */
        $pointFonctionnement = new PointFonctionnement();

        //Créer l'objet form du point de fonctionnement
        $formPointFonctionnement = $this->createForm(PointFonctionnementType::class, $pointFonctionnement);
        $formPointFonctionnement->handleRequest($request);
        //verifier si l'objet est valide et soumis
        if ($formPointFonctionnement->isSubmitted() && $formPointFonctionnement->isValid()) {
            $image = $formPointFonctionnement->get('image')->getData();
            if ($image) {
                //récuperer la taille de l'image à inserrer
                $size = $image->getSize();
                //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                if ($size > 2 * 1024 * 1024) {
                    $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                    return $this->redirectToRoute('app_point_fonctionnement', ['id' => $parametre->getId()]);
                } else {
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
                    //ajouter la réference de l'image dans la base de donnée sous forme de chaine de caréctère
                    $pointFonctionnement->setImage($newPhotoname);
                }
            }
            //lier le paramètre à point de fonctionnement
            $pointFonctionnement->setParametre($parametre);
            $em->persist($pointFonctionnement);
            $em->flush();
            //redirectionner après l'insertion dans la base
            return $this->redirectToRoute('app_point_fonctionnement', ['id' => $parametre->getId()]);
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/point_fonctionnement.html.twig', [
            'parametre' => $parametre,
            'formPointFonctionnement' => $formPointFonctionnement->createView(),
        ]);
    }

    //création de mesure vibratoire
    #[Route('/mesure/vibratoire/{id}', name: 'app_mesure_vibratoire', methods: ['POST', 'GET'])]
    public function mesureVibratoire(Parametre $parametre, EntityManagerInterface $em, Request $request, MesureVibratoireRepository $mesureVibratoireRepository): Response
    {
        //la partie du mesures vibratoires
        $mesureVibratoire = new MesureVibratoire();
        $lmesureVibratoire = new LMesureVibratoire();
        if ($parametre->getMesureVibratoire()) {
            $mesureVibratoire = $parametre->getMesureVibratoire()->getParametre()->getMesureVibratoire();
        }

        $formMesureVibratoire = $this->createForm(MesureVibratoireType::class, $mesureVibratoire);
        $formMesureVibratoire->handleRequest($request);

        $f = $this->createForm(LmesureVibratoireType::class, $lmesureVibratoire);
        $f->handleRequest($request);

        $session = $request->getSession();
        $items = $session->get('listes', []);

        if ($formMesureVibratoire->isSubmitted() && $formMesureVibratoire->isValid()) {
            $choix = $request->get('bouton2');
            if ($choix == 'mesure_vibratoire_en_cours') {
                $i = 0;
                foreach ($items as $item) {
                    $i = $i + 1;
                    $lmesureVibratoire = new LMesureVibratoire();
                    $lmesureVibratoire->setLig($i);
                    $lmesureVibratoire->setN30($item->getN30());
                    $lmesureVibratoire->setA30($item->getA30());
                    $lmesureVibratoire->setB30($item->getB30());
                    $lmesureVibratoire->setC30($item->getC30());
                    $lmesureVibratoire->setD30($item->getD30());
                    $lmesureVibratoire->setE30($item->getE30());
                    $lmesureVibratoire->setF30($item->getF30());
                    $lmesureVibratoire->setTitre($item->getTitre());
                    $lmesureVibratoire->setMesureVibratoire($mesureVibratoire);
                    $em->persist($lmesureVibratoire);
                }
                $parametre->setMesureVibratoire($mesureVibratoire);
                $mesureVibratoire->setEtat(0);
                $mesureVibratoireRepository->save($mesureVibratoire, true);
                $session->clear();
                $this->redirectToRoute('app_mesure_vibratoire', ['id' => $parametre->getId()]);
            } elseif ($choix == 'mesure_vibratoire_terminer') {
                $i = 0;
                foreach ($items as $item) {
                    $i = $i + 1;
                    $lmesureVibratoire = new LMesureVibratoire();
                    $lmesureVibratoire->setN30($item->getN30());
                    $lmesureVibratoire->setA30($item->getA30());
                    $lmesureVibratoire->setB30($item->getB30());
                    $lmesureVibratoire->setC30($item->getC30());
                    $lmesureVibratoire->setD30($item->getD30());
                    $lmesureVibratoire->setE30($item->getE30());
                    $lmesureVibratoire->setF30($item->getF30());
                    $lmesureVibratoire->setTitre($item->getTitre());
                    $lmesureVibratoire->setMesureVibratoire($mesureVibratoire);
                    $em->persist($lmesureVibratoire);
                }
                $parametre->setMesureVibratoire($mesureVibratoire);
                $mesureVibratoire->setEtat(1);
                $mesureVibratoireRepository->save($mesureVibratoire, true);
                $session->clear();
                $this->redirectToRoute('app_mesure_vibratoire', ['id' => $parametre->getId()]);
            } elseif ($choix == 'ajouter') {
                $lig = sizeof($items) + 1;
                $lmesureVibratoire->setLig($lig);
                $items[$lig] = $lmesureVibratoire;
                $session->set('listes', $items);
                // dd($items);
            }
        }


        //6
        return $this->render('expertise_electrique_avant_lavage/mesure_vibratoire.html.twig', [
            'parametre' => $parametre,
            'formMesureVibratoire' => $formMesureVibratoire->createView(),
            'f' => $f->createView(),
            'items' => $items
        ]);
    }

    //création de appareil de mesure
    #[Route('/appariel-mesure/{id}', name: 'app_appareil_mesure', methods: ['POST', 'GET'])]
    public function appareilMesure(Parametre $parametre, Request $request, AppareilMesureRepository $appareilMesureRepository): Response
    {
        //la partie appareil de mesure
        $appareilMesure = new AppareilMesure();

        $formAppareilMesure = $this->createForm(AppareilMesureType::class, $appareilMesure);
        $formAppareilMesure->handleRequest($request);
        $date = date('Y-m-d');
        if ($formAppareilMesure->isSubmitted() && $formAppareilMesure->isValid()) {
            $choix = $request->get('bouton6');
            if ($choix == 'ajouter') {
                $dateAppareil = $appareilMesure->getAppareil()->getDateValidite()->format('Y-m-d');
                //dd($dateAppareil);
                if ($dateAppareil < $date) {
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : " . $dateAppareil);
                } else {
                    $appareilMesure->setParametre($parametre);
                    $appareilMesure->setEtat(0);
                    $appareilMesureRepository->save($appareilMesure, true);
                    $this->redirectToRoute('app_appareil_mesure', ['id' => $parametre->getId()]);
                }
            }
        }
        //6
        return $this->render('expertise_electrique_avant_lavage/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareilMesure' => $formAppareilMesure->createView(),
        ]);
    }

    //création de controle de bobinage
    #[Route('/controle-bobinage/{id}', name: 'app_controle_bobinage', methods: ['POST', 'GET'])]
    public function controleBobinage(Parametre $parametre, Request $request, ControleBobinageRepository $controleBobinageRepository): Response
    {
        //la partie du controle de bobinage 
        $controleBobinage = new ControleBobinage();
        if ($parametre->getControleBobinage()) {
            $controleBobinage = $parametre->getControleBobinage()->getParametre()->getControleBobinage();
        }

        $formControleBobinage = $this->createForm(ControleBobinageType::class, $controleBobinage);
        $formControleBobinage->handleRequest($request);
        if ($formControleBobinage->isSubmitted() && $formControleBobinage->isValid()) {
            $choix = $request->get('bouton3');
            if ($choix == 'controle_bobinage_en_cours') {
                $parametre->setControleBobinage($controleBobinage);
                $controleBobinage->setEtat(0);
                $controleBobinageRepository->save($controleBobinage, true);
                $this->redirectToRoute('app_controle_bobinage', ['id' => $parametre->getId()]);
            } elseif ($choix = 'controle_bobinage_terminer') {
                $parametre->setControleBobinage($controleBobinage);
                $controleBobinage->setEtat(1);
                $controleBobinageRepository->save($controleBobinage, true);
                $this->redirectToRoute('app_controle_bobinage', ['id' => $parametre->getId()]);
            }
        }
        //6
        return $this->render('expertise_electrique_avant_lavage/controle_bobinage.html.twig', [
            'parametre' => $parametre,
            'formControleBobinage' => $formControleBobinage->createView(),
        ]);
    }

    //création d'autre controle
    #[Route('/autre-controle/{id}', name: 'app_autre_controle', methods: ['POST', 'GET'])]
    public function autreControle(Parametre $parametre, Request $request,
                                  EntityManagerInterface $entityManager,
                                  PressionBalaisRepository $pressionBalaisRepository,
                                  PressionMasseBalaisRepository $pressionMasseBalaisRepository,
                                  AutreControleRepository $autreControleRepository): Response
    {
        // Création de nouvelles instances pour les contrôles
        $autreControle = new AutreControle();
        $pression_balais = new PressionBalais();
        $pression_masse_balais = new PressionMasseBalais();

        // Création des formulaires pour les contrôles de pression des balais et masse des balais
        $formPb = $this->createForm(PressionBalaisType::class, $pression_balais);
        $formPmb = $this->createForm(PressionMasseBalaisType::class, $pression_masse_balais);

        // Si le paramètre a un autre contrôle associé, récupération de ce contrôle
        if ($parametre->getAutreControle()) {
            $autreControle = $parametre->getAutreControle()->getParametre()->getAutreControle();
        }

        // Création du formulaire pour l'autre contrôle
        $formAutreControle = $this->createForm(AutreControleType::class, $autreControle);
        // Traitement de la requête par le formulaire
        $formAutreControle->handleRequest($request);
        $formPb->handleRequest($request);
        $formPmb->handleRequest($request);

        // Si le formulaire pour l'autre contrôle est soumis et valide
        if ($formAutreControle->isSubmitted() && $formAutreControle->isValid()) {
            // Récupération du choix de l'utilisateur
            $choix = $request->get('bouton4');

            // Si l'utilisateur choisit "autre_controle_en_cours"
            if ($choix == 'autre_controle_en_cours') {
                // Association de l'autre contrôle au paramètre
                $parametre->setAutreControle($autreControle);
                // Mise à jour de l'état de l'autre contrôle
                $autreControle->setEtat(0);
                // Sauvegarde de l'autre contrôle dans le dépôt
                $autreControleRepository->save($autreControle, true);
                // Redirection vers la page "expertise électrique avant lavage"
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            // Si l'utilisateur choisit "autre_controle_terminer"
            elseif ($choix == 'autre_controle_terminer') {
                // Association de l'autre contrôle au paramètre
                $parametre->setAutreControle($autreControle);
                // Mise à jour de l'état de l'autre contrôle
                $autreControle->setEtat(1);
                // Sauvegarde de l'autre contrôle dans le dépôt
                $autreControleRepository->save($autreControle, true);
                // Redirection vers la page "expertise électrique avant lavage"
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }

        // si le formulaire envoyer par pression balais
        if ($formPb->isSubmitted() && $formPb->isValid())
        {
            $pression_balais->setParametre($parametre);
            $entityManager->persist($pression_balais);
            $entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $parametre->getId()]);
        }
        // si le formulaire envoyer par pression masse balais
        if ($formPmb->isSubmitted() && $formPmb->isValid())
        {
            $pression_masse_balais->setParametre($parametre);
            $entityManager->persist($pression_masse_balais);
            $entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $parametre->getId()]);
        }

        return $this->render('expertise_electrique_avant_lavage/autre_controle.html.twig', [
            'parametre' => $parametre,
            'formAutreControle' => $formAutreControle->createView(),
            'formPb' => $formPb->createView(),
            'formPmb' => $formPmb->createView(),
        ]);
    }

    //création des photos
    #[Route('/photos/{id}', name: 'app_photos', methods: ['POST', 'GET'])]
    public function photo(Parametre $parametre, Request $request, SluggerInterface $slugger, PhotoRepository $photoRepository,): Response
    {
        //la partie photo
        $photo = new Photo();

        $formPhoto = $this->createForm(PhotoType::class, $photo);
        $formPhoto->handleRequest($request);

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            if ($parametre->getPhoto()) {
                $photo = $parametre->getPhoto()->getParametre()->getPhoto();
            }
            $num = count($photo->getImages());
            $images = $formPhoto->get('images')->getData();
            foreach ($images as $image) {
                $num = $num + 1;

                $img = new Images();
                if ($image) {
                    //récuperer la taille de l'image à inserrer
                    $size = $image->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if ($size > 2 * 1024 * 1024) {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_photos', ['id' => $parametre->getId()]);
                    } else {
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('images_expertises'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_expertises'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $img->setLibelle($newPhotoname);
                        $img->setLig($num);
                        $photo->addImage($img);
                    }
                }
            }
            $parametre->setPhoto($photo);
            $photo->setEtat(1);
            $photoRepository->save($photo, true);
        }

        return $this->render('expertise_electrique_avant_lavage/photo.html.twig', [
            'parametre' => $parametre,
            'formPhoto' => $formPhoto->createView()
        ]);
    }

    //création des constats
    #[Route('/constat-electrique/{id}', name: 'app_constat_electrique', methods: ['POST', 'GET'])]
    public function constatElectrique(Parametre $parametre, Request $request, SluggerInterface $slugger, ConstatElectriqueRepository $constatElectriqueRepository): Response
    {
        //la partie constat electrique avant lavage
        $constatElectrique = new ConstatElectrique();

        $formConstatElectrique = $this->createForm(ConstatElectriqueType::class, $constatElectrique);
        $formConstatElectrique->handleRequest($request);
        if ($formConstatElectrique->isSubmitted() && $formConstatElectrique->isValid()) {
            $choix = $request->get('bouton10');
            if ($choix == 'ajouter') {
                $image = $formConstatElectrique->get('photo')->getData();

                if ($image) {
                    $size = $image->getSize();
                    if ($size > 2 * 1024 * 1024) {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo");
                        return $this->redirectToRoute('app_constat_electrique', ['id' => $parametre->getId()]);
                    } else {

                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '' . uniqid() . '.' . $image->guessExtension();
                        //dd($newPhotoname);
                        try {
                            $image->move(
                                $this->getParameter('images_constat_electrique'),
                                $newPhotoname
                            );
                        } catch (FileException $e) {
                        }
                        
                        $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_electrique'.'/'.$newPhotoname;
                        //$this->redimensionneService->resize($directory);
                        $constatElectrique->setPhoto($newPhotoname);
                    }
                }
                $constatElectrique->setParametre($parametre);
                $constatElectrique->setEtat(1);
                $constatElectriqueRepository->save($constatElectrique, true);
                $this->redirectToRoute('app_constat_electrique', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_electrique_avant_lavage/constat.html.twig', [
            'parametre' => $parametre,
            'formConstatElectrique' => $formConstatElectrique->createView(),
        ]);
    }

    //modifier un constat électrique
    #[Route('/edit-constat-electrique/{id}/{idC}', name: 'app_constat_electrique_edit', methods: ['POST', 'GET'])]
    public function editConstatElectrique(Parametre $parametre, $idC, Request $request, SluggerInterface $slugger, ConstatElectriqueRepository $constatElectriqueRepository): Response
    {
        //la partie constat electrique avant lavage
        //$constatElectrique = new ConstatElectrique();
        $constat_filtre_one = $constatElectriqueRepository->findById($idC);
        $constatElectrique = $constat_filtre_one[0];
        //dd($constat);
        $formConstatElectrique = $this->createForm(ConstatElectriqueType::class, $constatElectrique);
        $formConstatElectrique->handleRequest($request);
        if ($formConstatElectrique->isSubmitted() && $formConstatElectrique->isValid()) {
            $image = $formConstatElectrique->get('photo')->getData();
            if ($image) {
                $size = $image->getSize();
                if ($size > 2 * 1024 * 1024) {
                    $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo");
                    return $this->redirectToRoute('app_constat_electrique', ['id' => $parametre->getId()]);
                } else {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_constat_electrique'),
                            $newPhotoname
                        );
                    } catch (FileException $e) {}
                    $directory= $this->getParameter('kernel.project_dir').'/public/photo_constat_electrique'.'/'.$newPhotoname;
                    //$this->redimensionneService->resize($directory);
                    $constatElectrique->setPhoto($newPhotoname);
                } 
            }
            $constatElectrique->setParametre($parametre);
            $constatElectrique->setEtat(1);
            $constatElectriqueRepository->save($constatElectrique, true);

            return $this->redirectToRoute('app_constat_electrique', ['id' => $parametre->getId()]);
        }

        return $this->render('expertise_electrique_avant_lavage/constat.html.twig', [
            'parametre' => $parametre,
            'constatElectrique' => $constatElectrique,
            'formConstatElectrique' => $formConstatElectrique->createView(),
        ]);
    }

    //la fonction qui supprime une photo une fois ajouter
    #[Route('/photo/{id}', name: 'delete_photo', methods: ['GET'])]
    public function deletePhoto(Request $request, Images $images, ImagesRepository $imagesRepository): Response
    {
        $id = $images->getPhoto()->getParametre()->getId();
        if ($images) {
            $nom = $images->getLibelle();
            unlink($this->getParameter('images_expertises') . '/' . $nom);
            $imagesRepository->remove($images, true);
            return $this->redirectToRoute('app_photos', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_photos', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui supprime un point de fonctionnement
    #[Route('/fonctionnement/{id}/point', name: 'delete_point_fonctionnement', methods: ['GET'])]
    public function deletePointFonctionnement(Request $request, PointFonctionnement $pointFonctionnement, PointFonctionnementRepository $pointFonctionnementRepository): Response
    {
        $id = $pointFonctionnement->getParametre()->getId();
        if ($pointFonctionnement) {
            $nom = $pointFonctionnement->getImage();
            unlink($this->getParameter('point_fonctionnement_vide') . '/' . $nom);
            $pointFonctionnementRepository->remove($pointFonctionnement, true);
            return $this->redirectToRoute('app_point_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_point_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui supprime constat électrique
    #[Route('/constat/{id}/electrique', name: 'delete_constat_electrique', methods: ['GET'])]
    public function deleteConstat(ConstatElectrique $constatElectrique, ConstatElectriqueRepository $constatElectriqueRepository): Response
    {
        $id = $constatElectrique->getParametre()->getId();
        if ($constatElectrique) {
            $nom = $constatElectrique->getPhoto();
            if ($nom != null) {
                unlink($this->getParameter('images_constat_electrique') . '/' . $nom);
            }
            $constatElectriqueRepository->remove($constatElectrique, true);
            return $this->redirectToRoute('app_constat_electrique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_constat_electrique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui valide l'expertise
    #[Route('/validation/{id}', name: 'valider_expertise_electrique_avant_lavage', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager, MailerService $mailerService, AdminRepository $adminRepository): Response
    {
        if ($parametre) {

            $dossier = 'email/email.html.twig';
            $subject = "Expertise électrique avant lavage";
            $cdp1 = $parametre->getAffaire()->getSuiviPar()->getNom() . " "
                . $parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "L'expertise électrique avant lavage a été validée";
            $user = $this->getUser()->getNom() . " " . $this->getUser()->getPrenom();
            $num_affaire = "N° d'affaire : " . $parametre->getAffaire()->getNumAffaire();

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
            $email2 = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $mailerService->sendEmail($email2, $subject, $message, $dossier, $user, $cdp1, $num_affaire);

            $parametre->setExpertiseElectiqueAvantLavage(1);
            $entityManager->persist($parametre);
            $entityManager->flush();

            $this->addFlash("success", "L'expertise validée avec succès");
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    //delete session tables mesures isolement
    #[Route('/delete/{id}/{paramID}', name: 'delete_mesure')]
    public function supprimeSession($id, $paramID, Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('mesures', []);
        if (array_key_exists($id, $tables)) {
            unset($tables[$id]);
            $session->set('mesures', $tables);
        }
        return $this->redirectToRoute('app_mesure_isolement', ['id' => $paramID]);
    }

    //suppression session dans la table mesure vibratoire
    #[Route('/delete-vibratoire/{id}/{paramID}', name: 'delete_vibratoire')]
    public function supprimeSessionMesure($id, $paramID, Request $request)
    {
        $session = $request->getSession();
        $items = $session->get('listes', []);
        if (array_key_exists($id, $items)) {
            unset($items[$id]);
            $session->set('listes', $items);
        }
        return $this->redirectToRoute('app_mesure_vibratoire', ['id' => $paramID]);
    }

    //delete session tables mesures resistance
    #[Route('/delete-lmesure-session-resistance/{id}/{id2}', name: 'delete_lmesure_resistance_session')]
    public function supprimeSessionResistance($id, $id2, Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('resistances', []);
        if (array_key_exists($id, $tables)) {
            unset($tables[$id]);
            $session->set('resistances', $tables);
        }
        return $this->redirectToRoute('app_mesure_resistance', ['id' => $id2]);
    }

    //delete tables mesures resistance
    #[Route('/delete-lmesure-resistance/{id}/{id2}', name: 'delete_lmesure_resistance')]
    public function supprimeLResistance(LMesureResistance $lMesureResistance, $id2, Request $request, LMesureResistanceRepository $lMesureResistanceRepository)
    {

        if ($lMesureResistance) {
            $lMesureResistanceRepository->remove($lMesureResistance, true);
            return $this->redirectToRoute('app_mesure_resistance', ['id' => $id2]);
        }
    }

    //delete session tables mesures isolement
    #[Route('/delete-lmesure-session-isolement/{id}/{id2}', name: 'delete_lmesure_isolement_session')]
    public function supprimeSessionIsolemenet($id, $id2, Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('mesures', []);
        if (array_key_exists($id, $tables)) {
            unset($tables[$id]);
            $session->set('mesures', $tables);
        }
        return $this->redirectToRoute('app_mesure_isolement', ['id' => $id2]);
    }

    //delete tables mesures isolement
    #[Route('/delete-lmesure-isolement/{id}/{id2}', name: 'delete_lmesure_isolement')]
    public function supprimeLIsolement(LMesureIsolement $lmesureIsolement, $id2, Request $request, LMesureIsolementRepository $lmesureIsolementRepository)
    {

        if ($lmesureIsolement) {
            $lmesureIsolementRepository->remove($lmesureIsolement, true);
            return $this->redirectToRoute('app_mesure_isolement', ['id' => $id2]);
        }
    }

    //delete tables lmesure vibratoire
    #[Route('/delete-lmesure-vibratoire/{id}/{id2}', name: 'delete_lmesure_vibratoire')]
    public function supprimeLVibration(LMesureVibratoire $lMesureVibratoire, $id2, Request $request, LMesureVibratoireRepository $lMesureVibratoireRepository)
    {
        if ($lMesureVibratoire) {
            $lMesureVibratoireRepository->remove($lMesureVibratoire, true);
            return $this->redirectToRoute('app_mesure_vibratoire', ['id' => $id2]);
        }
    }

    //plaque signalétique et révision 
    #[Route('/plaque/{id}/add-photo', name: 'app_photo_plaque')]
    public function plauqe(Parametre $parametre, PlaqueRepository $plaqueRepository, Request $request, SluggerInterface $slugger, LPlaqueRepository $lPlaqueRepository)
    {
        $plaque = new Plaque();
        $formPlaque = $this->createForm(PlaqueType::class, $plaque);
        $formPlaque->handleRequest($request);

        $lplaque = new LPlaque();

        if ($parametre->getLplaque()) {
            $lplaque = $parametre->getLplaque()->getParametre()->getLplaque();
        }

        $form = $this->createForm(LPlaqueType::class, $lplaque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametre->setLplaque($lplaque);
            $lPlaqueRepository->save($lplaque, true);
            return $this->redirectToRoute('app_photo_plaque', ['id' => $parametre->getId()]);
        }

        $count = count($parametre->getPlaques());
        if ($formPlaque->isSubmitted() && $formPlaque->isValid()) {
            $trouve = false;
            if ($count == 3) {
                $trouve = true;
            }

            if ($trouve == false) {
                $photo = $formPlaque->get('photo')->getData();
                if ($photo) {
                    $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                    try {
                        $photo->move(
                            $this->getParameter('image_plaque'),
                            $newPhotoname
                        );
                    } catch (FileException $e) {
                    }
                    $directory= $this->getParameter('kernel.project_dir').'/public/photo_plaque'.'/'.$newPhotoname;
                    //$this->redimensionneService->resize($directory);
                    $plaque->setPhoto($newPhotoname);
                }
 
                $plaque->setParametre($parametre);
                $plaqueRepository->save($plaque, true);
                return $this->redirectToRoute('app_photo_plaque', ['id' => $parametre->getId()]);
            } else {

                $this->addFlash("message", "Oups ! vous pouvez ajouter que trois photos pour les plaques");
                return $this->redirectToRoute('app_photo_plaque', ['id' => $parametre->getId()]);
            }
        }
        return $this->render('expertise_electrique_avant_lavage/plaque.html.twig', [
            'parametre' => $parametre,
            'formPlaque' => $formPlaque->createView(),
            'form' => $form->createView()

        ]);
    }

    //la fonction qui supprime les plaques
    #[Route('/plaque-supprimer/{id}', name: 'app_delete_plaquexxxx', methods: ['GET'])]
    public function deletePlaque(Plaque $plaque, PlaqueRepository $plaqueRepository): Response
    {
        $id = $plaque->getParametre()->getId();
        if ($plaque) {
            $nom = $plaque->getPhoto();
            unlink($this->getParameter('image_plaque') . '/' . $nom);
            $plaqueRepository->remove($plaque, true);
            return $this->redirectToRoute('app_photo_plaque', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_photo_plaque', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //ajout de la boite à borne
    #[Route('/boite-borne/{id}', name: 'app_boite_borne', methods: ['GET', 'POST'])]
    public function boiteBorne(Parametre $parametre,Request $request, BoiteBorneRepository $boiteBorneRepository,EntityManagerInterface $entityManager ,SluggerInterface $slugger)
    {
        $boiteborne = new BoiteBorne();
        $form = $this->createForm(BoiteBorneType::class, $boiteborne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $image = $form->get('libelle')->getData();

            if ($image) {
                $size = $image->getSize();
                if ($size > 2 * 1024 * 1024) {
                    $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo");
                    return $this->redirectToRoute('app_constat_electrique', ['id' => $parametre->getId()]);
                } else {

                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '' . uniqid() . '.' . $image->guessExtension();
                    //dd($newPhotoname);
                    try {
                        $image->move(
                            $this->getParameter('image_boite_borne'),
                            $newPhotoname
                        );
                    } catch (FileException $e) {
                    }
                    $boiteborne->setLibelle($newPhotoname);
                }
            }
            $boiteborne->setParametre($parametre);
            $entityManager->persist($boiteborne);
            $entityManager->flush();
            $this->addFlash('success', 'La boité ajouter avec succès');
            return $this->redirectToRoute('app_boite_borne', ['id' => $parametre->getId()]);
        }

        return $this->renderForm('expertise_electrique_avant_lavage/boite_borne.html.twig', [
            'form' => $form,
            'boite_borne' => $boiteborne,
            'parametre' => $parametre
        ]);
    }

    //la fonction qui supprime la boite à borne
    #[Route('/boite-borne/{id}/supprimer', name: 'app_delete_boite_borne', methods: ['GET', 'POST'])]
    public function deleteBoite(BoiteBorne $boiteBorne, BoiteBorneRepository $boiteBorneRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $boiteBorne->getParametre()->getId();
        if ($boiteBorne) {
            $nom = $boiteBorne->getLibelle();
            unlink($this->getParameter('image_boite_borne') . '/' . $nom);
            $entityManager->remove($boiteBorne);
            $entityManager->flush();
            $this->addFlash('error', 'La boité supprimé avec succès');
            return $this->redirectToRoute('app_boite_borne', ['id' => $id], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_boite_borne', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction qui supprime les les pression masses et balais de masses
    #[Route('/presssion-delete/{id}', name: 'app_pression_delete', methods: ['GET'])]
    public function deletePression($id,Request $request, PressionBalaisRepository $pressionBalaisRepository, PressionMasseBalaisRepository $pressionMasseBalaisRepository): Response
    {
        // Récupérer le paramètre 'name' de la requête
        $name = $request->query->get('name');
        if ($name == 'balais')
        {
            $resultat = $pressionBalaisRepository->findById($id);
            $item = $resultat[0];
            $idP = $item->getParametre()->getId();
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $idP]);
        }elseif ($name == 'balais_masse')
        {
            $resultat = $pressionMasseBalaisRepository->findById($id);
            $item = $resultat[0];
            $idP = $item->getParametre()->getId();
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $idP]);
        }
    }

    //modifiaction de la pression balais
    #[Route('/edit-pression-balais/{id}', name: 'app_edit_pression_balais', methods: ['POST', 'GET'])]
    public function editPressionBalais(PressionBalais $pressionBalais, Request $request, PressionBalaisRepository $pressionBalaisRepository, PressionMasseBalaisRepository $pressionMasseBalaisRepository,): Response
    {

        // Création des formulaires pour les contrôles de pression des balais et masse des balais
        $form = $this->createForm(PressionBalaisType::class, $pressionBalais);
        $form->handleRequest($request);

        // Récupérer le paramètre 'name' de la requête
        $name = $request->query->get('name');

        // si le formulaire envoyer par pression balais
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($pressionBalais);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $pressionBalais->getParametre()->getId()]);
        }

        return $this->render('expertise_electrique_avant_lavage/edit_pression.html.twig', [
            'form' => $form->createView(),
            'parametre' => $pressionBalais->getParametre()
        ]);
    }


    //modifiaction de la pression balais
    #[Route('/edit-pression-masse/{id}', name: 'app_edit_pression_balais_masse', methods: ['POST', 'GET'])]
    public function editPressionMasseBalais(PressionMasseBalais $pressionMasseBalais, Request $request, PressionMasseBalaisRepository $pressionMasseBalaisRepository,): Response
    {

        // Création des formulaires pour les contrôles de pression des balais et masse des balais
        $form = $this->createForm(PressionMasseBalaisType::class, $pressionMasseBalais);
        $form->handleRequest($request);

        // Récupérer le paramètre 'name' de la requête
        $name = $request->query->get('name');

        // si le formulaire envoyer par pression balais
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($pressionMasseBalais);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_autre_controle', ['id' => $pressionMasseBalais->getParametre()->getId()]);
        }

        return $this->render('expertise_electrique_avant_lavage/edit_pression.html.twig', [
            'form' => $form->createView(),
            'parametre' => $pressionMasseBalais->getParametre()
        ]);
    }


}
