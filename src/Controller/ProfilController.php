<?php

namespace App\Controller;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('profil')]
class ProfilController extends AbstractController
{
    //envoi du profil de l'utilisateur connecter
    #[Route('/index', name: 'app_profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    //la fonction de changement de mot pass
    #[Route('/password/{id}/change', name: 'change_password', methods: ['GET', 'POST'])]
    public function passwordProfil(Admin $admin,UserPasswordHasherInterface $userPasswordHasher, Request $request, EntityManagerInterface $entityManager)
    {
        if($request-> isMethod('POST'))
        { 
            $mdp1 = $request->request->get('mdp1');
            $mdp2 = $request->request->get('mdp2');
            if($mdp1 == $mdp2)
            {
                $admin->setPassword($userPasswordHasher->hashPassword($admin, $mdp1));
                $entityManager->persist($admin);
                $entityManager->flush();

                $this->addFlash('success', 'Mot de passe modifié avec success');
                return $this->redirectToRoute('app_profil_index');
            }
            else 
            {
                $this->addFlash('danger', 'Les mots de passes ne sont pas identiques');
            }
        }
        return $this->renderForm('profil/change_password.html.twig');
    }
}
