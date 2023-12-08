<?php

namespace App\Controller;

use App\Entity\Affaire;
use App\Entity\Atelier;
use App\Form\AtelierType;
use App\Entity\EtudesAchats;
use App\Form\EtudesAchatsType;
use App\Entity\RevueEnclenchement;
use App\Form\AtelierIndiceType;
use App\Form\RevueEnclenchementType;
use App\Repository\AtelierRepository;
use App\Repository\EtudesAchatsRepository;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RevueEnclenchementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Form\RevueEnclenchement2Type;

#[Route('/revue/enclenchement')]
class RevueEnclenchementController extends AbstractController
{
    #[Route('/', name: 'app_revue_enclenchement_index', methods: ['GET'])]
    public function index(RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        return $this->render('revue_enclenchement/index.html.twig', [
            'revue_enclenchements' => $revueEnclenchementRepository->findAll(),
        ]);
    }

    #[Route('/new-create/{id}', name: 'app_revue_enclenchement_new', methods: ['GET', 'POST'])]
    public function newIndiceA(Request $request,Affaire $affaire,RevueEnclenchementRepository $revueEnclenchementRepository,ParametreRepository $parametreRepository,EtudesAchatsRepository $etudesAchatsRepository, AtelierRepository $atelierRepository): Response
    {
        
        $revueEnclenchement = new RevueEnclenchement();
        //dd($affaire);
        if(count($affaire->getRevueEnclenchements()) != 0)
        {
            $revueEn = $revueEnclenchementRepository->findByAffaire($affaire);
            //dd($revueEn[0]);
            $revueEnclenchement = $revueEn[0];
        }
        
        $form = $this->createForm(RevueEnclenchementType::class, $revueEnclenchement);
        $form->handleRequest($request);

        $user = $this->getUser()->getNom().' '.$this->getUser()->getPrenom();


        $etudesAchats = new EtudesAchats();
        $formEtudesAchats = $this->createForm(EtudesAchatsType::class, $etudesAchats);
        $formEtudesAchats->handleRequest($request);

        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $affaire->getId())
            {
                array_push($parametre,$item);
            }
        }
      //  dd($parametre);
        $atelier = new Atelier();
        $formAtelier = $this->createForm(AtelierType::class, $atelier);
        $formAtelier->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $revueEnclenchement->setUtilisateur($user);
            $revueEnclenchement->setAffaire($affaire);
            $revueEnclenchement->setIndice('Indice A');
            //$affaire->setRevueEnclenchement($revueEnclenchement);
            foreach($affaire->getParametres() as $item)
            {
                $item->setEtat(1);
            }
            
            $revueEnclenchementRepository->save($revueEnclenchement, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        if ($formEtudesAchats->isSubmitted() && $formEtudesAchats->isValid()) 
        {
            $etudesAchats->setRevueEnclenchement($revueEnclenchement);
            $etudesAchatsRepository->save($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) 
        {
            $atelier->setRevueEnclenchement($revueEnclenchement);
            $atelierRepository->save($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('revue_enclenchement/new.html.twig', [
            'affaire' => $affaire,
            'parametre' => $parametre,
            'revue_enclenchement' => $revueEnclenchement,
            'etudes_achats' => $etudesAchats,
            'atelier' => $atelier,
            'form' => $form->createView(),
            'formAtelier' => $formAtelier->createView(),
            'formEtudesAchats' => $formEtudesAchats->createView(),
            
        ]);
    }

    #[Route('/indice-revue/{id}', name: 'app_revue_enclenchement_indice', methods: ['GET', 'POST'])]
    public function newIndiceB(Request $request,Affaire $affaire,RevueEnclenchementRepository $revueEnclenchementRepository,ParametreRepository $parametreRepository,EtudesAchatsRepository $etudesAchatsRepository, AtelierRepository $atelierRepository): Response
    {
        
        $revueEnclenchement = new RevueEnclenchement();
        $revueEn = $revueEnclenchementRepository->findByAffaire($affaire);
        $indice = $revueEn[0];
        $indiceDate = $revueEn[0];
        //dd($affaire);
        if(count($affaire->getRevueEnclenchements()) > 1)
        {
            $revueEn = $revueEnclenchementRepository->findByAffaire($affaire);
            $revueEnclenchement = $revueEn[1];
            $indice = $revueEn[1];
        }
        
        $form = $this->createForm(RevueEnclenchement2Type::class, $revueEnclenchement);
        $form->handleRequest($request);

        $user = $this->getUser()->getNom().' '.$this->getUser()->getPrenom();


        $etudesAchats = new EtudesAchats();
        $formEtudesAchats = $this->createForm(EtudesAchatsType::class, $etudesAchats);
        $formEtudesAchats->handleRequest($request);

        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $affaire->getId())
            {
                array_push($parametre,$item);
            }
        }
      //  dd($parametre);
        $atelier = new Atelier();
        $formAtelier = $this->createForm(AtelierIndiceType::class, $atelier);
        $formAtelier->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $revueEnclenchement->setUtilisateur($user);
            $revueEnclenchement->setAffaire($affaire);
            $revueEnclenchement->setIndice('Indice B');
            //dd($indiceDate);
            $revueEnclenchement->setDelaiDemandeClient($indiceDate->getDelaiDemandeClient());
            $revueEnclenchement->setRe7Client($indiceDate->getRe7Client());
            $revueEnclenchement->setArriveCommande($indiceDate->getArriveCommande());
            $revueEnclenchement->setRevueEnclenchement($indiceDate->getRevueEnclenchement());
            $revueEnclenchement->setArc($indiceDate->getArc());
            $revueEnclenchement->setArriveeMachine($indiceDate->getArriveeMachine());
            $revueEnclenchement->setDateRapportExpertiseFinalise($indiceDate->getDateRapportExpertiseFinalise());
            //$affaire->setRevueEnclenchement($revueEnclenchement);
            foreach($affaire->getParametres() as $item)
            {
                $item->setEtat(1);
            }
            
            $revueEnclenchementRepository->save($revueEnclenchement, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        if ($formEtudesAchats->isSubmitted() && $formEtudesAchats->isValid()) 
        {
            $etudesAchats->setRevueEnclenchement($revueEnclenchement);
            $etudesAchatsRepository->save($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) 
        {
            $atelier->setRevueEnclenchement($revueEnclenchement);
            $atelierRepository->save($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('revue_enclenchement/new_indice.html.twig', [
            'affaire' => $affaire,
            'parametre' => $parametre,
            'revue_enclenchement' => $revueEnclenchement,
            'indice' => $indice,
            'etudes_achats' => $etudesAchats,
            'atelier' => $atelier,
            'form' => $form->createView(),
            'formAtelier' => $formAtelier->createView(),
            'formEtudesAchats' => $formEtudesAchats->createView(),
            
        ]);
    }

    #[Route('/show-revue/{id}', name: 'app_revue_enclenchement_show', methods: ['GET'])]
    public function show(RevueEnclenchement $revueEnclenchement, ParametreRepository $parametreRepository): Response
    {   
        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $revueEnclenchement->getAffaire()->getId())
            {
                array_push($parametre,$item);
            }
        }
        return $this->render('revue_enclenchement/show.html.twig', [
            'revue_enclenchement' => $revueEnclenchement,
            'parametre' => $parametre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_revue_enclenchement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RevueEnclenchement $revueEnclenchement, RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        $form = $this->createForm(RevueEnclenchementType::class, $revueEnclenchement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $revueEnclenchementRepository->save($revueEnclenchement, true);

            return $this->redirectToRoute('app_revue_enclenchement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('revue_enclenchement/edit.html.twig', [
            'revue_enclenchement' => $revueEnclenchement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_revue_enclenchement_delete', methods: ['POST'])]
    public function delete(Request $request, RevueEnclenchement $revueEnclenchement, RevueEnclenchementRepository $revueEnclenchementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$revueEnclenchement->getId(), $request->request->get('_token'))) {
            $revueEnclenchementRepository->remove($revueEnclenchement, true);
        }

        return $this->redirectToRoute('app_revue_enclenchement_index', [], Response::HTTP_SEE_OTHER);
    }

    //supprimer un élément d'étude et achats
    #[Route('/etudes-achats/{id}', name: 'delete_etudes_achats', methods: ['POST','GET'])]
    public function deleteEtudes(Request $request,EtudesAchats $etudesAchats,EtudesAchatsRepository $etudesAchatsRepository): Response
    {
        $id = $etudesAchats->getRevueEnclenchement()->getAffaire()->getId();    
        if ($etudesAchats)
        {
            $etudesAchatsRepository->remove($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);

    }    
    //supprimer un élément d'étude et achats
    #[Route('/etudes-achats-indice/{id}', name: 'delete_etudes_achat_indice', methods: ['POST','GET'])]
    public function deleteEtudesIndice(Request $request,EtudesAchats $etudesAchats,EtudesAchatsRepository $etudesAchatsRepository): Response
    {
        $id = $etudesAchats->getRevueEnclenchement()->getAffaire()->getId();    
        if ($etudesAchats)
        {
            $etudesAchatsRepository->remove($etudesAchats, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);

    }

    //supprimer un élément d'étude et achats
    #[Route('/atelier/{id}', name: 'delete_atelier', methods: ['POST','GET'])]
    public function atelier(Request $request,Atelier $atelier,AtelierRepository $atelierRepository): Response
    {
        $id = $atelier->getRevueEnclenchement()->getAffaire()->getId();    
        if ($atelier)
        {
            $atelierRepository->remove($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_new', ['id' => $id], Response::HTTP_SEE_OTHER);

    }  
    
    //supprimer un élément d'étude et achats
    #[Route('/atelier-indice/{id}', name: 'delete_atelier_indicie', methods: ['POST','GET'])]
    public function atelierIndice(Request $request,Atelier $atelier,AtelierRepository $atelierRepository): Response
    {
        $id = $atelier->getRevueEnclenchement()->getAffaire()->getId();    
        if ($atelier)
        {
            $atelierRepository->remove($atelier, true);
            return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_revue_enclenchement_indice', ['id' => $id], Response::HTTP_SEE_OTHER);

    }

    //voir pdf de la revue
    #[Route('/print-revue-enclenchement/{id}', name: 'app_revue_enclenchement_print', methods: ['POST','GET'])]
    public function print(RevueEnclenchement $revueEnclenchement, ParametreRepository $parametreRepository): Response
    {  
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times New Roman');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);        
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);
        $dompdf->setCallbacks([
            'event' => function ($event) use ($dompdf) {
                if ($event['event'] === 'dompdf.page_number') {
                    $dompdf->getCanvas()->page_text(500, 18, 'Page {PAGE_NUM} sur {PAGE_COUNT}', null, 10, [0, 0, 0]);
                }
            }
        ]);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $listes = $parametreRepository->findAll();
        $parametre = [];
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $revueEnclenchement->getAffaire()->getId())
            {
                array_push($parametre,$item);
            }
        }

        $dompdf->setHttpContext($context);
        if($revueEnclenchement->getIndice()== 'Indice A')
        {
            $html = $this->renderView('revue_enclenchement/print.html.twig', [
                'parametre' => $parametre,
                'revue_enclenchement' => $revueEnclenchement,
            ]);

        }else{
            $html = $this->renderView('revue_enclenchement/printb.html.twig', [
                'parametre' => $parametre,
                'revue_enclenchement' => $revueEnclenchement,
            ]);

        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = "Revue d'enclenchement du projet : ".$revueEnclenchement->getAffaire()->getNumAffaire();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();    
    }
}
