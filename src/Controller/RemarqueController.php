<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\Remarque; // Importe l'entité Remarque
use App\Form\RemarqueType; // Importe le formulaire RemarqueType
use App\Repository\RemarqueRepository; // Importe le repository RemarqueRepository
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour les opérations de base de données
use Symfony\Component\HttpFoundation\Request; // Importe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe Response pour gérer les réponses HTTP
use Symfony\Component\Routing\Annotation\Route; // Importe Route pour la définition des routes
use Symfony\Component\String\Slugger\SluggerInterface; // Importe SluggerInterface pour créer des slugs
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController comme classe de base
use Symfony\Component\HttpFoundation\File\Exception\FileException; // Importe FileException pour gérer les exceptions de fichiers

// Déclare une route principale pour ce contrôleur
#[Route('/remarque')]
class RemarqueController extends AbstractController
{
    // Route pour afficher la page d'index des remarques avec un formulaire de recherche
    #[Route('/aides', name: 'app_remarque_index', methods: ['GET','POST'])]
    public function index(): Response
    {
        // Renvoie la vue 'aides.html.twig' avec le paramètre 'aides'
        return $this->render('home/aides.html.twig', [
            'aides' => 'aides',
        ]);
    }

    // Route pour créer une nouvelle remarque
    #[Route('/new', name: 'app_remarque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RemarqueRepository $remarqueRepository): Response
    {
        // Crée une nouvelle instance de Remarque
        $remarque = new Remarque();
        // Crée le formulaire pour la remarque
        $form = $this->createForm(RemarqueType::class, $remarque);
        // Gère la requête
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde la remarque dans la base de données
            $remarqueRepository->save($remarque, true);

            // Redirige vers la route d'index des remarques
            return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
        }

        // Renvoie la vue 'new.html.twig' avec le formulaire
        return $this->renderForm('remarque/new.html.twig', [
            'remarque' => $remarque,
            'form' => $form,
        ]);
    }

    // Route pour afficher une remarque spécifique
    #[Route('/{id}', name: 'app_remarque_show', methods: ['GET'])]
    public function show(Remarque $remarque): Response
    {
        // Renvoie la vue 'show.html.twig' avec la remarque
        return $this->render('remarque/show.html.twig', [
            'remarque' => $remarque,
        ]);
    }

    // Route pour modifier une remarque existante
    #[Route('/{id}/edit', name: 'app_remarque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository, SluggerInterface $slugger): Response
    {
        // Crée le formulaire pour la remarque
        $form = $this->createForm(RemarqueType::class, $remarque);
        // Gère la requête
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère l'image téléchargée
            $image = $form->get('image')->getData();

            // Vérifie s'il y a une image
            if ($image) {
                // Génère un nom de fichier sécurisé pour l'image
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    // Déplace l'image vers le répertoire de stockage
                    $image->move(
                        $this->getParameter('images_remarque'),
                        $newPhotoname
                    );
                } catch (FileException $e){}
                // Associe le nouveau nom de fichier à la remarque
                $remarque->setImage($newPhotoname);
            }
            // Sauvegarde la remarque dans la base de données
            $remarqueRepository->save($remarque, true);

            // Redirige vers la route d'index des remarques
            return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
        }

        // Renvoie la vue 'edit.html.twig' avec le formulaire
        return $this->renderForm('remarque/edit.html.twig', [
            'remarque' => $remarque,
            'form' => $form,
        ]);
    }

    // Route pour supprimer une remarque
    #[Route('/delete-remarque/{id}', name: 'app_remarque_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository): Response
    {
        // Vérifie s'il y a une remarque à supprimer
        if ($remarque)
        {
            // Récupère le nom de l'image associée à la remarque
            $nom = $remarque->getImage();
            // Supprime l'image du répertoire de stockage
            unlink($this->getParameter('images_remarque').'/'.$nom);
            // Supprime la remarque de la base de données
            $remarqueRepository->remove($remarque, true);
        }

        // Redirige vers la route d'index des remarques
        return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
    }

    // Route pour valider (clôturer) une remarque
    #[Route('/valider-remarque/{id}', name: 'app_remarque_cloture', methods: ['GET','POST'])]
    public function valider(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository, EntityManagerInterface $em): Response
    {
        // Vérifie s'il y a une remarque à valider
        if ($remarque)
        {
            // Vérifie l'état de la remarque
            if ($remarque->isEtat() == 0)
            {
                // Met à jour l'état de la remarque
                $remarque->setEtat(1);
                // Persiste la remarque
                $em->persist($remarque);
                // Sauvegarde dans la base de données
                $em->flush();
            }
        }

        // Redirige vers la route d'index des remarques
        return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
    }
}
