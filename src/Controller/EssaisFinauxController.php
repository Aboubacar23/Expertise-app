<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Service\MailerService;
use App\Entity\AppareilMesureEssais;
use App\Entity\MesureIsolementEssai;
use App\Entity\LMesureIsolementEssai;
use App\Entity\MesureResistanceEssai;
use App\Entity\LMesureResistanceEssai;
use App\Entity\MesureVibratoireEssais;
use App\Form\AppareilMesureEssaisType;
use App\Form\MesureIsolementEssaiType;
use App\Entity\PointFonctionnementVide;
use App\Form\LMesureIsolementEssaiType;
use App\Form\LMesureReistanceEssaiType;
use App\Form\MesureResistanceEssaiType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Form\MesureVibratoireEssaisType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PointFonctionnementVideType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ControleIsolementRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AppareilMesureEssaisRepository;
use App\Repository\MesureIsolementEssaiRepository;
use App\Repository\LMesureIsolementEssaiRepository;
use App\Repository\MesureResistanceEssaiRepository;
use App\Repository\LMesureResistanceEssaiRepository;
use App\Repository\MesureVibratoireEssaisRepository;
use App\Repository\PointFonctionnementVideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/essais-finaux')]
class EssaisFinauxController extends AbstractController
{
    #[Route('/index-essais/{id}', name: 'app_essais_finaux', methods: ['GET','POST'])]
    public function index(Parametre $parametre): Response
    {
        return $this->render('essais_finaux/index.html.twig', [
            'parametre' => $parametre,
        ]);
    }
 
