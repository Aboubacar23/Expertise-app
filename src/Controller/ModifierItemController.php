<?php

namespace App\Controller;

use App\Entity\AccessoireSupplementaire;
use App\Entity\LMesureIsolement;
use App\Entity\ReleveDimmensionnel;
use App\Entity\Synoptique;
use App\Form\AccessoireSupplementaireType;
use App\Form\LMesureIsolementType;
use App\Form\ReleveDimmensionnelType;
use App\Form\SynoptiqueType;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\ControleIsolementRepository;
use App\Repository\LMesureIsolementRepository;
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

      //création de mesure d'isolement
      #[Route('/modifier/{id}/isolement', name: 'app_edit_mesure_isolement', methods: ['POST', 'GET'])]
      public function mesureIso(LMesureIsolement $lmesureIsolement, Request $request, LMesureIsolementRepository $LMesureIsolementRepository, EntityManagerInterface $em, ControleIsolementRepository $controleIsolementRepository): Response
      {
          $form = $this->createForm(LMesureIsolementType::class, $lmesureIsolement);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid())
          {
              $LMesureIsolementRepository->save($lmesureIsolement, true);
              return $this->redirectToRoute('app_mesure_isolement', ['id' => $lmesureIsolement->getMesureIsolement()->getParametre()->getId()]);
          }

          return $this->render('modifier_item/mesure_isolement.html.twig', [
              'parametre' =>$lmesureIsolement->getMesureIsolement()->getParametre(),
              'form' => $form->createView(),
              'LmesureIsolement' =>$lmesureIsolement,
              'listes_controles' => $controleIsolementRepository->findAll(),
          ]);
      }
}
