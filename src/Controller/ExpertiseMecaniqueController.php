<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\ControleGeometrique;
use App\Form\ControleGeometriqueType;
use App\Entity\ControleVisuelMecanique;
use App\Entity\AccessoireSupplementaire;
use App\Entity\ControleMontageConssinet;
use App\Entity\ControleMontageRoulement;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ControleVisuelMecaniqueType;
use App\Form\AccessoireSupplementaireType;
use App\Form\ControleMontageCoussinetType;
use App\Form\ControleMontageRoulementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ControleVisuelMecaniqueRepository;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\ControleGeometriqueRepository;
use App\Repository\ControleMontageConssinetRepository;
use App\Repository\ControleMontageRoulementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/expertiseMecanique')]
class ExpertiseMecaniqueController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}


    #[Route('/index/{id}/mecanique', name: 'app_expertise_mecanique')]
    public function index(
        Parametre $parametre, Request $request,
        ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,
        AccessoireSupplementaireRepository $accessoireSupplementaireRepository,
        ControleMontageRoulementRepository $controleMontageRoulementRepository,
        ControleMontageConssinetRepository $controleMontageConssinetRepository,
        ControleGeometriqueRepository $controleGeometriqueRepository
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

        return $this->render('expertise_mecanique/index.html.twig', [
            'parametre' => $parametre,
            'formAccessoire' => $formAccessoire->createView(),
            'formControlevisuelMecanque' => $formControlevisuelMecanque->createView(),
            'formControlMontageRoulement' => $formControlMontageRoulement->createView(),
            'formControlMontageCoussinet' => $formControlMontageCoussinet->createView(),
            'formControlGeometrique' => $formControlGeometrique->createView(),
            'accessoires' => $tables,
            'controleVisuelMecanique' => $controleVisuelMecanique,
            
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
}