    //création de mesure d'isolement
    #[Route('/mesure-isolement/{id}', name: 'app_mesure_isolement_essai', methods: ['POST', 'GET'])]
    public function mesureIso(Parametre $parametre,Request $request,MesureIsolementEssaiRepository $mesureIsolementRepository,EntityManagerInterface $em,ControleIsolementRepository $controleIsolementRepository): Response
    {
        //Mesure d'isolement
        $mesureIsolement = new MesureIsolementEssai();
        $lmesureIsolement = new LMesureIsolementEssai();
        $val = 0;
        if($parametre->getMesureIsolementEssai()){
            $mesureIsolement = $parametre->getMesureIsolementEssai()->getParametre()->getMesureIsolementEssai();
            $val = 1;
        }
        $formMesureIsolement = $this->createForm(MesureIsolementEssaiType::class, $mesureIsolement);
        $form = $this->createForm(LMesureIsolementEssaiType::class, $lmesureIsolement);
        
        $formMesureIsolement->handleRequest($request);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tablesEssais = $session->get('essais', []);

        if($formMesureIsolement->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton7');
            if($choix == 'mesure_isolement_en_cours')
            {
                $i = 0;
                foreach($tablesEssais as $item)
                {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolementEssai();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setTempCorrection($item->getTempCorrection());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolementEssai($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolementEssai($mesureIsolement);
                $mesureIsolement->setEtat(0);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_isolement_terminer')
            {
                $i = 0;
                foreach($tablesEssais as $item)
                {
                    $i = $i + 1;
                    $lmesureIsolement = new LMesureIsolementEssai();
                    $lmesureIsolement->setLig($i);
                    $lmesureIsolement->setType($item->getType());
                    $lmesureIsolement->setControle($item->getControle());
                    $lmesureIsolement->setCritere($item->getCritere());
                    $lmesureIsolement->setTension($item->getTension());
                    $lmesureIsolement->setValeur($item->getValeur());
                    $lmesureIsolement->setUnite($item->getUnite());
                    $lmesureIsolement->setTempCorrection($item->getTempCorrection());
                    $lmesureIsolement->setConformite($item->getConformite());
                    $lmesureIsolement->setMesureIsolementEssai($mesureIsolement);
                    $em->persist($lmesureIsolement);
                }
                $parametre->setMesureIsolementEssai($mesureIsolement);
                $mesureIsolement->setEtat(1);
                $mesureIsolementRepository->save($mesureIsolement, true);
                $session->clear();
                return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'ajouter')
            {
                $lig = sizeof($tablesEssais)+1;
                $lmesureIsolement->setLig($lig);
                foreach($tablesEssais as $i)
                {
                    if($i->getType() == $lmesureIsolement->getType() and $i->getControle() == $lmesureIsolement->getControle() and $i->getTension() == $lmesureIsolement->getTension())
                    {                    
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
                    }
                }

                if ($parametre->getMesureIsolementEssai())
                {
                    foreach($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais() as $j)
                    {
                        if($j->getType() == $lmesureIsolement->getType() and $j->getControle() == $lmesureIsolement->getControle() and $j->getTension() == $lmesureIsolement->getTension())
                        {                    
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_mesure_isolement_essai', ['id' => $parametre->getId()]);
                        }
                    }
                }
                $tablesEssais[$lig] = $lmesureIsolement;
                $session->set('essais', $tablesEssais);
            }
        }  

        return $this->render('essais_finaux/mesure_isolement.html.twig', [
            'parametre' => $parametre,
            'formMesureIsolement' => $formMesureIsolement->createView(),
            'form'=>$form->createView(),
            'items' => $tablesEssais,
            'val' => $val,
            'listes_controles' => $controleIsolementRepository->findAll(),
        ]);
    }

    //création de point de fonctionnement
    #[Route('/point-fonctionnement/{id}', name: 'app_point_fonctionnement_vide', methods: ['POST', 'GET'])]
    public function pointFonctionnement(Parametre $parametre,Request $request,EntityManagerInterface $em,SluggerInterface $slugger): Response
    {
            //la partie point de fonctionnement
        $pointFonctionnement = new PointFonctionnementVide();

        $formPointFonctionnement = $this->createForm(PointFonctionnementVideType::class, $pointFonctionnement);
        $formPointFonctionnement->handleRequest($request);

        if($formPointFonctionnement->isSubmitted() && $formPointFonctionnement->isValid())
        {
            $choix = $request->get('bouton9');
            if($choix == 'ajouter')
            {
                $image = $formPointFonctionnement->get('image')->getData();
                if ($image) {
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        $image->move(
                            $this->getParameter('point_fonctionnement_vide'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}
                    
                    $pointFonctionnement->setImage($newPhotoname);
                } 

                $pointFonctionnement->setParametre($parametre);
                $em->persist($pointFonctionnement);
                $em->flush();
                return $this->redirectToRoute('app_point_fonctionnement_vide', ['id' => $parametre->getId()]);
            }
        }

        //6
        return $this->render('essais_finaux/point_fonctionnement.html.twig', [
            'parametre' => $parametre,
            'formPointFonctionnement' => $formPointFonctionnement->createView(),
        ]);
    }    

    //création de mesure vibratoire
    #[Route('/mesure-vibratoire/{id}', name: 'app_mesure_vibratoire_essais', methods: ['POST', 'GET'])]
    public function mesureVibratoire(Parametre $parametre,Request $request,MesureVibratoireEssaisRepository $mesureVibratoireEssaisRepository): Response
    {
            
        //la partie du mesures vibratoires
        $mesureVibratoire = new MesureVibratoireEssais();
        if($parametre->getMesureVibratoireEssais()){
            $mesureVibratoire = $parametre->getMesureVibratoireEssais()->getParametre()->getMesureVibratoireEssais();
        }

        $formMesureVibratoire = $this->createForm(MesureVibratoireEssaisType::class, $mesureVibratoire);
        $formMesureVibratoire->handleRequest($request);
        
        if($formMesureVibratoire->isSubmitted() && $formMesureVibratoire->isValid())
        {
            $choix = $request->get('bouton2');
            if($choix == 'essai_en_cours')
            {
                $parametre->setMesureVibratoireEssais($mesureVibratoire);
                $mesureVibratoire->setEtat(0);
                $mesureVibratoireEssaisRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire_essais', ['id' => $parametre->getId()]);

            }
            elseif($choix == 'essai_terminer')
            {
                $parametre->setMesureVibratoireEssais($mesureVibratoire);
                $mesureVibratoire->setEtat(1);
                $mesureVibratoireEssaisRepository->save($mesureVibratoire, true);
                $this->redirectToRoute('app_mesure_vibratoire_essais', ['id' => $parametre->getId()]);
            }
        }

        return $this->render('essais_finaux/mesure_vibratoire.html.twig', [
                'parametre' => $parametre,
                'formMesureVibratoire'=> $formMesureVibratoire->createView(),]);
    }
    
    //appareil de mesure
    #[Route('/appareil-mesure/{id}', name: 'app_appareil_essais')]
    public function apparielMesure(Parametre $parametre,Request $request,AppareilMesureEssaisRepository $appareilMesureEssaisRepository): Response
    {     
        //la partie appareil de mesure
        $appareil = new AppareilMesureEssais();

        $formAppareil = $this->createForm(AppareilMesureEssaisType::class, $appareil);
        $formAppareil->handleRequest($request);
        $date = date('Y-m-d');
        if($formAppareil->isSubmitted() && $formAppareil->isValid())
        {
            $choix = $request->get('bouton5');
            if($choix == 'ajouter')
            {
                $dateAppareil = $appareil->getAppareil()->getDateValidite()->format('Y-m-d');
                if($dateAppareil < $date){
                    $this->addFlash("message", "L'appareil que vous venez de choisir à expirer et la date de validité est : ".$dateAppareil);
                }else{
                    $appareil->setParametre($parametre);
                    $appareilMesureEssaisRepository->save($appareil, true);
                    $this->redirectToRoute('app_essais_finaux', ['id' => $parametre->getId()]);
                }
            }
        }
        
        return $this->render('essais_finaux/appareil_mesure.html.twig', [
            'parametre' => $parametre,
            'formAppareil' => $formAppareil->createView(),
        ]);
    }

    //valider essais finaux
    #[Route('/validation/{id}', name: 'valider_essais_finaux', methods: ['GET'])]
    public function validation(Parametre $parametre, EntityManagerInterface $entityManager,MailerService $mailerService): Response
    {
        if($parametre)
        {
            $dossier = 'email/email.html.twig';
            $email = $parametre->getAffaire()->getSuiviPar()->getEmail();
            $subject = "Essais Finaux";

            $cdp = $parametre->getAffaire()->getSuiviPar()->getNom()." "
                        .$parametre->getAffaire()->getSuiviPar()->getPrenom();

            $message = "Vous avez une validation des essais Finaux";
            $user = $this->getUser()->getNom()." ".$this->getUser()->getPrenom();
            $num_affaire = " Num d'affaire : ".$parametre->getAffaire()->getNumAffaire();

            //envoyer le mail
            $mailerService->sendEmail($email,$subject,$message,$dossier,$user,$cdp,$num_affaire);

            $parametre->setEssaisFinaux(1);
            $entityManager->persist($parametre);
            $entityManager->flush();                
            $this->addFlash("success", "Bravo ".$this->getUser()->getNom()." ".$this->getUser()->getNom()." Vous avez validé les essais finaux");
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        }else
        {
            return $this->redirectToRoute('app_parametre_show', ['id' => $parametre->getId()], Response::HTTP_SEE_OTHER);
        } 
    }

    //la fonction qui supprime un point de fonctionnement
    #[Route('/fonctionnement/{id}/point', name: 'delete_point_fonctionnement_vide', methods: ['GET'])]
    public function deletePointFonctionnement(Request $request,PointFonctionnementVide $pointFonctionnementVide, PointFonctionnementVideRepository $pointFonctionnementVideRepository): Response
    {
        $id = $pointFonctionnementVide->getParametre()->getId();
        if($pointFonctionnementVide)
        {
             $nom = $pointFonctionnementVide->getImage();
             unlink($this->getParameter('point_fonctionnement_vide').'/'.$nom);
             $pointFonctionnementVideRepository->remove($pointFonctionnementVide, true);
             return $this->redirectToRoute('app_point_fonctionnement_vide', [ 'id' => $id ], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('app_point_fonctionnement_vide', [ 'id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }

    //delete session tables mesures isolement
    #[Route('/delete/{id}/{paramID}', name: 'delete_mesure_essai')]
    public function supprimeSession($id,$paramID,Request $request)
    {
        $session = $request->getSession();
        $tablesEssais = $session->get('essais', []);
        if (array_key_exists($id, $tablesEssais))
        {
            unset($tablesEssais[$id]);
            $session->set('essais',$tablesEssais);
        }
        return $this->redirectToRoute('app_mesure_isolement_essai',['id' => $paramID]); 
    } 

    //delete tables mesures isolement
    #[Route('/delete-lmesure-isolement/{id}/{id2}', name: 'delete_lmesure_isolement_essai')]
    public function supprimeLIsolement(LMesureIsolementEssai $lmesureIsolement,$id2,Request $request, LMesureIsolementEssaiRepository $lmesureIsolementRepository)
    {
        if ($lmesureIsolement)
        {
            $lmesureIsolementRepository->remove($lmesureIsolement, true);
            return $this->redirectToRoute('app_mesure_isolement_essai',['id' => $id2]); 
        }
    }


   //création de mesure d'resistance
   #[Route('/mesure-resistance-essai/{id}', name: 'app_mesure_resistance_essai', methods: ['POST','GET'])]
   public function mesureResistance(Parametre $parametre,Request $request,MesureResistanceEssaiRepository $mesureResistanceRepository,EntityManagerInterface $em): Response
   {
        //Mesure de resistance
        $mesureResistance = new MesureResistanceEssai();
        $lmesureResistance = new LMesureResistanceEssai();
        
        if($parametre->getMesureResistanceEssai()){
            $mesureResistance = $parametre->getMesureResistanceEssai()->getParametre()->getMesureResistanceEssai();
        }

        $formMesureResistance = $this->createForm(MesureResistanceEssaiType::class, $mesureResistance);
        $formMesureResistance->handleRequest($request);
        
        $form = $this->createForm(LMesureReistanceEssaiType::class, $lmesureResistance);
        $form->handleRequest($request);

        $session = $request->getSession();
        $tables = $session->get('resistances', []);


        if($formMesureResistance->isSubmitted() && $form->isSubmitted())
        {
            $choix = $request->get('bouton8');
            if($choix == 'mesure_resistance_en_cours')
            {
                $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistanceEssai();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setTempCorrection($item->getTempCorrection());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureReistanceEssai($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistanceEssai($mesureResistance);
                $mesureResistance->setEtat(0);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'mesure_resistance_terminer')
            {
                 $i = 0;
                foreach($tables as $item)
                {
                    $i = $i + 1;
                    $lmesureResistance = new LMesureResistanceEssai();
                    $lmesureResistance->setLig($i);
                    $lmesureResistance->setControle($item->getControle());
                    $lmesureResistance->setCritere($item->getCritere());
                    $lmesureResistance->setValeur($item->getValeur());
                    $lmesureResistance->setUnite($item->getUnite());
                    $lmesureResistance->setType($item->getType());
                    $lmesureResistance->setTempCorrection($item->getTempCorrection());
                    $lmesureResistance->setConformite($item->getConformite());
                    $lmesureResistance->setMesureReistanceEssai($mesureResistance);
                    $em->persist($lmesureResistance);
                }

                $parametre->setMesureResistanceEssai($mesureResistance);
                $mesureResistance->setEtat(1);
                $session->clear();
                $mesureResistanceRepository->save($mesureResistance, true);
                return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'ajouter')
            {
                $lig = sizeof($tables)+1;
                $lmesureResistance->setLig($lig);

                foreach($tables as $i)
                {                    
                    if($i->getType() == $lmesureResistance->getType() and $i->getControle() == $lmesureResistance->getControle())
                    {                    
                        $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                        return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
                    } 
                }

                if($parametre->getMesureResistanceEssai())
                {
                    foreach($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais() as $j)
                    {
                        if($j->getType() == $lmesureResistance->getType() and $j->getControle() == $lmesureResistance->getControle())
                        {                  
                            $this->addFlash("message", "Vous avez déjà ajouter ce contrôle");
                            return $this->redirectToRoute('app_mesure_resistance_essai', ['id' => $parametre->getId()]);
                        }
                    }
                }

                $tables[$lig] = $lmesureResistance;
                $session->set('resistances', $tables);
            }
        }

       //6
       return $this->render('essais_finaux/mesure_resistance.html.twig', [
           'parametre' => $parametre,
           'formMesureResistance' => $formMesureResistance->createView(),
           'form' => $form->createView(),
           'items' => $tables,
       ]);
   } 

    //delete session tables mesures resistance
    #[Route('/delete-lmesure-essais-resistance/{id}/{id2}', name: 'delete_lmesure_resistance_essai_session')]
    public function supprimeSessionResistance($id,$id2,Request $request)
    {
        $session = $request->getSession();
        $tables = $session->get('resistances', []);
        if (array_key_exists($id, $tables))
        {
            unset($tables[$id]);
            $session->set('resistances',$tables);
        }
        return $this->redirectToRoute('app_mesure_resistance_essai',['id' => $id2]); 
    } 
   
    //delete tables mesures resistance
    #[Route('/delete-lmesure-resistance/{id}/{id2}', name: 'delete_lmesure_essai_resistance')]
    public function supprimeLResistance(LMesureResistanceEssai $lMesureResistance,$id2,Request $request, LMesureResistanceEssaiRepository $lMesureResistanceRepository)
    {

        if ($lMesureResistance)
        {
            $lMesureResistanceRepository->remove($lMesureResistance, true);
            return $this->redirectToRoute('app_mesure_resistance_essai',['id' => $id2]); 
        }
    } 

}
