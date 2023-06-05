<?php

namespace App\Controller;

use App\Entity\HydroAero;
use App\Entity\Parametre;
use App\Form\HydroAeroType;
use App\Entity\ConstatMecanique;
use App\Entity\ControleGeometrique;
use App\Form\ControleGeometriqueType;
use App\Entity\AppareilMesureMecanique;
use App\Entity\ControleVisuelMecanique;
use App\Entity\PhotoExpertiseMecanique;
use App\Repository\HydroAeroRepository;
use App\Entity\AccessoireSupplementaire;
use App\Entity\ControleMontageConssinet;
use App\Entity\ControleMontageRoulement;
use App\Entity\ReleveDimmensionnel;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppareilMesureMecaniqueType;
use App\Form\ControleVisuelMecaniqueType;
use App\Form\PhotoExpertiseMecaniqueType;
use App\Form\AccessoireSupplementaireType;
use App\Form\ConstatMecaniqueType;
use App\Form\ControleMontageCoussinetType;
use App\Form\ControleMontageRoulementType;
use App\Form\ReleveDimmensionnelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleGeometriqueRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\ControleVisuelMecaniqueRepository;
use App\Repository\PhotoExpertiseMecaniqueRepository;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\ConstatMecaniqueRepository;
use App\Repository\ControleMontageConssinetRepository;
use App\Repository\ControleMontageRoulementRepository;
use App\Repository\ReleveDimmensionnelRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/expertiseMecanique')]
class ExpertiseMecaniqueController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}


    #[Route('/index/{id}/mecanique', name: 'app_expertise_mecanique')]
    public function index(
        SluggerInterface $slugger,
        Parametre $parametre, Request $request,
        ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,
        AccessoireSupplementaireRepository $accessoireSupplementaireRepository,
        ControleMontageRoulementRepository $controleMontageRoulementRepository,
        ControleMontageConssinetRepository $controleMontageConssinetRepository,
        ControleGeometriqueRepository $controleGeometriqueRepository,
        AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository,
        HydroAeroRepository $hyroleRepository,
        PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository,
        ConstatMecaniqueRepository $constatMecaniqueRepository,
        ReleveDimmensionnelRepository $releveDimmensionnelRepository
        ): Response
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
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_montage_roulement_terminer')
            {         
                 $parametre->setControleMontageRoulement($controleMontageRoulement);
                 $controleMontageRoulement->setEtat(1);
                 $controleMontageRoulementRepository->save($controleMontageRoulement, true);
                 $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

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
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_montage_coussinet_terminer')
            {         
                    $parametre->setControleMontageCoussinet($controleMontageCoussinet);
                    $controleMontageCoussinet->setEtat(1);
                    $controleMontageConssinetRepository->save($controleMontageCoussinet, true);
                    $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

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
                 $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
             }
             elseif($choix == 'controle_geometrique_terminer')
             {         
                     $parametre->setControleGeometrique($controleGeometrique);
                     $controleGeometrique->setEtat(1);
                     $controleGeometriqueRepository->save($controleGeometrique, true);
                     $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
             }
         }

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
                    $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
                }
            }
        }

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
                $hyroleRepository->save($hydroAero, true);
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'hydro_aero_terminer')
            {         
                $parametre->setHydroAero($hydroAero);
                $hydroAero->setEtat(1);
                $hyroleRepository->save($hydroAero, true);
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

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
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

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

                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }

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
                $this->redirectToRoute('app_expertise_mecanique', ['id' => $parametre->getId()]);
            }
        }


        return $this->render('expertise_mecanique/index.html.twig', [
            'parametre' => $parametre,
            'formAccessoire' => $formAccessoire->createView(),
            'formControlevisuelMecanque' => $formControlevisuelMecanque->createView(),
            'formControlMontageRoulement' => $formControlMontageRoulement->createView(),
            'formControlMontageCoussinet' => $formControlMontageCoussinet->createView(),
            'formControlGeometrique' => $formControlGeometrique->createView(),
            'accessoires' => $tables,
            'controleVisuelMecanique' => $controleVisuelMecanique,
            'formAppareilMesureMecanique' => $formAppareilMesureMecanique->createView(),
            'formHydroAero' => $formHydroAero->createView(),
            'formPhotoExpertiseMecanique' => $formPhotoExpertiseMecanique->createView(),
            'formConstatMecanique' => $formConstatMecanique->createView(),
            'formReleveDimmensionnel' => $formReleveDimmensionnel->createView()
            
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
    #[Route('photo/{id}/expertise', name: 'delete_photo_expertise_mecanique', methods: ['GET'])]
    public function deletePhoto(PhotoExpertiseMecanique $photoExpertiseMecanique, PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository): Response
    {
        $id = $photoExpertiseMecanique->getParametre()->getId();
        if($photoExpertiseMecanique)
        {
            $nom = $photoExpertiseMecanique->getImage();
            unlink($this->getParameter('image_expertise_mecaniques').'/'.$nom);
            
            $photoExpertiseMecaniqueRepository->remove($photoExpertiseMecanique, true);
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);

        }
        else
        {
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }

    //la fonction qui supprime le constat mécanique
    #[Route('constat/{id}/mecanique', name: 'delete_constat_mecanique', methods: ['GET'])]
    public function deleteConstat(ConstatMecanique $constatMecanique,ConstatMecaniqueRepository $constatMecaniqueRepository): Response
    {
        $id = $constatMecanique->getParametre()->getId();
        if($constatMecanique)
        {
            $nom = $constatMecanique->getPhoto();
            unlink($this->getParameter('images_constat_mecanique').'/'.$nom);
            $constatMecaniqueRepository->remove($constatMecanique, true);
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
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
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_expertise_mecanique', ['id' => $id], Response::HTTP_SEE_OTHER);
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
      
}
