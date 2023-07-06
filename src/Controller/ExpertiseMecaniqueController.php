<?php

namespace App\Controller;

use App\Entity\Plaque;
use App\Form\PlaqueType;
use App\Entity\Coussinet;
use App\Entity\HydroAero;
use App\Entity\Parametre;
use App\Entity\Roulement;
use App\Entity\Synoptique;
use App\Form\CoussinetType;
use App\Form\HydroAeroType;
use App\Form\RoulementType;
use App\Form\SynoptiqueType;
use App\Entity\ConstatMecanique;
use App\Form\ConstatMecaniqueType;
use App\Entity\ControleGeometrique;
use App\Entity\ControleRecensement;
use App\Entity\ReleveDimmensionnel;
use App\Repository\PlaqueRepository;
use App\Form\ControleGeometriqueType;
use App\Form\ControleRecensementType;
use App\Form\ReleveDimmensionnelType;
use App\Entity\AppareilMesureMecanique;
use App\Entity\ControleVisuelMecanique;
use App\Entity\PhotoExpertiseMecanique;
use App\Repository\CoussinetRepository;
use App\Repository\HydroAeroRepository;
use App\Repository\ParametreRepository;
use App\Repository\RoulementRepository;
use App\Entity\AccessoireSupplementaire;
use App\Entity\ControleMontageConssinet;
use App\Entity\ControleMontageRoulement;
use App\Repository\SynoptiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppareilMesureMecaniqueType;
use App\Form\ControleVisuelMecaniqueType;
use App\Form\PhotoExpertiseMecaniqueType;
use App\Form\AccessoireSupplementaireType;
use App\Form\ControleMontageCoussinetType;
use App\Form\ControleMontageRoulementType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ConstatMecaniqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleGeometriqueRepository;
use App\Repository\ControleRecensementRepository;
use App\Repository\ReleveDimmensionnelRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\ControleVisuelMecaniqueRepository;
use App\Repository\PhotoExpertiseMecaniqueRepository;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\ControleMontageConssinetRepository;
use App\Repository\ControleMontageRoulementRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/expertiseMecanique')]
class ExpertiseMecaniqueController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}


    #[Route('/index/{id}/mecanique', name: 'app_expertise_mecanique')]
    public function index(Parametre $parametre, Request $request,): Response
    {
        return $this->render('expertise_mecanique/index.html.twig', ['parametre' => $parametre,]);
    }

    //photo à la réception 
    #[Route('/photo-reception/{id}', name: 'app_photo_reception')]
    public function photoReception(Parametre $parametre, ControleRecensementRepository $controleRecensementRepository,Request $request,SluggerInterface $slugger)
    {       
        $controleRecensement = new ControleRecensement();
        $formControleRecensement = $this->createForm(ControleRecensementType::class, $controleRecensement);
        $formControleRecensement->handleRequest($request);
        if($formControleRecensement->isSubmitted() && $formControleRecensement->isValid())
        {
            $trouve = false;
            foreach($parametre->getControleRecensements() as $item)
            {
                if ($item->getLibelle() == $controleRecensement->getLibelle())
                {
                    $trouve = true;
                }
            }

            if ($trouve == false)
            {
                $photo = $formControleRecensement->get('photo')->getData();
                if ($photo)
                {
                    $originalePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo->guessExtension();
                    try {
                        $photo->move(
                            $this->getParameter('image_controle_recensement'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
    
                $controleRecensement->setParametre($parametre); 
                $controleRecensement->setPhoto($newPhotoname);
                $controleRecensementRepository->save($controleRecensement, true);
                return $this->redirectToRoute('app_photo_reception', ['id' => $parametre->getId()]);

            }else{

                $this->addFlash("message", "oups ! vous avez déjà ajouté cette photo : ".$controleRecensement->getLibelle());
                return $this->redirectToRoute('app_photo_reception', ['id' => $parametre->getId()]);
            }
                     
        }
        return $this->render('expertise_mecanique/controle_recensement.html.twig', [
        'parametre' => $parametre,
        'formControleRecensement' => $formControleRecensement->createView()
        
        ]);

    }

    //controle visuel et recensement
    #[Route('/controle-visuel/{id}', name: 'app_controle_visuel_mecanique')]
    public function consoleVisuel(AccessoireSupplementaireRepository $accessoireSupplementaireRepository,Parametre $parametre, Request $request,ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,): Response
    {
        //la partie controle visuel Mecanique
        $controleVisuelMecanique = new ControleVisuelMecanique();
        $accessoireSupplementaire = new AccessoireSupplementaire();

        if($parametre->getControleVisuelMecanique()){
            $controleVisuelMecanique = $parametre->getControleVisuelMecanique()->getParametre()->getControleVisuelMecanique();
        }

        $formControlevisuelMecanque = $this->createForm(ControleVisuelMecaniqueType::class, $controleVisuelMecanique);
        $formAccessoire = $this->createForm(AccessoireSupplementaireType::class, $accessoireSupplementaire);
        $formControlevisuelMecanque->handleRequest($request);
        $formAccessoire->handleRequest($request);

        $tables = $accessoireSupplementaireRepository->findByLig(0);
        if($formControlevisuelMecanque->isSubmitted() && $formAccessoire->isSubmitted())
        {
            $choix = $request->get('bouton1');
            if($choix == 'ajouter')
            {
                $accessoireSupplementaire->setLig(0);
                $accessoireSupplementaireRepository->save($accessoireSupplementaire, true);
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_visuel_en_cours')
            {
                foreach($tables as $item)
                {
                    $item->setLig(1);
                    $item->setControleVisuelMecanique($controleVisuelMecanique);
                }          

                $parametre->setControleVisuelMecanique($controleVisuelMecanique);
                $controleVisuelMecanique->setEtat(0);
                $controleVisuelMecaniqueRepository->save($controleVisuelMecanique, true);
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);

            }
            elseif($choix == 'controle_visuel_terminer')
            {
                 foreach($tables as $item)
                 {
                     $item->setLig(1);
                     $item->setControleVisuelMecanique($controleVisuelMecanique);
                 }          
                 $parametre->setControleVisuelMecanique($controleVisuelMecanique);
                 $controleVisuelMecanique->setEtat(1);
                 $controleVisuelMecaniqueRepository->save($controleVisuelMecanique, true);
                 $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_mecanique/controle_visuel.html.twig', [
            'parametre' => $parametre,
            'formAccessoire' => $formAccessoire->createView(),
            'controleVisuelMecanique' => $controleVisuelMecanique,
            'formControlevisuelMecanque' => $formControlevisuelMecanque->createView(),
            'accessoires' => $tables,
            
        ]);
    }

     //controle montage de roulement
    #[Route('/controle-montage-roulement/{id}', name: 'app_controle_montage_roulement')]
    public function consoleMontage(ControleMontageRoulementRepository $controleMontageRoulementRepository,Parametre $parametre, Request $request,ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,): Response
    {
        //la partie controle montage roulement
        $controleMontageRoulement = new ControleMontageRoulement();
        if($parametre->getControleMontageRoulement()){
            $controleMontageRoulement = $parametre->getControleMontageRoulement()->getParametre()->getControleMontageRoulement();
        }

        $formControlMontageRoulement = $this->createForm(ControleMontageRoulementType::class, $controleMontageRoulement);
        $formControlMontageRoulement->handleRequest($request);
        if($formControlMontageRoulement->isSubmitted() && $formControlMontageRoulement->isValid())
        {
            $choix = $request->get('bouton2');
            if($choix == 'controle_montage_roulement_en_cours')
            {
                $parametre->setControleMontageRoulement($controleMontageRoulement);
                $controleMontageRoulement->setEtat(0);
                $controleMontageRoulementRepository->save($controleMontageRoulement, true);
                $this->redirectToRoute('app_controle_montage_roulement', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_montage_roulement_terminer')
            {         
                 $parametre->setControleMontageRoulement($controleMontageRoulement);
                 $controleMontageRoulement->setEtat(1);
                 $controleMontageRoulementRepository->save($controleMontageRoulement, true);
                 $this->redirectToRoute('app_controle_montage_roulement', ['id' => $parametre->getId()]);
            }
        }

         return $this->render('expertise_mecanique/controle_montage_roulement.html.twig', [
             'parametre' => $parametre,
             'formControlMontageRoulement' => $formControlMontageRoulement->createView()
             
         ]);
    }

    //controle montage de coussinet
    #[Route('/controle-montage-coussinet/{id}', name: 'app_controle_montage_coussinet')]
    public function consoleMontageCoussinet(ControleMontageConssinetRepository $controleMontageConssinetRepository,Parametre $parametre, Request $request): Response
    {
        //la partie controle montage coussinet
        $controleMontageCoussinet = new ControleMontageConssinet();
        if($parametre->getControleMontageCoussinet()){
            $controleMontageCoussinet = $parametre->getControleMontageCoussinet()->getParametre()->getControleMontageCoussinet();
        }

        $formControlMontageCoussinet = $this->createForm(ControleMontageCoussinetType::class, $controleMontageCoussinet);
        $formControlMontageCoussinet->handleRequest($request);
        if($formControlMontageCoussinet->isSubmitted() && $formControlMontageCoussinet->isValid())
        {
            $choix = $request->get('bouton3');
            if($choix == 'controle_montage_coussinet_en_cours')
            {
                $parametre->setControleMontageCoussinet($controleMontageCoussinet);
                $controleMontageCoussinet->setEtat(0);
                $controleMontageConssinetRepository->save($controleMontageCoussinet, true);
                $this->redirectToRoute('app_controle_montage_coussinet', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_montage_coussinet_terminer')
            {         
                    $parametre->setControleMontageCoussinet($controleMontageCoussinet);
                    $controleMontageCoussinet->setEtat(1);
                    $controleMontageConssinetRepository->save($controleMontageCoussinet, true);
                    $this->redirectToRoute('app_controle_montage_coussinet', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_mecanique/controle_montage_coussinet.html.twig', [
            'parametre' => $parametre,
            'formControlMontageCoussinet' => $formControlMontageCoussinet->createView(),
            
        ]);
    }

     //relevé dimensionnel
    #[Route('/releve-dimensionnel/{id}', name: 'app_releve_dimensionnel')]
    public function releveDimensionnel(ReleveDimmensionnelRepository $releveDimmensionnelRepository,Parametre $parametre, Request $request): Response
    {
        //la partie relevés dimmensionnel rotor et paliers
        $releveDimmensionnel = new ReleveDimmensionnel();
        $formReleveDimmensionnel = $this->createForm(ReleveDimmensionnelType::class, $releveDimmensionnel);
        $formReleveDimmensionnel->handleRequest($request);
        if($formReleveDimmensionnel->isSubmitted() && $formReleveDimmensionnel->isValid())
        {
            $choix = $request->get('bouton4');
          //  dd($choix);
            if($choix == 'ajouter')
            {
                $releveDimmensionnel->setParametre($parametre);
                $releveDimmensionnelRepository->save($releveDimmensionnel, true);
                $this->redirectToRoute('app_releve_dimensionnel', ['id' => $parametre->getId()]);
            }
        }

 
         return $this->render('expertise_mecanique/releve_dimensionnels.html.twig', [
             'parametre' => $parametre,
             'formReleveDimmensionnel' => $formReleveDimmensionnel->createView()
             
         ]);
    }

    //relevé controle geometrique
    #[Route('/controle-geometrique/{id}', name: 'app_controle_geometrique')]
    public function controleGeometrique(ControleGeometriqueRepository $controleGeometriqueRepository,Parametre $parametre, Request $request): Response
    {
        
        //la partie controle geometrique
        $controleGeometrique = new ControleGeometrique();
        if($parametre->getControleGeometrique()){
            $controleGeometrique = $parametre->getControleGeometrique()->getParametre()->getControleGeometrique();
        }

        $formControlGeometrique = $this->createForm(ControleGeometriqueType::class, $controleGeometrique);
        $formControlGeometrique->handleRequest($request);
        if($formControlGeometrique->isSubmitted() && $formControlGeometrique->isValid())
        {
            $choix = $request->get('bouton5');
            if($choix == 'controle_geometrique_en_cours')
            {
                $parametre->setControleGeometrique($controleGeometrique);
                $controleGeometrique->setEtat(0);
                $controleGeometriqueRepository->save($controleGeometrique, true);
                $this->redirectToRoute('app_controle_geometrique', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_geometrique_terminer')
            {         
                    $parametre->setControleGeometrique($controleGeometrique);
                    $controleGeometrique->setEtat(1);
                    $controleGeometriqueRepository->save($controleGeometrique, true);
                    $this->redirectToRoute('app_controle_geometrique', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_mecanique/controle_geometrique.html.twig', [
            'parametre' => $parametre,
            'formControlGeometrique' => $formControlGeometrique->createView(),
            
        ]);
    }

    //relevé appareil-mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_mesure_mecanique')]
    public function appareilMesure(AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository,Parametre $parametre, Request $request): Response
    {
        //la partie appareil de mesure
        $appareilMesureMecanique = new AppareilMesureMecanique();

        $formAppareilMesureMecanique = $this->createForm(AppareilMesureMecaniqueType::class, $appareilMesureMecanique);
        $formAppareilMesureMecanique->handleRequest($request);
        $date = date('Y-m-d');
        if($formAppareilMesureMecanique->isSubmitted() && $formAppareilMesureMecanique->isValid())
        {
            $choix = $request->get('bouton6');
            if($choix == 'ajouter')
            {
                $dateAppareil = $appareilMesureMecanique->getAppareil()->getDateValidite()->format('Y-m-d');
                if($dateAppareil < $date){
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : ".$dateAppareil);
                }else{
                    $appareilMesureMecanique->setParametre($parametre);
                    $appareilMesureMecanique->setEtat(0);
                    $appareilMesureMecaniqueRepository->save($appareilMesureMecanique, true);
                    $this->redirectToRoute('app_appareil_mesure_mecanique', ['id' => $parametre->getId()]);
                }
            }
        }
        
        return $this->render('expertise_mecanique/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareilMesureMecanique' => $formAppareilMesureMecanique->createView(),
            
        ]);
    }

    //relevé Expertise Hydro ou Aéro
    #[Route('/hydro-aero/{id}', name: 'app_hydro_aero')]
    public function hydroAero(HydroAeroRepository $hydroAeroRepository,Parametre $parametre, Request $request): Response
    {
        //la partie hydro Aéro
        $hydroAero = new HydroAero();
        if($parametre->getHydroAero())
        {
            $hydroAero =  $parametre->getHydroAero()->getParametre()->getHydroAero();
        }

        $formHydroAero = $this->createForm(HydroAeroType::class, $hydroAero);
        $formHydroAero->handleRequest($request);
        if($formHydroAero->isSubmitted() && $formHydroAero->isValid())
        {
            $choix = $request->get('bouton7');
            if($choix == 'hydro_aero_en_cours')
            {
                $parametre->setHydroAero($hydroAero);
                $hydroAero->setEtat(0);
                $hydroAeroRepository->save($hydroAero, true);
                $this->redirectToRoute('app_hydro_aero', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'hydro_aero_terminer')
            {         
                $parametre->setHydroAero($hydroAero);
                $hydroAero->setEtat(1);
                $hydroAeroRepository->save($hydroAero, true);
                $this->redirectToRoute('app_hydro_aero', ['id' => $parametre->getId()]);
            }
        }

        
        return $this->render('expertise_mecanique/expertise_hydro_aero.html.twig', [
            'parametre' => $parametre,
            'formHydroAero' => $formHydroAero->createView(),
        ]);
    }

     //relevé photos
     #[Route('/photos/{id}', name: 'app_photos_mecanique')]
     public function photo(PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository,SluggerInterface $slugger,Parametre $parametre, Request $request): Response
    {
        
        //la partie photo
        $photoExpertiseMecanique = new PhotoExpertiseMecanique();

        $formPhotoExpertiseMecanique = $this->createForm(PhotoExpertiseMecaniqueType::class, $photoExpertiseMecanique);
        $formPhotoExpertiseMecanique->handleRequest($request);
        if($formPhotoExpertiseMecanique->isSubmitted() && $formPhotoExpertiseMecanique->isValid())
        {
            $choix = $request->get('bouton8');
            $image = $formPhotoExpertiseMecanique->get('image')->getData();
            if($choix == 'ajouter')
            {
                if ($image)
                {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('image_expertise_mecaniques'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }

                $photoExpertiseMecanique->setParametre($parametre); 
                $photoExpertiseMecanique->setImage($newPhotoname);
                $photoExpertiseMecaniqueRepository->save($photoExpertiseMecanique, true);
                $this->redirectToRoute('app_photos_mecanique', ['id' => $parametre->getId()]);
            }
        }
   
        return $this->render('expertise_mecanique/photo.html.twig', [
             'parametre' => $parametre,
             'formPhotoExpertiseMecanique' => $formPhotoExpertiseMecanique->createView(),
         ]);
    }

    //relevé Constats Mécanique
    #[Route('/constat-mecanique/{id}', name: 'app_constat_mecanique')]
    public function constat(ConstatMecaniqueRepository $constatMecaniqueRepository,SluggerInterface $slugger,Parametre $parametre, Request $request): Response
    {
        
       
        //la partie constat electrique
        $constatMecanique = new ConstatMecanique();

        $formConstatMecanique = $this->createForm(ConstatMecaniqueType::class, $constatMecanique);
        $formConstatMecanique->handleRequest($request);
        if($formConstatMecanique->isSubmitted() && $formConstatMecanique->isValid())
        {
            $choix = $request->get('bouton9');
            if($choix == 'ajouter')
            {
                $image = $formConstatMecanique->get('photo')->getData();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_constat_mecanique'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                } 

                $constatMecanique->setPhoto($newPhotoname);
                $constatMecanique->setParametre($parametre);
                $constatMecaniqueRepository->save($constatMecanique, true);

                $this->redirectToRoute('app_constat_mecanique', ['id' => $parametre->getId()]);
            }
        }
       
    
        return $this->render('expertise_mecanique/constat.html.twig', [
                'parametre' => $parametre,
                'formConstatMecanique' => $formConstatMecanique->createView(),
        ]);
    }

    //la focntion pour supprimer un accessoire
    #[Route('/delete/{id}/{parmID}', name : "app_delete_accessoire", methods: ['GET'])]
    public function delete($parmID,AccessoireSupplementaire $accessoireSupplementaire, AccessoireSupplementaireRepository $accessoireSupplementaireRepository)
    {
       //  $id = $accessoireSupplementaire->getControleVisuelMecanique()->getParametre()->getId();
        if($accessoireSupplementaire)
        {
            $accessoireSupplementaireRepository->remove($accessoireSupplementaire, true);
           return $this->redirectToRoute('app_expertise_mecanique', ['id' => $parmID]);
        }
    }

    //la fonction qui supprime une photo une fois ajouter
    #[Route('/photo/{id}/expertise', name: 'delete_photo_expertise_mecanique', methods: ['GET'])]
    public function deletePhoto(PhotoExpertiseMecanique $photoExpertiseMecanique, PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository): Response
    {
        $id = $photoExpertiseMecanique->getParametre()->getId();
        if($photoExpertiseMecanique)
        {
            $nom = $photoExpertiseMecanique->getImage();
            unlink($this->getParameter('image_expertise_mecaniques').'/'.$nom);
            
            $photoExpertiseMecaniqueRepository->remove($photoExpertiseMecanique, true);
            return $this->redirectToRoute('app_photos_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);

        }
        else
        {
            return $this->redirectToRoute('app_photos_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }

    //la fonction qui supprime le constat mécanique
    #[Route('/constat/{id}/mecanique', name: 'delete_constat_mecanique', methods: ['GET'])]
    public function deleteConstat(ConstatMecanique $constatMecanique,ConstatMecaniqueRepository $constatMecaniqueRepository): Response
    {
        $id = $constatMecanique->getParametre()->getId();
        if($constatMecanique)
        {
            $nom = $constatMecanique->getPhoto();
            unlink($this->getParameter('images_constat_mecanique').'/'.$nom);
            $constatMecaniqueRepository->remove($constatMecanique, true);
            return $this->redirectToRoute('app_constat_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_constat_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
        
    }

    //la fonction qui supprime le constat mécanique
    #[Route('releve/dimmensionnel/{id}', name: 'delete_releve_dimmensionnel', methods: ['GET'])]
    public function deleteReleve(ReleveDimmensionnel $releveDimmensionnel,ReleveDimmensionnelRepository $releveDimmensionnelRepository): Response
    {
        $id = $releveDimmensionnel->getParametre()->getId();
        if($releveDimmensionnel)
        {
            $releveDimmensionnelRepository->remove($releveDimmensionnel, true);
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
        
    }

    //la fonction qui valide l'expertise
    #[Route('validation/{id}', name: 'valider_expertise_mecanique', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager): Response
    {
            if($parametre)
            {
                $parametre->setExpertiseMecanique(1);
                $entityManager->persist($parametre);
                $entityManager->flush();
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            } 
    }
    
    //la fonction qui supprime une photo à la réception
    #[Route('/recetpion/{id}', name: 'app_delete_controle_recensement', methods: ['GET'])]
    public function deletePhotoReception(ControleRecensement $controleRecensement, ControleRecensementRepository $controleRecensementRepository): Response
    {
        $id = $controleRecensement->getParametre()->getId();
        if($controleRecensement)
        {
            $nom = $controleRecensement->getPhoto();
            unlink($this->getParameter('image_controle_recensement').'/'.$nom);
            $controleRecensementRepository->remove($controleRecensement, true);
            return $this->redirectToRoute('app_photo_reception', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_photo_reception', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }

    //coussinet CA & COA
    #[Route('/coussinet/{id}', name: 'app_coussinet')]
    public function coussinet(CoussinetRepository $coussinetRepository,Parametre $parametre, Request $request, SluggerInterface $slugger): Response
    {
        $coussinet = new Coussinet();
        if($parametre->getCoussinet())
        {
            $coussinet =  $parametre->getCoussinet()->getParametre()->getCoussinet();
        }

        $formCoussinet = $this->createForm(CoussinetType::class, $coussinet);
        $formCoussinet->handleRequest($request);
        if($formCoussinet->isSubmitted() && $formCoussinet->isValid())
        {
            $choix = $request->get('bouton003');
            if($choix == 'coussinet_en_cours')
            {
                //photo coussinet ca
                $photo_ca = $formCoussinet->get('photo_ca')->getData();
                if ($photo_ca)
                {
                    $originalePhoto = pathinfo($photo_ca->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_ca->guessExtension();
                    try {
                        $photo_ca->move(
                            $this->getParameter('image_coussinet'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                $coussinet->setPhotoCa($newPhotoname);

                //photo coussinet coa
                $photo_coa = $formCoussinet->get('photo_coa')->getData();
                if ($photo_coa)
                {
                    $originalePhoto = pathinfo($photo_coa->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_coa->guessExtension();
                    try {
                        $photo_coa->move(
                            $this->getParameter('image_coussinet'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                $coussinet->setPhotoCoa($newPhotoname);

                $parametre->setCoussinet($coussinet);
                $coussinet->setEtat(0);
                $coussinetRepository->save($coussinet, true);
                $this->redirectToRoute('app_coussinet', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'coussinet_terminer')
            {       
                
                //photo coussinet ca
                $photo_ca = $formCoussinet->get('photo_ca')->getData();
                if ($photo_ca)
                {
                    $originalePhoto = pathinfo($photo_ca->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_ca->guessExtension();
                    try {
                        $photo_ca->move(
                            $this->getParameter('image_coussinet'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                $coussinet->setPhotoCa($newPhotoname);

                //photo coussinet coa
                $photo_coa = $formCoussinet->get('photo_coa')->getData();
                if ($photo_coa)
                {
                    $originalePhoto = pathinfo($photo_coa->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $photo_coa->guessExtension();
                    try {
                        $photo_coa->move(
                            $this->getParameter('image_coussinet'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                }
                $coussinet->setPhotoCoa($newPhotoname);

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

    //roulement CA & COA
    #[Route('/roulement/{id}', name: 'app_roulement')]
    public function roulement(RoulementRepository $roulementRepository,Parametre $parametre, Request $request): Response
    {
        $roulement = new Roulement();
        if($parametre->getRoulement())
        {
            $roulement =  $parametre->getRoulement()->getParametre()->getRoulement();
        }

        $formRoulement = $this->createForm(RoulementType::class, $roulement);
        $formRoulement->handleRequest($request);
        if($formRoulement->isSubmitted() && $formRoulement->isValid())
        {
            $choix = $request->get('bouton004');
            if($choix == 'roulement_en_cours')
            {
                $parametre->setRoulement($roulement);
                $roulement->setEtat(0);
                $roulementRepository->save($roulement, true);
                $this->redirectToRoute('app_roulement', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'roulement_terminer')
            {       
                $parametre->setRoulement($roulement);
                $roulement->setEtat(1);
                $roulementRepository->save($roulement, true);
                $this->redirectToRoute('app_roulement', ['id' => $parametre->getId()]);
            }
        }

        
        return $this->render('expertise_mecanique/roulement.html.twig', [
            'parametre' => $parametre,
            'roulement' => $roulement,
            'formRoulement' => $formRoulement->createView(),
        ]);
    }

    //synoptiques 
    #[Route('/synoptique/{id}', name: 'app_synoptique')]
    public function synoptique(Parametre $parametre, SynoptiqueRepository $synoptiqueRepository,Request $request)
    {       
        $synoptique = new Synoptique();
        $form = $this->createForm(SynoptiqueType::class, $synoptique);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $synoptique->setParametre($parametre); 
            $synoptiqueRepository->save($synoptique, true);
            return $this->redirectToRoute('app_synoptique', ['id' => $parametre->getId()]);                         
        }
        return $this->render('expertise_mecanique/synoptique.html.twig', [
            'parametre' => $parametre,
            'form' => $form->createView()
        
        ]);

    }

     //la fonction qui supprime synoptique
     #[Route('/syno-delete/{id}', name: 'app_delete_synoptique', methods: ['GET'])]
     public function deleteSynoptique(Synoptique $synoptique, SynoptiqueRepository $synoptiqueRepository): Response
     {
         $id = $synoptique->getParametre()->getId();
         if($synoptique)
         {
             $synoptiqueRepository->remove($synoptique, true);
             return $this->redirectToRoute('app_synoptique', ['id' => $id], Response::HTTP_SEE_OTHER);
         }
         else
         {
             return $this->redirectToRoute('app_synoptique', ['id' => $id], Response::HTTP_SEE_OTHER);
         } 
     }

}
