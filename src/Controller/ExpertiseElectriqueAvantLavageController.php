<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Images;
use App\Form\PhotoType;
use App\Entity\Parametre;
use App\Entity\AutreControle;
use App\Entity\AppareilMesure;
use App\Entity\ConstatElectrique;
use App\Entity\MesureIsolement;
use App\Form\AutreControleType;
use App\Entity\ControleBobinage;
use App\Entity\MesureResistance;
use App\Entity\MesureVibratoire;
use App\Form\AppareilMesureType;
use App\Form\MesureIsolementType;
use App\Form\ControleBobinageType;
use App\Form\MesureResistanceType;
use App\Form\MesureVibratoireType;
use App\Entity\PointFonctionnement;
use App\Repository\PhotoRepository;
use App\Repository\ImagesRepository;
use App\Form\PointFonctionnementType;
use App\Entity\ControleVisuelElectrique;
use App\Form\ConstatElectriqueType;
use App\Form\ControleVisuelElectriqueType;
use App\Repository\AutreControleRepository;
use App\Repository\AppareilMesureRepository;
use App\Repository\ConstatElectriqueRepository;
use App\Repository\MesureIsolementRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ControleBobinageRepository;
use App\Repository\MesureResistanceRepository;
use App\Repository\MesureVibratoireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PointFonctionnementRepository;
use App\Repository\ControleVisuelElectriqueRepository;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
    public function index(Parametre $parametre,Request $request,
        SluggerInterface $slugger,
        ControleVisuelElectriqueRepository $controleVisuelElectriqueRepository,
        MesureVibratoireRepository $mesureVibratoireRepository,
        ControleBobinageRepository $controleBobinageRepository,
        AutreControleRepository $autreControleRepository,
        PhotoRepository $photoRepository,
        AppareilMesureRepository $appareilMesureRepository,
        MesureIsolementRepository $mesureIsolementRepository,
        MesureResistanceRepository $mesureResistanceRepository,
        PointFonctionnementRepository $pointFonctionnementRepository,
        ConstatElectriqueRepository $constatElectriqueRepository,
        EntityManagerInterface $em
     ): Response
    {

        
         //la partie du contrôle visuel et recensement      

        //1 
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
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_visuel_terminer')
            {
                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(1);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);

            }
        }
        //fin du contrôle visuel

        //Mesure d'isolement
        $mesureIsolement = new MesureIsolement();
        if($parametre->getMesureIsolement()){
            $mesureIsolement = $parametre->getMesureIsolement()->getParametre()->getMesureIsolement();
        }
        $formMesureIsolement = $this->createForm(MesureIsolementType::class, $mesureIsolement);
        $formMesureIsolement->handleRequest($request);
        if($formMesureIsolement->isSubmitted() && $formMesureIsolement->isValid())
        {
            $choix = $request->get('bouton7');
            if($choix == 'mesure_isolement_en_cours')
            {
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(0);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_isolement_terminer')
            {
                $parametre->setMesureIsolement($mesureIsolement);
                $mesureIsolement->setEtat(1);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }


        //Mesure de resistance
        $mesureResistance = new MesureResistance();
        if($parametre->getMesureResistance()){
            $mesureResistance = $parametre->getMesureResistance()->getParametre()->getMesureResistance();
        }
        $formMesureResistance = $this->createForm(MesureResistanceType::class, $mesureResistance);
        $formMesureResistance->handleRequest($request);
        if($formMesureResistance->isSubmitted() && $formMesureResistance->isValid()){
            $choix = $request->get('bouton8');
            if($choix == 'mesure_resistance_en_cours')
            {
                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(0);
                $mesureResistanceRepository->save($mesureResistance, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_resistance_terminer')
            {
                $parametre->setMesureResistance($mesureResistance);
                $mesureResistance->setEtat(1);
                $mesureResistanceRepository->save($mesureResistance, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }
 
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
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);

            }
            elseif($choix == 'mesure_vibratoire_terminer')
            {
                $parametre->setMesureVibratoire($mesureVibratoire);
                $mesureVibratoire->setEtat(1);
                $mesureVibratoireRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }

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
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix = 'controle_bobinage_terminer')
            {
                $parametre->setControleBobinage($controleBobinage);
                $controleBobinage->setEtat(1);
                $controleBobinageRepository->save($controleBobinage, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }

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
                    $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
                }
            }
        }

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
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }

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
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/index.html.twig', [
            'parametre' => $parametre,
            'formControleVisuelElectique' => $formControleVisuelElectique->createView(),
            'formMesureVibratoire'=> $formMesureVibratoire->createView(),
            'formControleBobinage' => $formControleBobinage->createView(),
            'formAutreControle' => $formAutreControle->createView(),
            'formPhoto' => $formPhoto->createView(),
            'formAppareilMesure' => $formAppareilMesure->createView(),
            'formMesureIsolement' => $formMesureIsolement->createView(),
            'formMesureResistance' => $formMesureResistance->createView(),
            'formPointFonctionnement' => $formPointFonctionnement->createView(),
            'formConstatElectrique' => $formConstatElectrique->createView()
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
        return $this->redirectToRoute('app_expertise_electrique_avant_lavage', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

       }else{
           return $this->redirectToRoute('app_expertise_electrique_avant_lavage', [
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
        return $this->redirectToRoute('app_expertise_electrique_avant_lavage', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

        }else{
            return $this->redirectToRoute('app_expertise_electrique_avant_lavage', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
        } 
        
    }

    //la fonction qui supprime un point de fonctionnement
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
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager): Response
    {
            if($parametre)
            {
                $parametre->setExpertiseElectiqueAvantLavage(1);
                $entityManager->persist($parametre);
                $entityManager->flush();
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            } 
    }
}
