<?php

namespace App\Controller;

use App\Entity\Appareil;
use App\Entity\Certificat;
use App\Form\AppareilType;
use App\Form\CertificatType;
use App\Service\PdfServiceP;
use App\Entity\AppareilMesure;
use App\Entity\AppareilMesureEssais;
use App\Repository\AppareilRepository;
use App\Entity\AppareilMesureMecanique;
use App\Entity\AppareilMesureElectrique;
use App\Repository\AppareilMesureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AppareilMesureEssaisRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\AppareilMesureElectriqueRepository;
use App\Repository\CertificatRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/appareil')]
class AppareilController extends AbstractController
{
    #[Route('/index', name: 'app_appareil_index', methods: ['GET'])]
    public function index(AppareilRepository $appareilRepository): Response
    {
        $items = $appareilRepository->findBy([],['id' => 'desc']);
        $appareils = [];
        foreach($items as $item)
        {
            if ($item->getEtat() == 'Fonctionnel' && $item->getStatut() ==  'Conforme')
            {
                array_push($appareils, $item);
            }
        }
        return $this->render('appareil/index.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    #[Route('/hors-validite/index', name: 'app_appareil_hv_index', methods: ['GET'])]
    public function horsValidite(AppareilRepository $appareilRepository): Response
    {
        $items = $appareilRepository->findBy([],['id' => 'desc']);
        $appareils = [];
        foreach($items as $item)
        {
            if ($item->getEtat() == 'Hors Validite')
            {
                array_push($appareils, $item);
            }
        }
        return $this->render('appareil/hv.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    #[Route('/perdu/index', name: 'app_appareil_perdu_index', methods: ['GET'])]
    public function perdu(AppareilRepository $appareilRepository): Response
    {
        $items = $appareilRepository->findBy([],['id' => 'desc']);
        $appareils = [];
        foreach($items as $item)
        {
            if ($item->getEtat() == 'Perdu')
            {
                array_push($appareils, $item);
            }
        }
        return $this->render('appareil/perdu.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    #[Route('/hs/index', name: 'app_appareil_hs_index', methods: ['GET'])]
    public function hs(AppareilRepository $appareilRepository): Response
    {
        $items = $appareilRepository->findBy([],['id' => 'desc']);
        $appareils = [];
        foreach($items as $item)
        {
            if ($item->getEtat() == 'HS')
            {
                array_push($appareils, $item);
            }
        }
        return $this->render('appareil/hs.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    #[Route('/reserve/index', name: 'app_appareil_reserve_index', methods: ['GET'])]
    public function reserve(AppareilRepository $appareilRepository): Response
    {
        $items = $appareilRepository->findBy([],['id' => 'desc']);
        $appareils = [];
        foreach($items as $item)
        {
            if ($item->getAffectation() == 'Réserve')
            {
                array_push($appareils, $item);
            }
        }
        return $this->render('appareil/reserve.html.twig', [
            'appareils' => $appareils,
        ]);
    }

    #[Route('/new', name: 'app_appareil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppareilRepository $appareilRepository): Response
    {
        $appareil = new Appareil();
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appareil->setStatus(0);
            $appareilRepository->save($appareil, true);

            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appareil/new.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    #[Route('/show-app/{id}', name: 'app_appareil_show', methods: ['GET','POST'])]
    public function show(Appareil $appareil, Request $request, SluggerInterface $slugger, CertificatRepository $certificatRepository): Response
    {
        $certificat = new Certificat();
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid())
         {
            $document = $form->get('document')->getData();
            if ($document) {
                $originalePhoto = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $document->guessExtension();
                try {
                    $document->move(
                        $this->getParameter('certificats'),
                        $newPhotoname
                    );
                } catch (FileException $e){}

                $certificat->setDocument($newPhotoname);
            }
            $certificat->setAppareil($appareil);
            $certificatRepository->save($certificat, true);
            return $this->redirectToRoute('app_appareil_show', ['id' => $appareil->getId()]);
         }
        return $this->render('appareil/show.html.twig', [
            'appareil' => $appareil,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appareil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appareil $appareil, AppareilRepository $appareilRepository): Response
    {
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appareilRepository->save($appareil, true);
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appareil/edit.html.twig', [
            'appareil' => $appareil,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_appareil_delete', methods: ['GET'])]
    public function delete(Request $request, Appareil $appareil, AppareilRepository $appareilRepository,
                        AppareilMesureRepository $appareilMesureRepository,
                        AppareilMesureEssaisRepository $appareilMesureEssaisRepository,
                        AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository,
                        AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository,
                

                        ): Response
    {
        $appareilMesure1 = $appareilMesureRepository->findByAppareil($appareil);
        $appareilMesure2 = $appareilMesureEssaisRepository->findByAppareil($appareil);
        $appareilMesure3 = $appareilMesureMecaniqueRepository->findByAppareil($appareil);
        $appareilMesure4 = $appareilMesureElectriqueRepository->findByAppareil($appareil);
        
       if($appareil)
       {
            if(!$appareilMesure1 and !$appareilMesure2 and !$appareilMesure3 and !$appareilMesure4)
            {
                $appareilRepository->remove($appareil, true);
                return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
            }
            else
            {
                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cet Appareil, car y a des expertise sur l'appareil ! ");
                return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);
            }
       }else{
            return $this->redirectToRoute('app_appareil_index', [], Response::HTTP_SEE_OTHER);

       } 
    }

    #[Route('mesure/{id}', name: 'delete_appareil', methods: ['GET'])]
    public function deleteAppareilMesure(Request $request,AppareilMesure $appareilMesure, AppareilMesureRepository $appareilMesureRepository): Response
    {
        $idApp = $appareilMesure;
        $id = $idApp->getParametre()->getId();
       if($appareilMesure){
        $appareilMesureRepository->remove($appareilMesure, true);
        return $this->redirectToRoute('app_appareil_mesure', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

       }else{
            return $this->redirectToRoute('app_appareil_mesure', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
       } 
    }

    #[Route('mesureMecanique/{id}', name: 'delete_appareil_mecanique', methods: ['GET'])]
    public function deleteAppareilMesureMecanique(AppareilMesureMecanique $appareilMesureMecanique, AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository): Response
    {
        $idApp = $appareilMesureMecanique;
        $id = $idApp->getParametre()->getId();
       if($appareilMesureMecanique){
        $appareilMesureMecaniqueRepository->remove($appareilMesureMecanique, true);
        return $this->redirectToRoute('app_expertise_mecanique', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);

       }else{
            return $this->redirectToRoute('app_expertise_mecanique', [
                'id' => $id
            ], Response::HTTP_SEE_OTHER);
       } 
    }

    #[Route('mesureElectrique/{id}', name: 'delete_appareil_electrique', methods: ['GET'])]
    public function deleteAppareilMesureElectrique(AppareilMesureElectrique $appareilMesureElectrique, AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository): Response
    {
        $idApp = $appareilMesureElectrique;
        $id = $idApp->getParametre()->getId();
       if($appareilMesureElectrique){
        $appareilMesureElectriqueRepository->remove($appareilMesureElectrique, true);
        return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
       }else{
            return $this->redirectToRoute('app_expertise_electrique_apres_lavage', ['id' => $id], Response::HTTP_SEE_OTHER);
       } 
    }


    #[Route('delete-essais/{id}', name: 'delete_appareil_essais', methods: ['GET'])]
    public function deleteAppareilMesureEssais(AppareilMesureEssais $appareilMesureEssais, AppareilMesureEssaisRepository $appareilMesureEssaisRepository): Response
    {
        $idApp = $appareilMesureEssais;
        $id = $idApp->getParametre()->getId();
       if($appareilMesureEssais)
       {
            $appareilMesureEssaisRepository->remove($appareilMesureEssais, true);
            return $this->redirectToRoute('app_appareil_essais', ['id' => $id], Response::HTTP_SEE_OTHER);
       }else{
            return $this->redirectToRoute('app_appareil_essais', ['id' => $id], Response::HTTP_SEE_OTHER);
       } 
    }

    //imprimer le bon de sortie
    #[Route('/print-fiche-de-vie/{id}', name: 'app_print_fiche_de_vie', methods: ['POST','GET'])]
    public function print(Appareil $appareil, PdfServiceP $pdfServiceP): Response
    {  
        $html = $this->renderView('appareil/print.html.twig', ['appareil' => $appareil]);
        $fichier = "Fiche de vie de l'appareil n° : ".$appareil->getNumAppareil();
        return $pdfServiceP->showPdfFile($html, $fichier);
    }
}
