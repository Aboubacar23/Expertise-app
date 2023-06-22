<?php

namespace App\Controller;

use App\Entity\Affaire;
use App\Form\AffaireType;
use App\Repository\AffaireRepository;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire')]
class AffaireController extends AbstractController
{
    //la fonction qui affiche la liste des affaires en coures
    #[Route('/en_cours', name: 'app_affaire_index', methods: ['GET'])]
    public function index(AffaireRepository $affaireRepository): Response
    {
        $affaires = [];
        $tabs = $affaireRepository->findBy([],['id' => 'desc']);
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

    #[Route('/new', name: 'app_affaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireRepository $affaireRepository): Response
    {
        $affaire = new Affaire();
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaire->setEtat(0);
            $affaireRepository->save($affaire, true);

            return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/new.html.twig', [
            'affaire' => $affaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_show', methods: ['GET'])]
    public function show(Affaire $affaire,ParametreRepository $parametreRepository): Response
    {
        $listes = $parametreRepository->findAll();
        $active = false;
        foreach($listes as $item)
        {
            if ($item->getAffaire()->getId() == $affaire->getId()){
                $active = true;
            }
        }
        return $this->render('affaire/show.html.twig', [
            'affaire' => $affaire,
            'active' => $active
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        $form = $this->createForm(AffaireType::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function delete(Request $request, Affaire $affaire, AffaireRepository $affaireRepository): Response
    {
        if ($affaire) {
            $affaireRepository->remove($affaire, true);
            return $this->redirectToRoute('app_affaire_index', [], Response::HTTP_SEE_OTHER);
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

       //la fonction qui affiche la liste des affaires terminer
       #[Route('/bloque-activer/{id}', name: 'app_bloque', methods: ['GET'])]
       public function bloque(Affaire $affaire, EntityManagerInterface $em): Response
       {
           if($affaire)
           {
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
}
