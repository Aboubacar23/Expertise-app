<?php
/**
 * ----------------------------------------------------------------
 * Projet : Base Métrologie
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 02-10-2023
 * Dérniere date de modification : 01-02-2024
 * ----------------------------------------------------------------
 * ********************** Déscription *****************************
 * ## À savoir que l'accès à la page affectation est obligatoire
 * Base de données : 
 *      + nom table : affectation
 * 
 * template :
 *      c'est le dossier "metrologie/affectation" qui contient toutes les  pages vues des fonctions de controleurs
 * 
 * Dans ce controleur vous avez 12 fonctions qui assure le bon fonctionnement du module affectation.
 *      2- la fonction "index",qui affiche la liste des affectations
 *      3- la fonction "new", pour ajouter une nouvelle affectation dans la base de données
 *      4- la fonction "show", affiche les informations d'une seule affectation en fonction de son ID
 *      5- la fonction "edit", permet de modifier une affectation
 *      6- la fonction "delete", permet de supprimer une affectation
 *      7- la fonction "new2", pour ajouter une affecatation par une affaire métrologie
 *      8- la fonction "suppressionSession", supprimer un élément, ajouter comme une session lors de l'ajout d'une affectation
 *      9- la fonction "print", permet d'imprimer une affectation
 *      10- la fonction "supprimeSessionData", permet de supprimer un élément lord de modification d'une affectation
 *      11- la fonction "supprimeSessionEdit", supprimer un élément, ajouter comme une session lors de modification d'une affectation
 */
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Affectation;
use App\Entity\Laffectation;
use App\Service\PdfServiceP;
use App\Form\AffectationType;
use App\Form\Affectation2Type;
use App\Form\LaffectationType;
use App\Entity\AffaireMetrologie;
use App\Form\AffectationEditType;
use App\Repository\AppareilRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/affectation')]
class AffectationController extends AbstractController
{
    #[Route('/index', name: 'app_affectation_index', methods: ['GET'])]
    public function index(AffectationRepository $affectationRepository): Response
    {
        return $this->render('metrologies/affectation/index.html.twig', [
            'affectations' => $affectationRepository->findBy([], ['id' => 'desc']),
        ]);
    }

    #[Route('/new', name: 'app_affectation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffectationRepository $affectationRepository,EntityManagerInterface $em,AppareilRepository $appareilRepository): Response
    {
        $affectation = new Affectation();
        $laffectation = new Laffectation();
        $form = $this->createForm(AffectationType::class, $affectation);
        $f = $this->createForm(LaffectationType::class, $laffectation);
        $form->handleRequest($request);
        $f->handleRequest($request);

        $session = $request->getSession();
        $items = $session->get('affects', []);

        if ($form->isSubmitted() && $f->isSubmitted()) {
            
            $choix = $request->get('bouton3');
            if ($choix == 'ajouter')
            {
                $i = 0;
                foreach($items as $item)
                {
                    $i = $i + 1;
                    $laffectation = new Laffectation(); 
                    $laffectation->setLig($i);
                    $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                    $laffectation->setAppareil($appareil);
                    if ($laffectation->getTypeService() != 'autres') {
                        $appareil->setStatus(1);
                    }
                    $appareil->setStatus(1);
                    $laffectation->setDesignation($item->getDesignation());
                    $laffectation->setType($item->getType());
                    $laffectation->setNumeroSerie($item->getNumeroSerie());
                    $laffectation->setDateRetour($item->getDateRetour());
                    $laffectation->setObservation($item->getObservation());
                    $laffectation->setTypeService($item->getTypeService());
                    $laffectation->setAffectation($affectation);
                    $em->persist($laffectation);
 
                }
                $affectation->setRetour(1);
                $affectation->getAffaire()->setStatut(1);
                $affectationRepository->save($affectation, true);
                $session->clear();
                return $this->redirectToRoute('app_affectation_index', [], Response::HTTP_SEE_OTHER);

            } 
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $laffectation->setLig($lig);
                $items[$lig] = $laffectation;
                $session->set('affects', $items);
            }
        }

