<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\Admin; // Importe l'entité Admin
use App\Form\EditAdminType; // Importe le formulaire EditAdminType
use App\Form\PasswordEditType; // Importe le formulaire PasswordEditType
use App\Form\RegistrationFormType; // Importe le formulaire RegistrationFormType
use App\Repository\AdminRepository; // Importe le repository AdminRepository
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour les opérations de base de données
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController comme classe de base
use Symfony\Component\HttpFoundation\Request; // Importe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe Response pour gérer les réponses HTTP
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Importe UserPasswordHasherInterface pour hacher les mots de passe
use Symfony\Component\Routing\Annotation\Route; // Importe Route pour la définition des routes
use Symfony\Contracts\Translation\TranslatorInterface; // Importe TranslatorInterface pour la traduction

#[Route('/register')] // Déclare une route principale pour ce contrôleur
class RegistrationController extends AbstractController
{
    // Fonction pour afficher tous les administrateurs du système
    #[Route('/listes', name: 'app_register_index')]
    public function index(AdminRepository $adminRepository)
    {
        // Récupère tous les administrateurs dans l'ordre décroissant des ID
        $admins = $adminRepository->findBy([],['id' => 'DESC']);
        // Retourne la vue 'index.html.twig' avec la liste des administrateurs
        return $this->render('registration/index.html.twig', [
            'admins' => $admins,
        ]);
    }

    // Fonction pour ajouter un nouvel utilisateur
    #[Route('/new', name: 'app_register_new')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // Crée une nouvelle instance de Admin
        $user = new Admin();
        // Crée le formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);
        // Gère la requête
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Vérifie les rôles de l'utilisateur
            foreach($user->getRoles() as $item)
            {
                if($item == 'ROLE_CHEF_PROJET')
                {
                    // Définit l'état de l'utilisateur
                    $user->setEtat(1);
                }
            }

            // Encode le mot de passe en clair
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Persist les données de l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();
            // Affiche un message de succès
            $this->addFlash('success' , 'Administrateur ajouté avec succès !');
            // Redirige vers la route d'index des administrateurs
            return $this->redirectToRoute('app_register_index');
        }

        // Retourne la vue d'inscription avec le formulaire
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // Fonction pour modifier un utilisateur et son mot de passe
    #[Route('/edit/{id}', name : 'app_register_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Admin $admin, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        // Crée le formulaire d'édition pour l'administrateur
        $registrationForm = $this->createForm(EditAdminType::class, $admin);
        // Gère la requête
        $registrationForm->handleRequest($request);

        // Vérifie si l'administrateur n'existe pas
        if(!$admin){
            return $this->redirect('app_register_index');
        }else{
            // Vérifie si le formulaire est soumis et valide
            if ($registrationForm->isSubmitted() && $registrationForm->isValid())
            {
                // Vérifie les rôles de l'administrateur
                foreach($admin->getRoles() as $item)
                {
                    if($item == 'ROLE_CHEF_PROJET')
                    {
                        // Définit l'état de l'administrateur
                        $admin->setEtat(1);
                    }
                }
                // Sauvegarde les modifications dans la base de données
                $entityManager->flush();
                // Affiche un message de succès
                $this->addFlash('success', 'Les données de '.$admin->getNom().' '.$admin->getPrenom().' modifiées avec succès');
                // Redirige vers la route d'index des administrateurs
                return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        // Retourne la vue d'édition avec le formulaire
        return $this->renderForm('registration/edit.html.twig', [
            'admin' => $admin,
            'registrationForm' => $registrationForm
        ]);
    }

    // Fonction pour supprimer un administrateur
    #[Route('/delete/{id}', name: 'app_register_delete', methods: ['GET'])]
    public function delete(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'administrateur n'existe pas
        if(!$admin){
            return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
        }else
        {
            // Supprime l'administrateur de la base de données
            $entityManager->remove($admin);
            $entityManager->flush();
            // Affiche un message de succès
            $this->addFlash('danger', 'Administrateur supprimé avec succès');
            // Redirige vers la route d'index des administrateurs
            return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    // Fonction pour modifier le mot de passe de l'utilisateur
    #[Route('/edit-password/{id}', name : 'app_register_password_user', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, Admin $admin, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        // Crée le formulaire de modification de mot de passe
        $registrationForm = $this->createForm(PasswordEditType::class, $admin);
        // Gère la requête
        $registrationForm->handleRequest($request);

        // Vérifie si l'administrateur n'existe pas
        if(!$admin){
            return $this->redirect('app_register_index');
        }else{
            // Vérifie si le formulaire est soumis et valide
            if ($registrationForm->isSubmitted() && $registrationForm->isValid())
            {
                // Encode le nouveau mot de passe
                $admin->setPassword(
                    $userPasswordHasher->hashPassword(
                        $admin,
                        $registrationForm->get('plainPassword')->getData()
                    )
                );
                // Sauvegarde les modifications dans la base de données
                $entityManager->flush();
                // Affiche un message de succès
                $this->addFlash('success', 'Mot de passe de '.$admin->getNom().' '.$admin->getPrenom().' modifié avec succès');
                // Redirige vers la route d'index des administrateurs
                return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        // Retourne la vue de modification de mot de passe avec le formulaire
        return $this->renderForm('registration/password.html.twig', [
            'admin' => $admin,
            'registrationForm' => $registrationForm
        ]);
    }
}
