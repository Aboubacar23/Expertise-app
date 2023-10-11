<?php

namespace App\Controller;

use DateTime;
use App\Entity\Admin;
use App\Entity\Affaire;
use App\Entity\Archive;
use App\Entity\Parametre;
use App\Form\AffaireType;
use App\Form\ArchiveType;
use App\Repository\AffaireRepository;
use App\Repository\ArchiveRepository;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/affaire')]
class AffaireController extends AbstractController
{
    //la fonction qui affiche la liste des affaires en cours
    #[Route('/en_cours', name: 'app_affaire_index', methods: ['GET'])]
    public function index(AffaireRepository $affaireRepository): Response
    {
        $affaires = [];
        $tabs = $affaireRepository->findBy([],['id' => 'desc']);

        //cette boucle permet de retourner un tableau des affaires en cours
        foreach($tabs as $item){
            if($item->isEtat() == 0){
                array_push($affaires, $item);
            }
        }
       // dd($affaires);
        return $this->render('affaire/en_cours.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    //la fonction qui affiche la liste de toutes les affaires
    #[Route('/listes', name: 'app_affaire_liste', methods: ['GET'])]
    public function listes(AffaireRepository $affaireRepository): Response
    {
        $affaires = $affaireRepository->findBy([],['id' => 'desc']);
       // dd($affaires);
        return $this->render('affaire/index.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    //ajouter une nouvelle affaire
    #[Route('/new', name: 'app_affaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository): Response
    {
        //inialiser une variable de classe
        $affaire = new Affaire();

        //créer une variable form, qui contient la classe de du formulaire des affaires
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);
        $date = date("d-m-Y");
        //dd($date);
        //récupérer l'utilisateur connecter 
        $user = $this->getUser()->getNom().' '.$this->getUser()->getPrenom();
        
        //on vérifie l'envoi du l'ormulaire avant d'ajouté les informations dans la base
        if ($form->isSubmitted() && $form->isValid()) 
        {
            if ($affaire->getDateLivraison()->format('d-m-Y') > $date)
            {
                //ajouter l'utilisateur sur une affaire
                $affaire->setUser($user);
                $affaire->setEtat(0);

                //enregistrer les informations dans la base de données
                $affaireRepository->save($affaire, true);

                return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);

            }else{       
                $this->addFlash('error',"Désolé ! La date de livraison est inférieur à la date du jour");         
                return $this->redirectToRoute('app_affaire_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('affaire/new.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    //la fonction pour retourner une seule affaire
    #[Route('/{id}', name: 'app_affaire_show', methods: ['GET','POST'])]
    public function show(Affaire $affaire,ParametreRepository $parametreRepository, ArchiveRepository $archiveRepository, Request $request, SluggerInterface $slugger): Response
    {   
        //envoyer une variable active true pour désactiver et activer le parametre
        $listes = $parametreRepository->findAll();
        $active = false;
        $fermer = false;
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $affaire->getId()){
                $active = true;
                if ($item->isRemontage() == true && $item->isExpertiseElectiqueApresLavage() ==true && $item->isExpertiseElectiqueAvantLavage() == true && $item->isExpertiseMecanique() == true)
                {
                    $fermer = true;
                }
            }
        }
        //dd($active);
        //traitement des archives
        $archive = new Archive();
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        //verifie s'il y a une version existant de cette affaire pour connaitre le nombre total
        $num = 0;
        if($affaire->getArchives())
        {
            $num = count($affaire->getArchives()) + 1;
        }
        $lettre = '';
        if($num == 1){ $lettre = 'A';}
        elseif($num == 2){ $lettre = 'B';}
        elseif($num == 3){ $lettre = 'C';}
        elseif($num == 4){ $lettre = 'D';}
        elseif($num == 5){ $lettre = 'E';}
        elseif($num == 6){ $lettre = 'F';}
        $version = 'Indice-'.$lettre;

        if ($form->isSubmitted() && $form->isValid())
        {
            $fichier = $form->get('fichier')->getData();
            if ($fichier) {
                $originaleFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME); 
                $safeFichier = $slugger->slug($originaleFichier);
                $newFichierName = $safeFichier . '-' . uniqid() . '.' . $fichier->guessExtension();
                try {
                    $fichier->move(
                        $this->getParameter('fichier_archives'),
                        $newFichierName
                    );
                } catch (FileException $e){}
            }
            $archive->setAffaire($affaire);
            $archive->setFichier($newFichierName);
            $archiveRepository->save($archive, true);
            $this->addFlash('success', 'Vous avez créé une archive sur cette affaire');
            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId(),
            ], Response::HTTP_SEE_OTHER);
        }
        //fin d'archiver
        return $this->render('affaire/show.html.twig', [
            'affaire' => $affaire,
            'active' => $active,
            'form' => $form->createView(),
            'archive' => $archive,
            'version' => $version,
            'fermer' => $fermer
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        $user = $this->getUser()->getNom().' '.$this->getUser()->getPrenom();
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $affaire->setUser($user);
            $affaireRepository->save($affaire, true);
            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/edit.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_affaire_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Affaire $affaire, AffaireRepository $affaireRepository,ParametreRepository $parametreRepository): Response
    {
        $parametre = $parametreRepository->findByAffaire($affaire);
        if ($affaire) 
        {
            if (!$parametre)
            {
                $affaireRepository->remove($affaire, true);
                return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
            }
            else
            {
                $this->addFlash('danger', "Désolé vous ne pouvez pas supprimer cette affaire car il possède des paramètres ! ");
                return $this->redirectToRoute('app_affaire_show', [
                    'id' => $affaire->getId()
                ], Response::HTTP_SEE_OTHER);

            }
        }
        return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);

    }

     //la fonction qui affiche la liste des affaires terminer
    #[Route('/rapports/listes', name: 'app_affaire_rapport', methods: ['GET'])]
    public function rapport(ParametreRepository $parametreRepository, AffaireRepository $affaireRepository): Response
    {
        $affaires = $affaireRepository->findBy([],['id' => 'desc']);
        return $this->render('affaire/rapport.html.twig', [
            'affaires' => $affaires,
        ]);
    }

    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/bloque-activer/{id}', name: 'app_bloque', methods: ['GET'])]
    public function bloque(Affaire $affaire, EntityManagerInterface $em): Response
    {
        //on vérifi si l'affaire existe
        if($affaire)
        {
            /**
             * si l'attribut bloque est true
             * il lui passe en false
             * si non il lui passe en true
             */
            if($affaire->isBloque() == 1)
            {
                $affaire->setBloque(0);
                $em->persist($affaire);
            }else{
                $affaire->setBloque(1);
                $em->persist($affaire);
            }

        $em->flush();
        return $this->redirectToRoute('app_affaire_show', ['id' => $affaire->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_affaire_show', ['id' => $affaire->getId()], Response::HTTP_SEE_OTHER);
    }

    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/corbeille/{id}', name: 'app_corbeille', methods: ['GET'])]
    public function corbeille(Parametre $parametre, EntityManagerInterface $em): Response
    {
        //on vérifi si l'affaire existe
        if($parametre)
        {
            if($parametre->isCorbeille() == 1)
            {
                $parametre->setCorbeille(0);
                $em->persist($parametre);
            }else{
                $parametre->setCorbeille(1);
                $em->persist($parametre);
            }
            $em->flush();
            return $this->redirectToRoute('app_affaire_show', ['id' => $parametre->getAffaire()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_affaire_show', ['id' => $parametre->getAffaire->getAffaire()->getId()], Response::HTTP_SEE_OTHER);
    }
}
