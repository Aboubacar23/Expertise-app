<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\Admin; // Importe l'entité Admin
use Doctrine\ORM\EntityManagerInterface; // Importe EntityManagerInterface pour les opérations de base de données
use Symfony\Component\HttpFoundation\Request; // Importe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe Response pour gérer les réponses HTTP
use Symfony\Component\Routing\Annotation\Route; // Importe Route pour la définition des routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController comme classe de base
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Importe UserPasswordHasherInterface pour hacher les mots de passe

#[Route('profil')] // Déclare une route principale pour ce contrôleur
class ProfilController extends AbstractController
{
    // Envoi du profil de l'utilisateur connecté
    #[Route('/index', name: 'app_profil_index')] // Déclare la route pour l'index du profil
    public function index(): Response
    {
        // Retourne la vue 'index.html.twig' du profil
        return $this->render('profil/index.html.twig');
    }

    // La fonction de changement de mot de passe
    #[Route('/password/{id}/change', name: 'change_password', methods: ['GET', 'POST'])] // Déclare la route pour le changement de mot de passe
    public function passwordProfil(Admin $admin, UserPasswordHasherInterface $userPasswordHasher, Request $request, EntityManagerInterface $entityManager)
    {
        // Vérifie si la méthode de la requête est POST
        if($request->isMethod('POST'))
        {
            // Récupère les mots de passe du formulaire
            $mdp1 = $request->request->get('mdp1');
            $mdp2 = $request->request->get('mdp2');

            // Vérifie si les deux mots de passe sont identiques
            if($mdp1 == $mdp2)
            {
                // Hash le nouveau mot de passe et le définit pour l'administrateur
                $admin->setPassword($userPasswordHasher->hashPassword($admin, $mdp1));
                // Persiste les modifications dans la base de données
                $entityManager->persist($admin);
                $entityManager->flush();

                // Affiche un message de succès
                $this->addFlash('success', 'Mot de passe modifié avec succès');
                // Redirige vers la route d'index du profil
                return $this->redirectToRoute('app_profil_index');
            }
            else
            {
                // Affiche un message d'erreur si les mots de passe ne sont pas identiques
                $this->addFlash('danger', 'Les mots de passes ne sont pas identiques');
            }
        }
        // Retourne la vue de changement de mot de passe
        return $this->renderForm('profil/change_password.html.twig');
    }
}
