<?php

namespace App\Controller;

use App\Entity\AccessoireSupplementaire;
use TCPDF;
use Dompdf\Dompdf;
use Dompdf\Adapter\CPDF;
use Dompdf\Options;
use App\Entity\Affaire;
use App\Entity\Parametre;
use App\Form\ParametreType;
use App\Repository\AccessoireSupplementaireRepository;
use App\Repository\AppareilMesureElectriqueRepository;
use App\Repository\AppareilMesureMecaniqueRepository;
use App\Repository\AppareilMesureRepository;
use App\Repository\CaracteristiqueRepository;
use App\Repository\ConstatElectriqueApresLavageRepository;
use App\Repository\ConstatElectriqueRepository;
use App\Repository\ConstatMecaniqueRepository;
use App\Repository\ControleVisuelMecaniqueRepository;
use App\Repository\CritereRepository;
use App\Repository\ImagesRepository;
use App\Repository\LMesureIsolementRepository;
use App\Repository\LMesureResistanceRepository;
use App\Repository\LSondeBobinageRepository;
use App\Repository\LStatorApresLavageRepository;
use App\Repository\MesureIsolementRepository;
use App\Repository\MesureResistanceRepository;
use App\Repository\ParametreRepository;
use App\Repository\PhotoExpertiseMecaniqueRepository;
use App\Repository\PhotoRepository;
use App\Repository\PointFonctionnementRepository;
use App\Repository\PointFonctionnementRotorRepository;
use App\Repository\ReleveDimmensionnelRepository;
use App\Repository\RemontagePhotoRepository;
use App\Repository\SondeBobinageRepository;
use App\Repository\StatorApresLavageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/parametre')]
class ParametreController extends AbstractController
{
    #[Route('/', name: 'app_parametre_index', methods: ['GET'])]
    public function index(ParametreRepository $parametreRepository): Response
    {
        return $this->render('parametre/index.html.twig', [
            'parametres' => $parametreRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_parametre_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Affaire $affaire, ParametreRepository $parametreRepository, CritereRepository $critereRepository): Response
    {
        $parametre = new Parametre();
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        $criteres = $critereRepository->findAll();
        $critere = 0;
        foreach ($criteres as $item)
        {
            if ($item->isEtat() == 1)
            {
                $critere = $item->getMontant();
            }
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $parametre->setAffaire($affaire);
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/new.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
            'affaire' => $affaire,
            'critere' => $critere,
        ]);
    }

    #[Route('/{id}', name: 'app_parametre_show', methods: ['GET'])]
    public function show(Parametre $parametre): Response
    {
        return $this->render('parametre/show.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $parametre->getAffaire()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    #[Route('delete-parametre/{id}', name: 'app_parametre_delete', methods: ['GET'])]
    public function delete(Request $request, 
        Parametre $parametre,
        EntityManagerInterface $em,
        ParametreRepository $parametreRepository,
        AppareilMesureRepository $appareilMesureRepository,
        AppareilMesureElectriqueRepository $appareilMesureElectriqueRepository,
        AppareilMesureMecaniqueRepository $appareilMesureMecaniqueRepository,
        ReleveDimmensionnelRepository $releveDimmensionnelRepository,
        PhotoExpertiseMecaniqueRepository $photoExpertiseMecaniqueRepository,
        ConstatElectriqueApresLavageRepository $constatElectriqueApresLavageRepository,
        ConstatMecaniqueRepository $constatMecaniqueRepository,
        ConstatElectriqueRepository $constatElectriqueRepository,
        CaracteristiqueRepository $caracteristiqueRepository,
        PointFonctionnementRepository $pointFonctionnementRepository,
        PointFonctionnementRotorRepository $pointFonctionnementRotorRepository,
        ImagesRepository $imagesRepository,
        RemontagePhotoRepository $remontagePhotoRepository,
        PhotoRepository $photoRepository,
        AccessoireSupplementaireRepository $accessoireSupplementaireRepository,
        ControleVisuelMecaniqueRepository $controleVisuelMecaniqueRepository,
        MesureIsolementRepository $mesureIsolementRepository,
        MesureResistanceRepository $mesureResistanceRepository,
        LMesureIsolementRepository $lmesureIsolementRepository,
        LMesureResistanceRepository $lmesureResistanceRepository,
        SondeBobinageRepository $sondeBobinageRepository,
        LSondeBobinageRepository $lSondeBobinageRepository,
        StatorApresLavageRepository $statorApresLavageRepository,
        LStatorApresLavageRepository $lStatorApresLavageRepository
         ): Response
    {
        if ($parametre)
        {   
            $id = $parametre->getAffaire()->getId();
            //appareil de mesure mecanique
            foreach($parametre->getAppareilMesureMecaniques() as $item){
                $em->remove($item, true);
            }

            //photos expertiss mécanique
            foreach($parametre->getPhotoExpertiseMecaniques() as $item){
                $em->remove($item, true);
            }

            //constat électrique après lavage
            foreach($parametre->getConstatElectriqueApresLavages() as $item){
                $em->remove($item, true);
            }
            //constat mécanique
            foreach($parametre->getConstatMecaniques() as $item){
                $em->remove($item, true);
            }

            //constat électrique avant lavage
            foreach($parametre->getConstatElectriques() as $item){
                $em->remove($item, true);
            }
            //caractéristique
            foreach($parametre->getCaracteristiques() as $item){
                $em->remove($item, true);
            }

            //point de fonctionnement
            foreach($parametre->getPointFonctionnements() as $item){
                $em->remove($item);
            }

            ///point de fonctionnement rotor
            foreach($parametre->getPointFonctionnementRotors() as $item){
                $em->remove($item);
            }

            ///remontage photo
            foreach($parametre->getRemontagePhotos() as $item){
                $em->remove($item);
            }

            ///photo
            if($parametre->getPhoto())
            {
                if($parametre->getPhoto()->getImages())
                {
                    foreach($parametre->getPhoto()->getImages() as $item)
                    {
                        $em->remove($item);
                    }
                }

                foreach($photoRepository->findAll() as $ph)
                {
                    if($ph->getParametre()->getId() == $parametre->getId()){
                        $em->remove($ph);
                    }
                }
            }

            ///mesure isolement
            if($parametre->getMesureIsolement())
            {
                if($parametre->getMesureIsolement()->getLMesureIsolements()){
                    foreach($parametre->getMesureIsolement()->getLMesureIsolements() as $item){
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureIsolement());
            }

            ///mesure resistance
            if($parametre->getMesureResistance())
            {
                if($parametre->getMesureResistance()->getLMesureResistances()){
                    foreach($parametre->getMesureResistance()->getLMesureResistances() as $item){
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureResistance());
            }

            ///sonde et bobinage
            if($parametre->getSondeBobinage())
            {
                if($parametre->getSondeBobinage()->getLSondeBobinages()){
                    foreach($parametre->getSondeBobinage()->getLSondeBobinages() as $item){
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getSondeBobinage());
            }

            //stator après lavage
            if($parametre->getStatorApresLavage())
            {
                if($parametre->getStatorApresLavage()->getLStatorApresLavages()){
                    foreach($parametre->getStatorApresLavage()->getLStatorApresLavages() as $item){
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getStatorApresLavage());
            }
            
            ///controle visuel
            if($parametre->getControleVisuelMecanique())
            {
                if($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires())
                {
                    foreach($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires() as $item)
                    {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getControleVisuelMecanique());
            }

            foreach($releveDimmensionnelRepository->findAll() as $item)
            {
                if($item->getParametre()->getId() == $parametre->getId())
                {
                    $em->remove($item);
                }
               $em->remove($item);
            }

            foreach($parametre->getAppareilMesureElectriques() as $item){
                $em->remove($item);
            }
            
            if($parametre->getAppareilMesures())
            {
                foreach($appareilMesureRepository->findAll() as $item)
                {
                    if($item->getParametre()->getId() ==  $parametre->getId())
                    {
                        $em->remove($item);
                    }
                }
            }
            
            $parametreRepository->remove($parametre, true);
            $em->flush();
        }

        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/print/rapport-expertise/{id}', name: 'app_parametre_expertise', methods: ['POST', 'GET'])]
    public function rapportExpertise(Parametre $parametre): Response
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

        $dompdf->setHttpContext($context);
        $html = $this->renderView('parametre/rapport_expertise.html.twig', [
            'parametre' => $parametre
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Génération du numéro de page
      /*  $dompdf->getCanvas()->getDom()->addEventListener('load', function($event) use ($dompdf) {
                $pageNumber = $dompdf->getCanvas()->get_page_number();
                $totalPages = $dompdf->getCanvas()->get_page_count();
                $font = $dompdf->getFontMetrics()->get_font('helvetica', 'regular');
                $size = 10;
                $color = array(0, 0, 0); // Couleur du numéro de page (noir)

                $canvas = $dompdf->getCanvas();
                $canvas->page_text(550, 20, "Page $pageNumber / $totalPages", $font, $size, $color);
            });
            */
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
      /*
        $pdf = new TCPDF();
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();
        $pdf->SetTitle($parametre->getAffaire()->getNomRapport());
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Récupérez le contenu de la page Twig
        $content = $this->renderView('parametre/rapport_pdf.html.twig', [
            'parametre' => $parametre,
            'hello' => 'bonjour'
        ]);

        // Ajoutez le contenu à votre PDF
        $pdf->writeHTML($content);

        // Définissez le nom du fichier PDF généré
        $filename = $parametre->getAffaire()->getNomRapport();

        // Renvoyez le PDF en tant que réponse
        return new Response($pdf->Output($filename, 'I'), 200, array(
            'Content-Type' => 'application/pdf',
        ));
        */
    

    }

    #[Route('/print/rapport-final/{id}', name: 'app_parametre_final', methods: ['POST', 'GET'])]
    public function rapporFinal(Parametre $parametre): Response
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

        $dompdf->setHttpContext($context);
        $html = $this->renderView('parametre/rapport_final.html.twig', [
            'parametre' => $parametre
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Génération du numéro de page
      /*  $dompdf->getCanvas()->getDom()->addEventListener('load', function($event) use ($dompdf) {
                $pageNumber = $dompdf->getCanvas()->get_page_number();
                $totalPages = $dompdf->getCanvas()->get_page_count();
                $font = $dompdf->getFontMetrics()->get_font('helvetica', 'regular');
                $size = 10;
                $color = array(0, 0, 0); // Couleur du numéro de page (noir)

                $canvas = $dompdf->getCanvas();
                $canvas->page_text(550, 20, "Page $pageNumber / $totalPages", $font, $size, $color);
            });
            */
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
      /*
        $pdf = new TCPDF();
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();
        $pdf->SetTitle($parametre->getAffaire()->getNomRapport());
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Récupérez le contenu de la page Twig
        $content = $this->renderView('parametre/rapport_pdf.html.twig', [
            'parametre' => $parametre,
            'hello' => 'bonjour'
        ]);

        // Ajoutez le contenu à votre PDF
        $pdf->writeHTML($content);

        // Définissez le nom du fichier PDF généré
        $filename = $parametre->getAffaire()->getNomRapport();

        // Renvoyez le PDF en tant que réponse
        return new Response($pdf->Output($filename, 'I'), 200, array(
            'Content-Type' => 'application/pdf',
        ));
        */
    

    }

    #[Route('/reunion-validation/{id}', name: 'app_parametre_valided', methods: ['GET'])]
    public function reunion(Request $request, Parametre $parametre, ParametreRepository $parametreRepository, EntityManagerInterface $em): Response
    {
        $id = $parametre->getAffaire()->getId();
        if ($parametre) {
            $parametre->setEtat(1);
            $em->persist($parametre);
            $em->flush();
        }
        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);
    }
}
