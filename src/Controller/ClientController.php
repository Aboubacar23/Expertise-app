<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    //cette fonction permet de récuper tous les client du systeme de la base 
    #[Route('/index', name: 'app_client_index', methods: ['GET','POST'])]
    public function index(ClientRepository $clientRepository, Request $request): Response
    {   
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Le client a été créer ");
            $client->setEtat(1);
            $clientRepository->save($client, true);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findBy([], ['id' => 'DESC']),
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    //cette fonction permet d'ajouter un client dans la base de donnée
    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', "Le client a été créer ");
            $client->setEtat(1);
            $clientRepository->save($client, true);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    //la fonction pour modifier un client
    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->save($client, true);

            $this->addFlash('success', "Le client a été modifier");
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    //la fonction pour supprimer un client
    #[Route('/{id}', name: 'app_client_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        if($client){
            $clientRepository->remove($client, true);
            $this->addFlash('success', "Le client a été bien supprimer ");
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }else{
            $this->addFlash('success', "Le client n'existe pas ");
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    //la fonction pour afficher le compte d'un client
    #[Route('/compte/{id}', name : 'app_client_compte', methods:['GET'])]
    public function compte(Client $client)
    {
        return $this->render('client/compte.html.twig', [
            'client' => $client
        ]);
    } 


    //la fonction permet d'activer et désactiver un client
    #[Route('/etat/{id}/compte', name : 'app_client_etat', methods:['GET'])]
    public function etat(Client $client, EntityManagerInterface $entityManager)
    {
        if ($client){
            if ($client->isEtat() == 1){
                $client->setEtat(0);
                $entityManager->flush();
                return $this->redirectToRoute('app_client_compte', ['id' => $client->getId()]);
            }
            else{
                $client->setEtat(1);
                $entityManager->flush();
                return $this->redirectToRoute('app_client_compte', ['id' => $client->getId()]);
            }
        }
        return $this->redirectToRoute('app_client_index');
    } 
}
