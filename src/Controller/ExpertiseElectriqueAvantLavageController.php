<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Images;
use App\Entity\Plaque;
use App\Entity\LPlaque;
use App\Form\PhotoType;
use App\Form\PlaqueType;
use App\Entity\Parametre;
use App\Form\LPlaqueType;
use App\Entity\AutreControle;
use App\Entity\AppareilMesure;
use App\Entity\MesureIsolement;
use App\Form\AutreControleType;
use App\Entity\ControleBobinage;
use App\Entity\LMesureIsolement;
use App\Entity\MesureResistance;
use App\Entity\MesureVibratoire;
use App\Form\AppareilMesureType;
use App\Entity\ConstatElectrique;
use App\Entity\LMesureResistance;
use App\Form\MesureIsolementType;
use Symfony\Component\Mime\Email;
use App\Form\ControleBobinageType;
use App\Form\LMesureIsolementType;
use App\Form\MesureResistanceType;
use App\Form\MesureVibratoireType;
use App\Entity\PointFonctionnement;
use App\Form\ConstatElectriqueType;
use App\Form\LMesureResistanceType;
use App\Repository\PhotoRepository;
use App\Repository\ImagesRepository;
use App\Repository\PlaqueRepository;
use Symfony\Component\Mailer\Mailer;
use App\Form\PointFonctionnementType;
use App\Repository\LPlaqueRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Mailer\Transport;
use App\Entity\ControleVisuelElectrique;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ControleVisuelElectriqueType;
use App\Repository\AutreControleRepository;
use App\Repository\AppareilMesureRepository;
use App\Repository\MesureIsolementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\ControleBobinageRepository;
use App\Repository\LMesureIsolementRepository;
use App\Repository\MesureResistanceRepository;
use App\Repository\MesureVibratoireRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ConstatElectriqueRepository;
use App\Repository\LMesureResistanceRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PointFonctionnementRepository;
use App\Repository\ControleVisuelElectriqueRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/electrique/avant/lavage/{id}', name: 'app_expertise_electrique_avant_lavage', methods: ['POST', 'GET'])]
    public function index(Parametre $parametre,Request $request,ConstatElectriqueRepository $constatElectriqueRepository,SluggerInterface $slugger,): Response
    {

        return $this->render('expertise_electrique_avant_lavage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    //creation de controle visuel et recensement
    #[Route('/controle/visuel/recensement/{id}', name: 'app_controle_visuel_recensement')]
    public function controleVisuel(Parametre $parametre, Request $request, ControleVisuelElectriqueRepository $controleVisuelElectriqueRepository): Response
    {        //1 
        $controleVisuelElectrique = new ControleVisuelElectrique();
        //2
       if($parametre->getControleVisuelElectrique())
        {
            $controleVisuelElectrique = $parametre->getControleVisuelElectrique()->getParametre()->getControleVisuelElectrique();
        }

       //3
       $formControleVisuelElectique = $this->createForm(ControleVisuelElectriqueType::class, $controleVisuelElectrique);
       $formControleVisuelElectique->handleRequest($request);

        //4
        if($formControleVisuelElectique->isSubmitted() && $formControleVisuelElectique->isValid())
        {   //5
            $choix = $request->get('bouton');
            if($choix == 'controle_visuel_en_cours')
            {
                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(0);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_controle_visuel_recensement', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_visuel_terminer')
            {
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
    public function mesureIso(Parametre $parametre,Request $request,MesureIsolementRepository $mesureIsolementRepository,EntityManagerInterface $em): Response
    {
        //Mesure d'isolement
        $mesureIsolement = new MesureIsolement();
        $lmesureIsolement = new LMesureIsolement();
        $val = 0;
        if($parametre->getMesureIsolement()){
            $mesureIsolement = $parametre->getMesureIsolement()->getParametre()->getMesureIsolement();
            $val = 1;
        }
        $formMesureIsolement = $this->createForm(MesureIsolementType::class, $mesureIsolement);
        $form = $this->createForm(LMesureIsolementType::class, $lmesureIsolement);
        $formMesureIsolement->handleRequest($request);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tables = $session->get('mesures', []);

        if($formMesureIsolement->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton7');
            if($choix == 'mesure_isolement_en_cours')
            {
                $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolement();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolement($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(0);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_isolement_terminer')
            {
                $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolement();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolement($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(1);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                $this->redirectToRoute('app_mesure_isolement', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'ajouter')
            {
                $lig = sizeof($tables)+1;
                $lmesureIsolement->setLig($lig);
                $tables[$lig] = $lmesureIsolement;
                $session->set('mesures', $tables);
            }
        } 

        //6
        return $this->render('expertise_electrique_avant_lavage/mesure_isolement.html.twig', [
            'parametre' => $parametre,
            'formMesureIsolement' => $formMesureIsolement->createView(),
            'form'=>$form->createView(),
            'items' => $tables,
            'val' => $val
        ]);
    }

   //création de mesure d'resistance
   #[Route('/mesure-resistance/{id}', name: 'app_mesure_resistance', methods: ['POST','GET'])]
   public function mesureResistance(Parametre $parametre,Request $request,MesureResistanceRepository $mesureResistanceRepository,EntityManagerInterface $em): Response
   {
        //Mesure de resistance
        $mesureResistance = new MesureResistance();
        $lmesureResistance = new LMesureResistance();
        if($parametre->getMesureResistance()){
            $mesureResistance = $parametre->getMesureResistance()->getParametre()->getMesureResistance();
        }

        $formMesureResistance = $this->createForm(MesureResistanceType::class, $mesureResistance);
        $formMesureResistance->handleRequest($request);
        $form = $this->createForm(LMesureResistanceType::class, $lmesureResistance);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tables = $session->get('resistances', []);


        if($formMesureResistance->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton8');
            if($choix == 'mesure_resistance_en_cours')
            {
              //  dd($choix);
                $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistance();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureResistance($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(0);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_resistance_terminer')
            {
                 $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistance();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureResistance($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(1);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                $this->redirectToRoute('app_mesure_resistance', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'ajouter')
            {
                $lig = sizeof($tables)+1;
                $lmesureResistance->setLig($lig);
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
    public function pointFonctionnement(Parametre $parametre,Request $request,EntityManagerInterface $em): Response
    {
            //la partie point de fonctionnement
        $pointFonctionnement = new PointFonctionnement();

        $formPointFonctionnement = $this->createForm(PointFonctionnementType::class, $pointFonctionnement);
        $formPointFonctionnement->handleRequest($request);
        if($formPointFonctionnement->isSubmitted() && $formPointFonctionnement->isValid())
        {
            $choix = $request->get('bouton9');
            if($choix == 'ajouter')
            {
                //récuperer le fichier importer 
                $file = $formPointFonctionnement->get('observation')->getData();

                //charger le fichier et flirer à dans le fichier
                $fichier = IOFactory::load($file->getPathname());

                //recuperer le contenu dans du fichier et affichier en tableau de chaine de caractère
                $donnees = $fichier->getActiveSheet()->toArray();

                //parcourir le tableau pour inserer dans la base de donnée
                foreach($donnees as $item)
                {
                    //vérifier s'il y'a une ligne vide dans la base 
                    if(!empty(array_filter($item)))
                    {
                        //initialiser la classe pour chaque ligne
                        $pointFonctionnement = new PointFonctionnement();

                        //inserer les données dans la base pour chaque ligne
                        $pointFonctionnement->setT(strval($item[0]));
                        $pointFonctionnement->setU(strval($item[1]));
                        $pointFonctionnement->setI1(strval($item[2]));
                        $pointFonctionnement->setI2(strval($item[3]));
                        $pointFonctionnement->setI3(strval($item[4]));
                        $pointFonctionnement->setP(strval($item[5]));
                        $pointFonctionnement->setQ(strval($item[6]));
                        $pointFonctionnement->setCos(strval($item[7]));
                        $pointFonctionnement->setN(strval($item[8]));
                        $pointFonctionnement->setI(strval($item[9]));
                        $pointFonctionnement->setTamb(strval($item[10]));
                        $pointFonctionnement->setCa(strval($item[11]));
                        $pointFonctionnement->setCoa(strval($item[12]));
                        $pointFonctionnement->setObservation($item[13]);
                        $pointFonctionnement->setParametre($parametre);
                        
                        $em->persist($pointFonctionnement);
                    }
                }
                $em->flush();
                return $this->redirectToRoute('app_point_fonctionnement', ['id' => $parametre->getId()]);
            }
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/point_fonctionnement.html.twig', [
            'parametre' => $parametre,
            'formPointFonctionnement' => $formPointFonctionnement->createView(),
        ]);
    }

    //création de mesure vibratoire
    #[Route('/mesure/vibratoire/{id}', name: 'app_mesure_vibratoire', methods: ['POST', 'GET'])]
    public function mesureVibratoire(Parametre $parametre,Request $request,MesureVibratoireRepository $mesureVibratoireRepository): Response
    {
         
        //la partie du mesures vibratoires
        $mesureVibratoire = new MesureVibratoire();
        if($parametre->getMesureVibratoire()){
            $mesureVibratoire = $parametre->getMesureVibratoire()->getParametre()->getMesureVibratoire();
        }

        $formMesureVibratoire = $this->createForm(MesureVibratoireType::class, $mesureVibratoire);
        $formMesureVibratoire->handleRequest($request);
        if($formMesureVibratoire->isSubmitted() && $formMesureVibratoire->isValid())
        {
            $choix = $request->get('bouton2');
            if($choix == 'mesure_vibratoire_en_cours')
            {
                $parametre->setMesureVibratoire($mesureVibratoire);
                $mesureVibratoire->setEtat(0);
                $mesureVibratoireRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire', ['id' => $parametre->getId()]);

            }
            elseif($choix == 'mesure_vibratoire_terminer')
            {
                $parametre->setMesureVibratoire($mesureVibratoire);
                $mesureVibratoire->setEtat(1);
                $mesureVibratoireRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire', ['id' => $parametre->getId()]);
            }
        }

          
         //6
        return $this->render('expertise_electrique_avant_lavage/mesure_vibratoire.html.twig', [
             'parametre' => $parametre,
             'formMesureVibratoire'=> $formMesureVibratoire->createView(),
         ]);
    }

    //création de appareil de mesure
    #[Route('/appariel-mesure/{id}', name: 'app_appareil_mesure', methods: ['POST', 'GET'])]
    public function appareilMesure(Parametre $parametre,Request $request,AppareilMesureRepository $appareilMesureRepository): Response
    {
        //la partie appareil de mesure
        $appareilMesure = new AppareilMesure();

        $formAppareilMesure = $this->createForm(AppareilMesureType::class, $appareilMesure);
        $formAppareilMesure->handleRequest($request);
        $date = date('Y-m-d');
        if($formAppareilMesure->isSubmitted() && $formAppareilMesure->isValid())
        {
            $choix = $request->get('bouton6');
            if($choix == 'ajouter')
            {
                $dateAppareil = $appareilMesure->getAppareil()->getDateValidite()->format('Y-m-d');
                if($dateAppareil < $date){
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : ".$dateAppareil);
                }else{
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
    public function controleBobinage(Parametre $parametre,Request $request,ControleBobinageRepository $controleBobinageRepository): Response
    {
        //la partie du controle de bobinage 
        $controleBobinage = new ControleBobinage();
        if ($parametre->getControleBobinage())
        {   
            $controleBobinage = $parametre->getControleBobinage()->getParametre()->getControleBobinage();
        }

        $formControleBobinage = $this->createForm(ControleBobinageType::class, $controleBobinage);
        $formControleBobinage->handleRequest($request);
        if($formControleBobinage->isSubmitted() && $formControleBobinage->isValid())
        {
            $choix = $request->get('bouton3');
            if ($choix =='controle_bobinage_en_cours')
            {
                $parametre->setControleBobinage($controleBobinage);
                $controleBobinage->setEtat(0);
                $controleBobinageRepository->save($controleBobinage, true);
                $this->redirectToRoute('app_controle_bobinage', ['id' => $parametre->getId()]);
            }
            elseif($choix = 'controle_bobinage_terminer')
            {
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
    public function autreControle(Parametre $parametre,Request $request,AutreControleRepository $autreControleRepository): Response
    {
        //la partie autre controle balais et balais de masse
        $autreControle = new AutreControle();
        if($parametre->getAutreControle())
        {
            $autreControle = $parametre->getAutreControle()->getParametre()->getAutreControle();
        }

        $formAutreControle = $this->createForm(AutreControleType::class, $autreControle);
        $formAutreControle->handleRequest($request); 
        if($formAutreControle->isSubmitted() && $formAutreControle->isValid())
        {
            $choix = $request->get('bouton4');
            if($choix == 'autre_controle_en_cours')
            {
                $parametre->setAutreControle($autreControle);
                $autreControle->setEtat(0);
                $autreControleRepository->save($autreControle, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);


            }
            elseif($choix == 'autre_controle_terminer')
            {
                $parametre->setAutreControle($autreControle);
                $autreControle->setEtat(1);
                $autreControleRepository->save($autreControle, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        } 

        return $this->render('expertise_electrique_avant_lavage/autre_controle.html.twig', [
            'parametre' => $parametre,
            'formAutreControle' => $formAutreControle->createView(),
        ]);
    }

    //création des photos
    #[Route('/photos/{id}', name: 'app_photos', methods: ['POST', 'GET'])]
    public function photo(Parametre $parametre,Request $request,SluggerInterface $slugger, PhotoRepository $photoRepository,): Response
    {
        //la partie photo
        $photo = new Photo();

        $formPhoto = $this->createForm(PhotoType::class, $photo);
        $formPhoto->handleRequest($request);

        if($formPhoto->isSubmitted() && $formPhoto->isValid())
        {
        $choix = $request->get('bouton5');
        if($choix == 'photo_en_cours')
        {
            //dd($formPhoto->get('images')->getData());
            $images = $formPhoto->get('images')->getData();

            foreach($images as $image)
            {
                $img = new Images();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_expertises'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                if($parametre->getPhoto()){
                    $photo = $parametre->getPhoto()->getParametre()->getPhoto();
                }
                $img->setLibelle($newPhotoname);
                $photo->addImage($img);
            }
            
            $parametre->setPhoto($photo);
            $photo->setEtat(0);
            $photoRepository->save($photo, true);
        }
        elseif($choix == 'photo_terminer')
        {
            $images = $formPhoto->get('images')->getData();

            foreach($images as $image)
            {
                $img = new Images();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_expertises'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                
                if($parametre->getPhoto()){
                    $photo = $parametre->getPhoto()->getParametre()->getPhoto();
                }
                $img->setLibelle($newPhotoname);
                $photo->addImage($img);

            }
            $parametre->setPhoto($photo);
            $photo->setEtat(1);
            $photoRepository->save($photo, true);
        }

    }

    return $this->render('expertise_electrique_avant_lavage/photo.html.twig', [
        'parametre' => $parametre,
        'formPhoto' => $formPhoto->createView()
    ]);
    }
     
    //création des constats
    #[Route('/constat-electrique/{id}', name: 'app_constat_electrique', methods: ['POST', 'GET'])]
    public function constatElectrique(Parametre $parametre,Request $request,SluggerInterface $slugger,ConstatElectriqueRepository $constatElectriqueRepository): Response
    {
        //la partie constat electrique avant lavage
        $constatElectrique = new ConstatElectrique();

        $formConstatElectrique = $this->createForm(ConstatElectriqueType::class, $constatElectrique);
        $formConstatElectrique->handleRequest($request);
        if($formConstatElectrique->isSubmitted() && $formConstatElectrique->isValid())
        {
            $choix = $request->get('bouton10');
            if($choix == 'ajouter')
            {
                $image = $formConstatElectrique->get('photo')->getData();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_constat_electrique'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }           
                $constatElectrique->setPhoto($newPhotoname);
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
 
      
    //la fonction qui supprime une photo une fois ajouter
    #[Route('photo/{id}', name: 'delete_photo', methods: ['GET'])]
    public function deletePhoto(Request $request,Images $images, ImagesRepository $imagesRepository): Response
    {
        $id = $images->getPhoto()->getParametre()->getId();
       if($images)
       {
        $nom = $images->getLibelle();
        unlink($this->getParameter('images_expertises').'/'.$nom);
        $imagesRepository->remove($images, true);
        return $this->redirectToRoute('app_photos', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

       }else{
           return $this->redirectToRoute('app_photos', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
       } 
    }

    //la fonction qui supprime un point de fonctionnement
    #[Route('fonctionnement/{id}/point', name: 'delete_point_fonctionnement', methods: ['GET'])]
    public function deletePointFonctionnement(Request $request,PointFonctionnement $pointFonctionnement, PointFonctionnementRepository $pointFonctionnementRepository): Response
    {
        $id = $pointFonctionnement->getParametre()->getId();
        if($pointFonctionnement){
        $pointFonctionnementRepository->remove($pointFonctionnement, true);
        return $this->redirectToRoute('app_point_fonctionnement', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

        }else{
            return $this->redirectToRoute('app_point_fonctionnement', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        } 
        
    }

    //la fonction qui supprime constat électrique
    #[Route('constat/{id}/electrique', name: 'delete_constat_electrique', methods: ['GET'])]
    public function deleteConstat(ConstatElectrique $constatElectrique,ConstatElectriqueRepository $constatElectriqueRepository): Response
    {
          $id = $constatElectrique->getParametre()->getId();
          if($constatElectrique)
          {
            $nom = $constatElectrique->getPhoto();
            unlink($this->getParameter('images_constat_electrique').'/'.$nom);
            $constatElectriqueRepository->remove($constatElectrique, true);
            return $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
          }else{
              return $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
          } 
          
    }

    //la fonction qui valide l'expertise
    #[Route('validation/{id}', name: 'valider_expertise_electrique_avant_lavage', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
            if($parametre)
            {
                $email_send = $this->getUser()->getEmail();
                $email_receve = $parametre->getAffaire()->getSuiviPar()->getEmail();
                $subject = "Validation de l'expertise avant lavage";
                $text = "Bonjour ".$parametre->getAffaire()->getSuiviPar()->getNom()." "
                                .$parametre->getAffaire()->getSuiviPar()->getPrenom()
                                ." vous venez de recevoir une validation de la part de : "
                                .$this->getUser()->getNom()." ".$this->getUser()->getPrenom()
                                ." Num d'affaire : ".$parametre->getAffaire()->getNumAffaire();

                $transport = Transport::fromDsn("smtp://f858f9f1bd82e8:72bfaa776a018e@sandbox.smtp.mailtrap.io:2525?encryption=tls&auth_mode=login");
                $mailer = new Mailer($transport);
                
                $email = (new Email())
                    ->from($email_send)
                    ->to($email_receve)
                    ->subject($subject)
                    ->text($text);
                   // ->html('<p>See Twig integration for better HTML integration!</p>');  

                //dd($email);
                $mailer->send($email);

                $parametre->setExpertiseElectiqueAvantLavage(1);
                $entityManager->persist($parametre);
                $entityManager->flush();
                $this->addFlash("success", "Bravo : ".$this->getUser()->getNom()." ".$this->getUser()->getNom()." Vous avez validé l'expertise");
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            } 
    }

    //delete session tables mesures isolement
    #[Route('/delete/{id}/{paramID}', name: 'delete_mesure')]
    public function supprimeSession($id,$paramID,Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('mesures', []);
        if (array_key_exists($id, $tables))
        {
            unset($tables[$id]);
            $session->set('mesures',$tables);
        }
        return $this->redirectToRoute('app_mesure_isolement',['id' => $paramID]); 
    } 

    //delete session tables mesures resistance
    #[Route('/delete-lmesure-session-resistance/{id}/{id2}', name: 'delete_lmesure_resistance_session')]
    public function supprimeSessionResistance($id,$id2,Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('resistances', []);
        if (array_key_exists($id, $tables))
        {
            unset($tables[$id]);
            $session->set('resistances',$tables);
        }
        return $this->redirectToRoute('app_mesure_resistance',['id' => $id2]); 
    } 

    //delete tables mesures resistance
    #[Route('/delete-lmesure-resistance/{id}/{id2}', name: 'delete_lmesure_resistance')]
    public function supprimeLResistance(LMesureResistance $lMesureResistance,$id2,Request $request, LMesureResistanceRepository $lMesureResistanceRepository)
    {

        if ($lMesureResistance)
        {
            $lMesureResistanceRepository->remove($lMesureResistance, true);
            return $this->redirectToRoute('app_mesure_resistance',['id' => $id2]); 
        }
    } 

    //delete session tables mesures isolement
    #[Route('/delete-lmesure-session-isolement/{id}/{id2}', name: 'delete_lmesure_isolement_session')]
    public function supprimeSessionIsolemenet($id,$id2,Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('mesures', []);
        if (array_key_exists($id, $tables))
        {
            unset($tables[$id]);
            $session->set('mesures',$tables);
        }
        return $this->redirectToRoute('app_mesure_isolement',['id' => $id2]); 
    } 

    //delete tables mesures isolement
    #[Route('/delete-lmesure-isolement/{id}/{id2}', name: 'delete_lmesure_isolement')]
    public function supprimeLIsolement(LMesureIsolement $lmesureIsolement,$id2,Request $request, LMesureIsolementRepository $lmesureIsolementRepository)
    {

        if ($lmesureIsolement)
        {
            $lmesureIsolementRepository->remove($lmesureIsolement, true);
            return $this->redirectToRoute('app_mesure_isolement',['id' => $id2]); 
        }
    }

    //plaque signalétique et révision 
    #[Route('/plaque/{id}', name: 'app_photo_plaque')]
    public function plauqe(Parametre $parametre, PlaqueRepository $plaqueRepository,Request $request,SluggerInterface $slugger, LPlaqueRepository $lPlaqueRepository)
    {       
        $plaque = new Plaque();
        $formPlaque = $this->createForm(PlaqueType::class, $plaque);
        $formPlaque->handleRequest($request);

        $lplaque = new LPlaque();

        if($parametre->getLplaque())
        {
            $lplaque = $parametre->getLplaque()->getParametre()->getLplaque();
        }

        $form = $this->createForm(LPlaqueType::class, $lplaque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $parametre->setLplaque($lplaque);
            $lPlaqueRepository->save($lplaque, true);
            return $this->redirectToRoute('app_photo_plaque', ['id' => $parametre->getId()]);

        }

        if($formPlaque->isSubmitted() && $formPlaque->isValid())
        {
            $trouve = false;
            foreach($parametre->getPlaques() as $item)
            {
                if ($item->getLibelle() == $plaque->getLibelle())
                {
                    $trouve = true;
                }
            }

            if ($trouve == false)
            {
                $photo = $formPlaque->get('photo')->getData();
                if ($photo)
                {
                    $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                    try {
                        $photo->move(
                            $this->getParameter('image_plaque'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
    
                $plaque->setParametre($parametre); 
                $plaque->setPhoto($newPhotoname);
                $plaqueRepository->save($plaque, true);
                return $this->redirectToRoute('app_photo_plaque', ['id' => $parametre->getId()]);

            }else{

                $this->addFlash("message", "oups ! vous avez déjà ajouté cette photo : ".$plaque->getLibelle());
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
    #[Route('/plaque-supprimer/{id}', name: 'app_delete_plaque', methods: ['GET'])]
    public function deletePlaque(Plaque $plaque, PlaqueRepository $plaqueRepository): Response
    {
        $id = $plaque->getParametre()->getId();
        if($plaque)
        {
            $nom = $plaque->getPhoto();
            unlink($this->getParameter('image_plaque').'/'.$nom);
            $plaqueRepository->remove($plaque, true);
            return $this->redirectToRoute('app_photo_plaque', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_photo_plaque', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }

    
} 