        return $this->renderForm('metrologies/affectation/new.html.twig', [
            'affectation' => $affectation,
            'laffectation' => $laffectation,
            'form' => $form,
            'f' => $f,
            'items' => $items,
        ]);
    }

    #[Route('/new-affectation/{id}', name: 'app_affect_aff_new', methods: ['GET', 'POST'])]
    public function new2(Request $request,AffaireMetrologie $affaireMetrologie, AffectationRepository $affectationRepository,EntityManagerInterface $em,AppareilRepository $appareilRepository): Response
    {
        $affectation = new Affectation();
        $affectation->setAffaire($affaireMetrologie);
        $laffectation = new Laffectation();
        $form = $this->createForm(Affectation2Type::class, $affectation);
        $f = $this->createForm(LaffectationType::class, $laffectation);
        $form->handleRequest($request);
        $f->handleRequest($request);

        $session = $request->getSession();
        $items = $session->get('affects', []);
 
        if ($form->isSubmitted() && $f->isSubmitted()) {
            
            $choix = $request->get('bouton3');
            if ($choix == 'ajouter')
            {
                $i = 0;
                foreach($items as $item)
                {
                    $i = $i + 1;
                    $laffectation = new Laffectation(); 
                    $laffectation->setLig($i);
                    $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                    $laffectation->setAppareil($appareil);
                    if ($laffectation->getTypeService() != 'autres') {
                        $appareil->setStatus(1);
                    }
                    $appareil->setStatus(1);
                    $laffectation->setDesignation($item->getDesignation());
                    $laffectation->setType($item->getType());
                    $laffectation->setNumeroSerie($item->getNumeroSerie());
                    $laffectation->setDateRetour($item->getDateRetour());
                    $laffectation->setObservation($item->getObservation());
                    $laffectation->setTypeService($item->getTypeService());
                    $laffectation->setAffectation($affectation);
                    $em->persist($laffectation);
 
                }
                $affectation->setRetour(1);
                $affectation->setAffaire($affaireMetrologie);
                $affectation->getAffaire()->setStatut(1);
                $affectationRepository->save($affectation, true);
                $session->clear();
                return $this->redirectToRoute('app_affectation_index', [], Response::HTTP_SEE_OTHER);

            } 
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $laffectation->setLig($lig);
                $items[$lig] = $laffectation;
                $session->set('affects', $items);
            }
        }

        return $this->renderForm('metrologies/affectation/new_affectation.html.twig', [
            'affectation' => $affectation,
            'laffectation' => $laffectation,
            'form' => $form,
            'f' => $f,
            'items' => $items,
            'affaire' => $affaireMetrologie
        ]);
    }

    #[Route('/{id}', name: 'app_affectation_show', methods: ['GET'])]
    public function show(Affectation $affectation): Response
    {
        return $this->render('metrologies/affectation/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affectation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affectation $affectation,EntityManagerInterface $em, AffectationRepository $affectationRepository, AppareilRepository $appareilRepository): Response
    {
        $form = $this->createForm(AffectationEditType::class, $affectation);
        $form->handleRequest($request);

        $laffectation = new Laffectation();
        $f = $this->createForm(LaffectationType::class, $laffectation);
        $f->handleRequest($request);

        $session = $request->getSession();
        $items = $session->get('affects', []);

        if ($form->isSubmitted() && $f->isSubmitted()) {            
            $choix = $request->get('bouton3');
            if ($choix == 'ajouter')
            {
                $i = 0;
                foreach($items as $item)
                {
                    $i = $i + 1;
                    $laffectation = new Laffectation(); 
                    $laffectation->setLig($i);
                    $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                    $laffectation->setAppareil($appareil);
                    if ($laffectation->getTypeService() != 'autres') {
                        $appareil->setStatus(1);
                    }
                    $appareil->setStatus(1);
                    $laffectation->setDesignation($item->getDesignation());
                    $laffectation->setType($item->getType());
                    $laffectation->setNumeroSerie($item->getNumeroSerie());
                    $laffectation->setDateSortie($item->getDateSortie());
                    $laffectation->setObservation($item->getObservation());
                    $laffectation->setTypeService($item->getTypeService());
                    $laffectation->setAffectation($affectation);
                    $em->persist($laffectation);
 
                }
                $affectation->setRetour(0);
                $affectation->getAffaire()->setStatut(1);
                $affectationRepository->save($affectation, true);
                $session->clear();
                return $this->redirectToRoute('app_affectation_show', [
                    'id' => $affectation->getId()
                ], Response::HTTP_SEE_OTHER);

            } 
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $laffectation->setLig($lig);
                $items[$lig] = $laffectation;
                $session->set('affects', $items);
            }
        }

        return $this->renderForm('metrologies/affectation/edit.html.twig', [
            'affectation' => $affectation,
            'laffectation' => $laffectation,
            'form' => $form,
            'f' => $f,
            'items' => $items,
        ]);
    }

    #[Route('sup/{id}', name: 'app_affectation_delete', methods: ['GET'])]
    public function delete(Request $request, Affectation $affectation, AffectationRepository $affectationRepository): Response
    {
        if ($affectation) {
            if(count($affectation->getLaffectations()) !=0)
            {
                $this->addFlash('danger', 'Désolé vous ne pouvez pas supprimer cette affaire !');
                return $this->redirectToRoute('app_affectation_index', [], Response::HTTP_SEE_OTHER);
            }
            $affectationRepository->remove($affectation, true);
        }
        return $this->redirectToRoute('app_affectation_index', [], Response::HTTP_SEE_OTHER);
    }

    //delete session tables mesures isolement
    #[Route('/delete/{id}', name: 'app_delete_laffec')]
    public function supprimeSession($id,Request $request)
    {
        $session = $request->getSession();
        $items = $session->get('affects', []);
        if (array_key_exists($id, $items))
        {
            unset($items[$id]);
            $session->set('affects',$items);
        }
        return $this->redirectToRoute('app_affectation_new'); 
    } 

    //imprimer le bon de sortie
    #[Route('/print-affecatation/{id}', name: 'app_affectation_print', methods: ['POST','GET'])]
    public function print(Affectation $affectation,PdfServiceP $pdfServicePd): Response
    { 
        $html = $this->renderView('metrologies/affectation/print.html.twig', [
            'affectation' => $affectation,
        ]);
        $fichier = "Affectation : ".$affectation->getAffaire();

        return $pdfServicePd->showPdfFile($html, $fichier);

    }
    
    //delete session tables mesures isolement
    #[Route('/supprimer/{id}', name: 'app_delete_laff')]
    public function supprimeSessionData(Laffectation $laffectation,EntityManagerInterface $entityManagerInterface, Request $request, AppareilRepository $appareilRepository)
    {
        $id = $laffectation->getAffectation()->getId();
        if ($laffectation)
        {
            $appareil = $appareilRepository->findOneBy(array('id'=>$laffectation->getAppareil()));
            $appareil->setStatus(0);
            $entityManagerInterface->remove($laffectation);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_affectation_edit', ['id' => $id]);            
        }
        return $this->redirectToRoute('app_affectation_edit', ['id' => $id]); 
    } 

    //delete session tables mesures isolement
    #[Route('/sup-session/{id}/{parID}', name: 'app_delete_laffectation')]
    public function supprimeSessionEdit($id,$parID,Request $request)
    {
        $session = $request->getSession();
        $items = $session->get('affects', []);
        if (array_key_exists($id, $items))
        {
            unset($items[$id]);
            $session->set('affects',$items);
        }
        return $this->redirectToRoute('app_affectation_edit', ['id' => $parID]); 
    } 
}
