<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\EditAdminType;
use App\Form\PasswordEditType;
use App\Form\RegistrationFormType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


#[Route('/register')]
class RegistrationController extends AbstractController
{
    //la fonction index pour afficher tous les admin du système

    #[Route('/listes', name: 'app_register_index')]
    public function index(AdminRepository $adminRepository)
    {
        //tableaux des admins dans l'ordre 
        $admins = $adminRepository->findBy([],['id' => 'DESC']);
        //return la tableau à la view index de registration
        return $this->render('registration/index.html.twig', [
            'admins' => $admins,
        ]);

    }

    //la fonction pour ajouter l'utilisateur
    #[Route('/new', name: 'app_register_new')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Admin();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            //ddddddddddd
            foreach($user->getRoles() as $item)
            {
                if($item == 'ROLE_CHEF_PROJET')
                {
                    $user->setEtat(1);
                }
            }
        
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success' , 'Administrateur ajouter avec succès !');
            return $this->redirectToRoute('app_register_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    //la fonction pour changer un utilisateur et son mot de passe
    #[Route('/edit/{id}', name : 'app_register_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Admin $admin, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $registrationForm = $this->createForm(EditAdminType::class, $admin);
        $registrationForm->handleRequest($request);
        if(!$admin){
            return $this->redirect('app_register_index');
        }else{
            if ($registrationForm->isSubmitted() && $registrationForm->isValid())
            {
                foreach($admin->getRoles() as $item)
                {
                    if($item == 'ROLE_CHEF_PROJET')
                    {
                        $admin->setEtat(1);
                    }
                }
                $entityManager->flush();
                $this->addFlash('success', 'les données de '.$admin->getNom().' '.$admin->getPrenom().' modifiés avec succès');
                return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
            }
    
        }
        return $this->renderForm('registration/edit.html.twig', [
            'admin' => $admin,
            'registrationForm' => $registrationForm
        ]);

    }

    //la fonction pour supprimer un administrateur
    #[Route('/delete/{id}', name: 'app_register_delete', methods: ['GET'])]
    public function delete(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        if(!$admin){
            return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
        }else
        {
            $entityManager->remove($admin);
            $entityManager->flush();
            $this->addFlash('danger', 'Administrateur supprimer avec succès');
            return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    //modifier le mot de passe de l'utilisateur
    #[Route('/edit-password/{id}', name : 'app_register_password_user', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, Admin $admin, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $registrationForm = $this->createForm(PasswordEditType::class, $admin);
        $registrationForm->handleRequest($request);
        if(!$admin){
            return $this->redirect('app_register_index');
        }else{
            if ($registrationForm->isSubmitted() && $registrationForm->isValid())
            {
                $admin->setPassword(
                    $userPasswordHasher->hashPassword(
                        $admin,
                        $registrationForm->get('plainPassword')->getData()
                    )
                );
                $entityManager->flush();
                $this->addFlash('success', 'Mot de passe de '.$admin->getNom().' '.$admin->getPrenom().' modifié avec succès');
                return $this->redirectToRoute('app_register_index', [], Response::HTTP_SEE_OTHER);
            }

        }
        return $this->renderForm('registration/password.html.twig', [
            'admin' => $admin,
            'registrationForm' => $registrationForm
        ]);

    }

}
