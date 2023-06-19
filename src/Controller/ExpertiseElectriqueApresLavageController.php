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
use App\Entity\AppareilMesureElectrique;
use App\Entity\PointFonctionnementRotor;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AppareilMesureElectriqueType;
use App\Form\PointFonctionnementRotorType;
use App\Repository\SondeBobinageRepository;
use App\Entity\ConstatElectriqueApresLavage;
use App\Entity\AutrePointFonctionnementRotor;
use App\Entity\LStatorApresLavage;
use App\Repository\CaracteristiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ConstatElectriqueApresLavageType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\AutrePointFonctionnementRotorType;
use App\Form\LStatorApresLavageType;
use App\Repository\StatorApresLavageRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AutreCaracteristiqueRepository;
use App\Repository\AppareilMesureElectriqueRepository;
use App\Repository\PointFonctionnementRotorRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\ConstatElectriqueApresLavageRepository;
use App\Repository\AutrePointFonctionnementRotorRepository;
use App\Repository\LStatorApresLavageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/expertiseEpAL')]
class ExpertiseElectriqueApresLavageController extends AbstractController
{
    #[Route('/index/{id}', name: 'app_expertise_electrique_apres_lavage')]
    public function index(Parametre $parametre): Response
    {    
        return $this->render('expertise_electrique_apres_lavage/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    //stator après lavage
    #[Route('/stator/{id}', name: 'app_stator_apres_lavage')]
    public function stator(Parametre $parametre,Request $request,EntityManagerInterface $em,StatorApresLavageRepository $statorApresLavageRepository,): Response
    {  
        //stator après lavage
        $statorApresLavage = new StatorApresLavage();
        $lstatorApresLavage = new LStatorApresLavage();
        if($parametre->getStatorApresLavage()){
            $statorApresLavage = $parametre->getStatorApresLavage()->getParametre()->getStatorApresLavage();
        }

        $formStatorApresLavage = $this->createForm(StatorApresLavageType::class, $statorApresLavage);
        $form = $this->createForm(LStatorApresLavageType::class, $lstatorApresLavage);
        $formStatorApresLavage->handleRequest($request);
        $form->handleRequest($request);


        $session = $request->getSession();
        $listes = $session->get('stators', []);

        if($formStatorApresLavage->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton1');
            if($choix == 'stator_en_cours')
            {
                $i = 0;
                foreach($listes as $item)
                {
                    $i = $i + 1;
                    $lstatorApresLavage = new LStatorApresLavage();
                    $lstatorApresLavage->setLig($i);
                    $lstatorApresLavage->setControle($item->getControle());
                    $lstatorApresLavage->setCritere($item->getCritere());
                    $lstatorApresLavage->setValeur($item->getValeur());
                    $lstatorApresLavage->setTensionEssai($item->getTensionEssai());
                    $lstatorApresLavage->setValeurRelevee($item->getValeurRelevee());
                    $lstatorApresLavage->setConformite($item->getConformite());
                    $lstatorApresLavage->setStatorApresLavage($statorApresLavage);
                    $em->persist($lstatorApresLavage);
                }

                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(0);
                $session->clear();
                $statorApresLavageRepository->save($statorApresLavage, true);
                $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'stator_terminer')
            {
                $i = 0;
                foreach($listes as $item)
                {
                    $i = $i + 1;
                    $lstatorApresLavage = new LStatorApresLavage();
                    $lstatorApresLavage->setLig($i);
                    $lstatorApresLavage->setControle($item->getControle());
                    $lstatorApresLavage->setCritere($item->getCritere());
                    $lstatorApresLavage->setValeur($item->getValeur());
                    $lstatorApresLavage->setTensionEssai($item->getTensionEssai());
                    $lstatorApresLavage->setValeurRelevee($item->getValeurRelevee());
                    $lstatorApresLavage->setConformite($item->getConformite());
                    $lstatorApresLavage->setStatorApresLavage($statorApresLavage);
                    $em->persist($lstatorApresLavage);
                }

                $parametre->setStatorApresLavage($statorApresLavage);
                $statorApresLavage->setEtat(1);
                $session->clear();
                $statorApresLavageRepository->save($statorApresLavage, true);
                $this->redirectToRoute('app_stator_apres_lavage', ['id' => $parametre->getId()]);
                
            }elseif($choix == 'ajouter')
            {
               foreach($parametre->getMesureIsolement()->getLMesureIsolements() as $item)
               {
                    if($item->getControle() == $lstatorApresLavage->getControle())
                    {
                      $lstatorApresLavage->setValeurRelevee($item->getValeur());
                    }else{
                        $lstatorApresLavage->setValeurRelevee(0);
                    }
               }
                $lig = sizeof($listes)+1;
                $lstatorApresLavage->setLig($lig);
                $listes[$lig] = $lstatorApresLavage;
                $session->set('stators', $listes);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/stator.html.twig', [
            'parametre' => $parametre,
            'formStatorApresLavage' => $formStatorApresLavage->createView(),
            'form'=>$form->createView(),
            'items' => $listes,
        ]);
    }

     //sonde à bobinage
    #[Route('/sonde-bobinage/{id}', name: 'app_sonde_bobinage')]
    public function sonde(Parametre $parametre,Request $request,SondeBobinageRepository $sondeBobinageRepository): Response
    {
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
                $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'sonde_terminer')
            {
                $parametre->setSondeBobinage($sondeBobinage);
                $sondeBobinage->setEtat(1);
                $sondeBobinageRepository->save($sondeBobinage, true);
                $this->redirectToRoute('app_sonde_bobinage', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('expertise_electrique_apres_lavage/sonde_bobinage.html.twig', [
            'parametre' => $parametre,
            'formSondeBobinage' => $formSondeBobinage->createView(),
        ]);
    }

    ///Caractéristique à vide
    #[Route('/caracteristique/{id}', name: 'app_caracteristique')]
    public function caractéristique(Parametre $parametre,Request $request,AutreCaracteristiqueRepository $autreCaracteristiqueRepository,CaracteristiqueRepository $caracteristiqueRepository): Response
    {
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
       
 
         return $this->render('expertise_electrique_apres_lavage/caracteristique_vite.html.twig', [
             'parametre' => $parametre,
             'formCarateristique' => $formCarateristique->createView(),
             'formAutreCaracteristique' => $formAutreCaracteristique->createView(),
         ]);
    } 
     
    //point de fonctionnement
    #[Route('/autre-fonctionnement/{id}', name: 'app_fonctionnement')]
    public function fonctionnement(Parametre $parametre,Request $request,AutrePointFonctionnementRotorRepository $autrePointFonctionnementRotorRepository, PointFonctionnementRotorRepository $pointFonctionnementRotorRepository): Response
    {     
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
        
        return $this->render('expertise_electrique_apres_lavage/point_fonctionnement.html.twig', [
            'parametre' => $parametre,
            'formPointFonctionnementRotor' => $formPointFonctionnementRotor->createView(),
            'formAutrePointFonctionnementRotor' => $formAutrePointFonctionnementRotor->createView(),
        ]);
    }

    //appareil de mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_mesure_expertise_apres_lavage')]
    public function apparielMesure(Parametre $parametre,Request $request,AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository): Response
    {     
        //la partie appareil de mesure
        $appareilMesureElectrique = new AppareilMesureElectrique();

        $formAppareilMesureElectrique = $this->createForm(AppareilMesureElectriqueType::class, $appareilMesureElectrique);
        $formAppareilMesureElectrique->handleRequest($request);
        $date = date('Y-m-d');
        if($formAppareilMesureElectrique->isSubmitted() && $formAppareilMesureElectrique->isValid())
        {
            $choix = $request->get('bouton5');
            if($choix == 'ajouter')
            {
                $dateAppareil = $appareilMesureElectrique->getAppareil()->getDateValidite()->format('Y-m-d');
                if($dateAppareil < $date){
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : ".$dateAppareil);
                }else{
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

    //appareil de mesure
    #[Route('/constact/{id}', name: 'app_constact_expertise_apres_lavage')]
    public function constact(Parametre $parametre,Request $request,SluggerInterface $slugger,ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository): Response
    {     
        //la partie constat electrique après lavage
        $constatElectriqueApresLavage = new ConstatElectriqueApresLavage();
        $formConstatElectriqueApresLavage = $this->createForm(ConstatElectriqueApresLavageType::class, $constatElectriqueApresLavage);
        $formConstatElectriqueApresLavage->handleRequest($request);
        if($formConstatElectriqueApresLavage->isSubmitted() && $formConstatElectriqueApresLavage->isValid())
        {
            $choix = $request->get('bouton6');
            if($choix == 'ajouter')
            {
                $image = $formConstatElectriqueApresLavage->get('photo')->getData();
                if ($image)
                {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('images_constat_electrique_apres_lavage'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}

                    $constatElectriqueApresLavage->setPhoto($newPhotoname);
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

    //Supprimer carcatéristique
    #[Route('caracteristique/{id}', name: 'delete_caracteristique', methods: ['GET'])]
    public function deleteCaract(Caracteristique $caracteristique,CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        $id = $caracteristique->getParametre()->getId();
        if($caracteristique)
        {
            $caracteristiqueRepository->remove($caracteristique, true);
            return $this->redirectToRoute('app_caracteristique', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_caracteristique', ['id' => $id], Response::HTTP_SEE_OTHER);
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
            return $this->redirectToRoute('app_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_fonctionnement', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
            
    }

    //la fonction qui valide l'expertise
    #[Route('validation/{id}', name: 'valider_expertise_electrique_apres_lavage', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager): Response
    {
        if($parametre)
        {
            $parametre->setExpertiseElectiqueApresLavage(1);
            $entityManager->persist($parametre);
            $entityManager->flush();
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }else
        {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } 
    }

     //la fonction qui supprime un point de fonctionnement
     #[Route('constat/{id}/electrique', name: 'delete_constat_electrique_apres_lavage', methods: ['GET'])]
    public function deleteConstat(ConstatElectriqueApresLavage $constatElectriqueApresLavage,ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository): Response
    {
        $id = $constatElectriqueApresLavage->getParametre()->getId();
        if($constatElectriqueApresLavage)
        {
            $nom = $constatElectriqueApresLavage->getPhoto();
            if($constatElectriqueApresLavage->getPhoto())
            {
                unlink($this->getParameter('images_constat_electrique_apres_lavage').'/'.$nom);
            }
            $constatElectriqueApresLavageRepository->remove($constatElectriqueApresLavage, true);
            return $this->redirectToRoute('app_constact_expertise_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_constact_expertise_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
           
    }
        
    //delete session tables mesures resistance
    #[Route('/stator-apres-session/{id}/{id2}', name: 'delete_stator_session')]
    public function supprimeSessionResistance($id,$id2,Request $request)
    {
        $session = $request->getSession();
        $listes = $session->get('stators', []);
        if (array_key_exists($id, $listes))
        {
            unset($listes[$id]);
            $session->set('stators',$listes);
        }
        return $this->redirectToRoute('app_stator_apres_lavage',['id' => $id2]); 
    } 

    //delete tables mesures resistance
    #[Route('/stator-apres-lavage/{id}/{id2}', name: 'delete_stator_apres_session_lavage')]
    public function supprimeLResistance2(LStatorApresLavage $lstatorApresLavage,$id2,Request $request,LStatorApresLavageRepository $lstatorApresLavageRepository )
    {
        if ($lstatorApresLavage)
        {
            $lstatorApresLavageRepository->remove($lstatorApresLavage, true);
            return $this->redirectToRoute('app_stator_apres_lavage',['id' => $id2]); 
        }
    } 
}
