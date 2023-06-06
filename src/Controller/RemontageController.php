<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\RemontagePhoto;
use App\Entity\RemontagePalier;
use App\Form\RemontagePhotoType;
use App\Form\RemontagePalierType;
use App\Entity\RemontageEquilibrage;
use App\Form\RemontageEquilibrageType;
use App\Repository\RemontagePhotoRepository;
use App\Repository\RemontagePalierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RemontageEquilibrageRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/remontage')]
class RemontageController extends AbstractController
{
    #[Route('/index/{id}', name: 'app_remontage_index')]
    public function index(
        Parametre $parametre,
        Request $request,
        SluggerInterface $slugger,
        RemontagePalierRepository $remontagePalierRepository,
        RemontageEquilibrageRepository $remontageEquilibrageRepository,
        RemontagePhotoRepository $remontagePhotoRepository
    ): Response
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
                $this->redirectToRoute('app_remontage_index', ['id' => $parametre->getId()]);

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
                $this->redirectToRoute('app_remontage_index', ['id' => $parametre->getId()]);
            }            

        }

        //la partie de remontage de palier
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
                $this->redirectToRoute('app_remontage_index', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'remontage_equilibrage_terminer')
            {
                $parametre->setRemontageEquilibrage($remontageEquilibrage);
                $remontageEquilibrage->setEtat(1);
                $remontageEquilibrageRepository->save($remontageEquilibrage, true);
                $this->redirectToRoute('app_remontage_index', ['id' => $parametre->getId()]);
            }            
        }

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
                $this->redirectToRoute('app_remontage_index', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('remontage/index.html.twig', [
            'parametre' => $parametre,
            'remontagePalier' => $remontagePalier,
            'formRemontagePalier' => $formRemontagePalier->createView(),
            'formRemontageEquilibrage' => $formRemontageEquilibrage->createView(),
            'formRemontagePhoto' => $formRemontagePhoto->createView()
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
            return $this->redirectToRoute('app_remontage_index', ['id' => $id], Response::HTTP_SEE_OTHER);

        }
        else
        {
            return $this->redirectToRoute('app_remontage_index', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }
}
