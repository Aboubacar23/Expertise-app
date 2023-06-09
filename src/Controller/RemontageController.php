<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\RemontagePhoto;
use App\Entity\RemontagePalier;
use App\Form\RemontagePhotoType;
use App\Entity\RemontageFinition;
use App\Form\RemontagePalierType;
use App\Form\RemontageFinitionType;
use App\Entity\RemontageEquilibrage;
use App\Form\RemontageEquilibrageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RemontagePhotoRepository;
use App\Repository\RemontagePalierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RemontageFinitionRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RemontageEquilibrageRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/remontage')]
class RemontageController extends AbstractController
{
    #[Route('/index/{id}', name: 'app_remontage_index')]
    public function index(Parametre $parametre,): Response
    {
        return $this->render('remontage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    //le remontage de palier
    #[Route('/remontage-palier/{id}', name: 'app_remontage_palier', methods: ['GET','POST'])]
    public function remontagePalier(Parametre $parametre,Request $request,RemontagePalierRepository $remontagePalierRepository): Response
    {
        //la partie de remontage de palier
        $remontagePalier = new RemontagePalier();
        if ($parametre->getRemontagePalier()){
            $remontagePalier = $parametre->getRemontagePalier()->getParametre()->getRemontagePalier();
        }
        
        $formRemontagePalier = $this->createForm(RemontagePalierType::class, $remontagePalier);
        $formRemontagePalier->handleRequest($request);

        if ($formRemontagePalier->isSubmitted() && $formRemontagePalier->isValid())
        {
            $choix = $request->get('bouton1');
            if($choix ==  'remontage_palier_en_cours')
            {
                $caJeu = $remontagePalier->getCaa() + $remontagePalier->getCab() + $remontagePalier->getCac() + $remontagePalier->getCad();
                $coaJeu = $remontagePalier->getCoaa() + $remontagePalier->getCoab() + $remontagePalier->getCoac() + $remontagePalier->getCoad();
                $parametre->setRemontagePalier($remontagePalier);
                $remontagePalier->setEtat(0);
                $remontagePalier->setCaJeu($caJeu);
                $remontagePalier->setCoaJeu($coaJeu);
                $remontagePalierRepository->save($remontagePalier, true);
                $this->redirectToRoute('app_remontage_palier', ['id' => $parametre->getId()]);

            }
            elseif($choix == 'remontage_palier_terminer')
            {
                $caJeu = $remontagePalier->getCaa() + $remontagePalier->getCab() + $remontagePalier->getCac() + $remontagePalier->getCad();
                $coaJeu = $remontagePalier->getCoaa() + $remontagePalier->getCoab() + $remontagePalier->getCoac() + $remontagePalier->getCoad();
                $parametre->setRemontagePalier($remontagePalier);
                $remontagePalier->setEtat(1);
                $remontagePalier->setCaJeu($caJeu);
                $remontagePalier->setCoaJeu($coaJeu);
                $remontagePalierRepository->save($remontagePalier, true);
                $this->redirectToRoute('app_remontage_palier', ['id' => $parametre->getId()]);
            }            

        }

        return $this->render('remontage/remontage.html.twig', [
            'parametre' => $parametre,
            'remontagePalier' => $remontagePalier,
            'formRemontagePalier' => $formRemontagePalier->createView(),
        ]);
       
    } 

    //l'equilibrage
    #[Route('/equilibrage/{id}', name: 'app_equilibrage', methods: ['GET','POST'])]
    public function equilibrage(Parametre $parametre,Request $request,RemontageEquilibrageRepository $remontageEquilibrageRepository): Response
    {        
        //l'equilibrage
        $remontageEquilibrage = new RemontageEquilibrage();
        if ($parametre->getRemontageEquilibrage()){
            $remontageEquilibrage = $parametre->getRemontageEquilibrage()->getParametre()->getRemontageEquilibrage();
        }
        
        $formRemontageEquilibrage = $this->createForm(RemontageEquilibrageType::class, $remontageEquilibrage);
        $formRemontageEquilibrage->handleRequest($request);

        if ($formRemontageEquilibrage->isSubmitted() && $formRemontageEquilibrage->isValid())
        {
            $choix = $request->get('bouton2');
            if($choix == 'remontage_equilibrage_en_cours')
            {
                $parametre->setRemontageEquilibrage($remontageEquilibrage);
                $remontageEquilibrage->setEtat(0);
                $remontageEquilibrageRepository->save($remontageEquilibrage, true);
                $this->redirectToRoute('app_equilibrage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'remontage_equilibrage_terminer')
            {
                $parametre->setRemontageEquilibrage($remontageEquilibrage);
                $remontageEquilibrage->setEtat(1);
                $remontageEquilibrageRepository->save($remontageEquilibrage, true);
                $this->redirectToRoute('app_equilibrage', ['id' => $parametre->getId()]);
            }            
        }       

        return $this->render('remontage/equilibrage.html.twig', [
            'parametre' => $parametre,
            'formRemontageEquilibrage' => $formRemontageEquilibrage->createView(),
        ]);
       
    }


    //le remontage finition
    #[Route('/remontage-finition/{id}', name: 'app_remontage_finition', methods: ['GET','POST'])]
    public function remontageFinitions(Parametre $parametre,Request $request,RemontageFinitionRepository $remontageFinitionRepository): Response
    {        
        //la partie de remontage et finition
        $remontageFinition = new RemontageFinition();
        if ($parametre->getRemontageFinition()){
            $remontageFinition = $parametre->getRemontageFinition()->getParametre()->getRemontageFinition();
        }
        
        $formRemontageFinition = $this->createForm(RemontageFinitionType::class, $remontageFinition);
        $formRemontageFinition->handleRequest($request);

        if ($formRemontageFinition->isSubmitted() && $formRemontageFinition->isValid())
        {
            $choix = $request->get('bouton3');
            if($choix == 'remontage_finition_en_cours')
            {
                $parametre->setRemontageFinition($remontageFinition);
                $remontageFinition->setEtat(0);
                $remontageFinitionRepository->save($remontageFinition, true);
                $this->redirectToRoute('app_remontage_finition', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'remontage_finition_terminer')
            {
                $parametre->setRemontageFinition($remontageFinition);
                $remontageFinition->setEtat(1);
                $remontageFinitionRepository->save($remontageFinition, true);
                $this->redirectToRoute('app_remontage_finition', ['id' => $parametre->getId()]);
            }            
        }          

        return $this->render('remontage/remontage_finitions.html.twig', [
            'parametre' => $parametre,
            'formRemontageFinition' => $formRemontageFinition->createView()
        ]);       
    } 
    
    //la photo
    #[Route('/photo-remontage/{id}', name: 'app_photo_remontage', methods: ['GET','POST'])]
    public function photo(Parametre $parametre,Request $request,SluggerInterface $slugger,RemontagePhotoRepository $remontagePhotoRepository,): Response
    {        
         //la partie photo
         $remontagePhoto = new RemontagePhoto();

         $formRemontagePhoto = $this->createForm(RemontagePhotoType::class, $remontagePhoto);
         $formRemontagePhoto->handleRequest($request);
         if($formRemontagePhoto->isSubmitted() && $formRemontagePhoto->isValid())
         {
             $choix = $request->get('bouton4');
             $image = $formRemontagePhoto->get('image')->getData();
             if($choix == 'ajouter')
             {
                 if ($image)
                 {
                     $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                     $safePhotoname = $slugger->slug($originalePhoto);
                     $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                     try {
                         $image->move(
                             $this->getParameter('image_remontages'),
                             $newPhotoname
                         );
                     } catch (FileException $e){}
                     $remontagePhoto->setImage($newPhotoname);
                 }
                 $remontagePhoto->setParametre($parametre); 
                 $remontagePhotoRepository->save($remontagePhoto, true);
                 $this->redirectToRoute('app_photo_remontage', ['id' => $parametre->getId()]);
             }
         }

        return $this->render('remontage/photos.html.twig', [
            'parametre' => $parametre,
            'formRemontagePhoto' => $formRemontagePhoto->createView(),
        ]);       
    }

    //la fonction qui supprime une photo une fois ajouter
    #[Route('/photo/{id}/remontage', name: 'delete_photo_remontage', methods: ['GET'])]
    public function deletePhoto(RemontagePhoto $remontagePhoto, RemontagePhotoRepository $remontagePhotoRepository): Response
    {
        $id = $remontagePhoto->getParametre()->getId();
        if($remontagePhoto)
        {
            $nom = $remontagePhoto->getImage();
            unlink($this->getParameter('image_remontages').'/'.$nom);
            $remontagePhotoRepository->remove($remontagePhoto, true);
            return $this->redirectToRoute('app_photo_remontage', ['id' => $id], Response::HTTP_SEE_OTHER);

        }
        else
        {
            return $this->redirectToRoute('app_photo_remontage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    } 

    //la fonction qui valide remontage
    #[Route('validation/{id}/rapport', name: 'valider_remontage', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager): Response
    {
            if($parametre)
            { 
                $parametre->setRemontage(1);
                $parametre->setStatutFinal(1);
                $entityManager->persist($parametre);
                $entityManager->flush();
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
            } 
    }
}
