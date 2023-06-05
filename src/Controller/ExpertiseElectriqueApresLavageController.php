<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\SondeBobinage;
use App\Entity\Caracteristique;
use App\Form\SondeBobinageType;
use App\Entity\StatorApresLavage;
use App\Form\CaracteristiqueType;
use App\Form\StatorApresLavageType;
use App\Entity\AutreCaracteristique;
use App\Form\AutreCarateristiqueType;
use App\Entity\PointFonctionnementRotor;
use App\Form\PointFonctionnementRotorType;
use App\Repository\SondeBobinageRepository;
use App\Entity\AutrePointFonctionnementRotor;
use App\Form\AutrePointFonctionnementRotorType;
use App\Repository\CaracteristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\StatorApresLavageRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AutreCaracteristiqueRepository;
use App\Repository\PointFonctionnementRotorRepository;
use App\Repository\AutrePointFonctionnementRotorRepository;
use ContainerCJV8CA0\getAutrePointFonctionnementRotorTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/expertiseEpAL')]
class ExpertiseElectriqueApresLavageController extends AbstractController
{
    #[Route('/index/{id}', name: 'app_expertise_electrique_apres_lavage')]
    public function index(
        Parametre $parametre,
        Request $request,
        StatorApresLavageRepository $statorApresLavageRepository,
        SondeBobinageRepository $sondeBobinageRepository,
        CaracteristiqueRepository $caracteristiqueRepository,
        AutreCaracteristiqueRepository $autreCaracteristiqueRepository,
        PointFonctionnementRotorRepository $pointFonctionnementRotorRepository,
        AutrePointFonctionnementRotorRepository $autrePointFonctionnementRotorRepository
        ): Response
    {
        
        //stator après lavage
        $statorApresLavage = new StatorApresLavage();
        if($parametre->getStatorApresLavage()){
            $statorApresLavage = $parametre->getStatorApresLavage()->getParametre()->getStatorApresLavage();
        }

        $formStatorApresLavage = $this->createForm(StatorApresLavageType::class, $statorApresLavage);
        $formStatorApresLavage->handleRequest($request);
        if($formStatorApresLavage->isSubmitted() && $formStatorApresLavage->isValid())
        {
            $choix = $request->get('bouton1');
            if($choix == 'stator_en_cours')
            {
                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(0);
                $statorApresLavageRepository->save($statorApresLavage, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'stator_terminer')
            {
                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(1);
                $statorApresLavageRepository->save($statorApresLavage, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

        //sonde bobinage
        $sondeBobinage = new SondeBobinage();
        if($parametre->getSondeBobinage()){
            $sondeBobinage = $parametre->getSondeBobinage()->getParametre()->getSondeBobinage();
        }

        $formSondeBobinage = $this->createForm(SondeBobinageType::class, $sondeBobinage);
        $formSondeBobinage->handleRequest($request);
        if($formSondeBobinage->isSubmitted() && $formSondeBobinage->isValid())
        {
            $choix = $request->get('bouton2');
            if($choix == 'sonde_en_cours')
            {
                $parametre->setSondeBobinage($sondeBobinage);
                $sondeBobinage->setEtat(0);
                $sondeBobinageRepository->save($sondeBobinage, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'sonde_terminer')
            {
                $parametre->setSondeBobinage($sondeBobinage);
                $sondeBobinage->setEtat(1);
                $sondeBobinageRepository->save($sondeBobinage, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

         //Caractéristique à vide
         $caracteristique = new Caracteristique(); 
         $formCarateristique = $this->createForm(CaracteristiqueType::class, $caracteristique);
         $formCarateristique->handleRequest($request);

         if($formCarateristique->isSubmitted() && $formCarateristique->isValid())
         {
             $choix = $request->get('bouton3_1');
             if($choix == 'ajouter')
             {
                 $caracteristique->setParametre($parametre);
                 $caracteristiqueRepository->save($caracteristique, true);
                 $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
             }
         }        

         //autre caractéristique
        $autreCaracteristique = new AutreCaracteristique();
        if($parametre->getAutreCaracteristique()){
            $autreCaracteristique = $parametre->getAutreCaracteristique()->getParametre()->getAutreCaracteristique();
        }

        $formAutreCaracteristique = $this->createForm(AutreCarateristiqueType::class, $autreCaracteristique);
        $formAutreCaracteristique->handleRequest($request);
        if($formAutreCaracteristique->isSubmitted() && $formAutreCaracteristique->isValid())
        {
            $choix = $request->get('bouton3');
            if($choix == 'carac_en_cours')
            {
                $parametre->setAutreCaracteristique($autreCaracteristique);
                $autreCaracteristique->setEtat(0);
                $autreCaracteristiqueRepository->save($autreCaracteristique, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'carac_terminer')
            {
                $parametre->setAutreCaracteristique($autreCaracteristique);
                $autreCaracteristique->setEtat(1);
                $autreCaracteristiqueRepository->save($autreCaracteristique, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }

        //point de fonctionnement rotor
        $pointFonctionnementRotor = new PointFonctionnementRotor(); 
        $formPointFonctionnementRotor = $this->createForm(PointFonctionnementRotorType::class, $pointFonctionnementRotor);
        $formPointFonctionnementRotor->handleRequest($request);

        if($formPointFonctionnementRotor->isSubmitted() && $formPointFonctionnementRotor->isValid())
        {
            $choix = $request->get('bouton4_1');
            if($choix == 'ajouter')
            {
                $pointFonctionnementRotor->setParametre($parametre);
                $pointFonctionnementRotorRepository->save($pointFonctionnementRotor, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        } 

        //autre point de fonctionnement rotor
        $autrePointFonctionnementRotor = new AutrePointFonctionnementRotor(); 
        if($parametre->getAutrePointFonctionnementRotor()){
            $autrePointFonctionnementRotor = $parametre->getAutrePointFonctionnementRotor()->getParametre()->getAutrePointFonctionnementRotor();
        }

        $formAutrePointFonctionnementRotor = $this->createForm(AutrePointFonctionnementRotorType::class, $autrePointFonctionnementRotor);
        $formAutrePointFonctionnementRotor->handleRequest($request);
        if($formAutrePointFonctionnementRotor->isSubmitted() && $formAutrePointFonctionnementRotor->isValid())
        {
            $choix = $request->get('bouton4');
           // dd($choix);
            if($choix == 'autre_en_cours')
            {
                $parametre->setAutrePointFonctionnementRotor($autrePointFonctionnementRotor);
                $autrePointFonctionnementRotor->setEtat(0);
                $autrePointFonctionnementRotorRepository->save($autrePointFonctionnementRotor, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'autre_terminer')
            {
                $parametre->setAutrePointFonctionnementRotor($autrePointFonctionnementRotor);
                $autrePointFonctionnementRotor->setEtat(1);
                $autrePointFonctionnementRotorRepository->save($autrePointFonctionnementRotor, true);
                $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $parametre->getId()]);
            }
        }


        return $this->render('expertise_electrique_apres_lavage/index.html.twig', [
            'parametre' => $parametre,
            'formStatorApresLavage' => $formStatorApresLavage->createView(),
            'formSondeBobinage' => $formSondeBobinage->createView(),
            'formCarateristique' => $formCarateristique->createView(),
            'formAutreCaracteristique' => $formAutreCaracteristique->createView(),
            'formPointFonctionnementRotor' => $formPointFonctionnementRotor->createView(),
            'formAutrePointFonctionnementRotor' => $formAutrePointFonctionnementRotor->createView()
        ]);
    }

    //Supprimer carcatéristique
    #[Route('constat/{id}/electrique', name: 'delete_caracteristique', methods: ['GET'])]
    public function deleteConstat(Caracteristique $caracteristique,CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        $id = $caracteristique->getParametre()->getId();
        if($caracteristique)
        {
        $caracteristiqueRepository->remove($caracteristique, true);
        return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
            
    }

    //Supprimer carcatéristique
    #[Route('point/{id}/fonctionnement', name: 'delete_point', methods: ['GET'])]
    public function deletePoint(PointFonctionnementRotor $pointFonctionnementRotor,PointFonctionnementRotorRepository $pointFonctionnementRotorRepository): Response
    {
        $id = $pointFonctionnementRotor->getParametre()->getId();
        if($pointFonctionnementRotor)
        {
        $pointFonctionnementRotorRepository->remove($pointFonctionnementRotor, true);
        return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
            
    }
        
}
