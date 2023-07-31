<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Affaire;
use App\Entity\Parametre;
use App\Form\ParametreType;
use App\Repository\AppareilMesureRepository;
use App\Repository\CorrectionRepository;
use App\Repository\CritereRepository;
use App\Repository\ParametreRepository;
use App\Repository\PhotoRepository;
use App\Repository\ReleveDimmensionnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Snappy\Pdf;


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
    public function new(Request $request,Affaire $affaire, ParametreRepository $parametreRepository, CritereRepository $critereRepository,CorrectionRepository $correctionRepository): Response
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
 
        $corrections = $correctionRepository->findAll();
        $correction = 0;
        foreach ($corrections as $item2)
        {
            if ($item2->isEtat() == 1)
            {
                $correction = $item2->getTemperature();
            }
        }
        
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($parametre->getStatorTension2() == null)
            {
                $parametre->setStatorTension2(0);
            }

            if ($parametre->getRotorTension2() == null)
            {
                $parametre->setRotorTension2(0);
            }

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
            'correction' => $correction,
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
        ReleveDimmensionnelRepository $releveDimmensionnelRepository,
        PhotoRepository $photoRepository,
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
        $pdfOptions->set('defaultFont', 'sans-serif');
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
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }

    #[Route('/print/rapport-final/{id}', name: 'app_parametre_final', methods: ['POST', 'GET'])]
    public function rapporFinal(Parametre $parametre): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);

        $html = $this->renderView('parametre/rapport_final.html.twig', [
            'parametre' => $parametre
        ]);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions); 
        $dompdf->getOptions()->set('defaultMediaType', 'print');
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);
        $dompdf->getOptions()->set('defaultFont', 'Arial');
        $dompdf->getOptions()->set('default_charset', 'UTF-8');
        $dompdf->getOptions()->set('fontHeightRatio', 1.1);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        
        $dompdf->setHttpContext($context);
        $dompdf->loadHtml($html,'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
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
