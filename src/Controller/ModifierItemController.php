<?php

namespace App\Controller;

use App\Entity\AccessoireSupplementaire;
use App\Entity\LMesureIsolement;
use App\Entity\LMesureResistance;
use App\Entity\ReleveDimmensionnel;
use App\Entity\Synoptique;
use App\Form\AccessoireSupplementaireType;
use App\Form\LMesureIsolementEditType;
use App\Form\LMesureIsolementType;
use App\Form\LMesureResistanceEditType;
use App\Form\LMesureResistanceType;
use App\Form\ReleveDimmensionnelType;
use App\Form\SynoptiqueType;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\ControleIsolementRepository;
use App\Repository\LMesureIsolementRepository;
use App\Repository\LMesureResistanceRepository;
use App\Repository\ReleveDimmensionnelRepository;
use App\Repository\SynoptiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/modifier-item')]
class ModifierItemController extends AbstractController
{
    #[Route('/modifier/{id}/synoptique', name: 'app_edit_synoptique', methods: ['GET','POST'])]
    public function synoptique(Synoptique $synoptique, SynoptiqueRepository $synoptiqueRepository, Request $request) : Response
    {
        $form = $this->createForm(SynoptiqueType::class, $synoptique);
        $form->handleRequest($request);
        //dd($synoptique);

        if ($form->isSubmitted() && $form->isValid())
        {
            $synoptiqueRepository->save($synoptique, true);
            return $this->redirectToRoute('app_synoptique', ['id' => $synoptique->getParametre()->getId()]);
        }
        return $this->render('modifier_item/synoptique.html.twig', [
            'synoptique' => $synoptique,
            'form' => $form->createView()

        ]);
    }

    #[Route('/modifier/{id}/controle', name: 'app_edit_controle', methods: ['GET','POST'])]
    public function consoleVisuel(AccessoireSupplementaire $accessoireSupplementaire, Request $request, AccessoireSupplementaireRepository $accessoireSupplementaireRepository): Response
    {
        $form = $this->createForm(AccessoireSupplementaireType::class, $accessoireSupplementaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isSubmitted())
        {
            $accessoireSupplementaireRepository->save($accessoireSupplementaire, true);
            return  $this->redirectToRoute('app_controle_visuel_mecanique', ['id' => $accessoireSupplementaire->getControleVisuelMecanique()->getParametre()->getId()]);
        }


        return $this->render('modifier_item/controle_visuel.html.twig', [
            'form' => $form->createView(),
            'accessoireSupplementaire' => $accessoireSupplementaire,

        ]);
    }

    #[Route('/modifier/{id}/releve', name: 'app_edit_releve', methods: ['GET','POST'])]
    public function releveDimensionnel(ReleveDimmensionnelRepository $releveDimmensionnelRepository, ReleveDimmensionnel $releveDimmensionnel, Request $request): Response
    {
        //la partie relevés dimmensionnel rotor et paliers
        $formReleveDimmensionnel = $this->createForm(ReleveDimmensionnelType::class, $releveDimmensionnel);
        $formReleveDimmensionnel->handleRequest($request);

        if ($formReleveDimmensionnel->isSubmitted() && $formReleveDimmensionnel->isValid())
        {
            $releveDimmensionnelRepository->save($releveDimmensionnel, true);
            return $this->redirectToRoute('app_releve_dimensionnel', ['id' => $releveDimmensionnel->getParametre()->getId()]);
        }


        return $this->render('modifier_item/releve_dimensionnels.html.twig', [
            'releveDimmensionnel' => $releveDimmensionnel,
            'formReleveDimmensionnel' => $formReleveDimmensionnel->createView()

        ]);
    }

      //modification de mesure d'isolement
      #[Route('/modifier-isolement/{id}', name: 'app_edit_mesure_isolement', methods: ['POST', 'GET'])]
      public function mesureIsolement(LMesureIsolement $lmesureIsolement, Request $request, LMesureIsolementRepository $lMesureIsolementRepository): Response
      {
          $form = $this->createForm(LMesureIsolementEditType::class, $lmesureIsolement);
          $form->handleRequest($request);
        
          if ($form->isSubmitted() && $form->isValid())
          {
            if (is_int($lmesureIsolement->getValeur()))
            {
                $valeur = $lmesureIsolement->getValeur();
            }else{
                $valeur = $lmesureIsolement->getValeur();
                //$valeur =  number_format($lmesureIsolement->getValeur(), 1, '.', '');
            }

            if (is_int($lmesureIsolement->getTempCorrection()))
            {
                $temp = $lmesureIsolement->getTempCorrection();
            }else{
                //$temp = $lmesureIsolement->getTempCorrection();
                $temp =  number_format($lmesureIsolement->getTempCorrection(), 0, '.', '');
            }

            $lmesureIsolement->setValeur($valeur);
            $lmesureIsolement->setTempCorrection($temp);
            $lMesureIsolementRepository->save($lmesureIsolement, true);
            return $this->redirectToRoute('app_mesure_isolement', ['id' => $lmesureIsolement->getMesureIsolement()->getParametre()->getId()]);
          }
          
          //dd($lmesureIsolement->getMesureIsolement());
          return $this->render('modifier_item/mesure_isolement.html.twig', [
              'form' => $form->createView(),
              'LmesureIsolement' =>$lmesureIsolement,
              'mesureIsolement' =>$lmesureIsolement->getMesureIsolement(),
              'parametre' =>$lmesureIsolement->getMesureIsolement()->getParametre(),
          ]);
      }


      //modification de mesure d'isolement
      #[Route('/modifier-resistance/{id}', name: 'app_edit_mesure_resistance', methods: ['POST', 'GET'])]
      public function mesureResistance(LMesureResistance $lmesureResistance, Request $request, LMesureResistanceRepository $lMesureResistanceRepository): Response
      {
          $form = $this->createForm(LMesureResistanceEditType::class, $lmesureResistance);
          $form->handleRequest($request);
        
          if ($form->isSubmitted() && $form->isValid())
          {

            return $this->redirectToRoute('app_mesure_isolement', ['id' => $lmesureResistance->getMesureResistance()->getParametre()->getId()]);
          }
          
          //dd($lmesureIsolement->getMesureIsolement());
          return $this->render('modifier_item/mesure_resistance.html.twig', [
              'form' => $form->createView(),
              'lmesureResistance' =>$lmesureResistance,
              'mesureResistance' =>$lmesureResistance->getMesureResistance(),
              'parametre' =>$lmesureResistance->getMesureResistance()->getParametre(),
          ]);
      }
}
