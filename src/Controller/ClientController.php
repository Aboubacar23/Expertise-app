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
 * Date de Création : 24-04-2023
 * Dernière date de modification : -
 * ----------------------------------------------------------------
 * *******Template **************************
 * Les vues client se trouvent dans le dossier "client" du template
 * ********************** Description *****************************
 * Pour accéder au client, on doit être forcément connecté.
 * Ce contrôleur contient 6 fonctions :
 * 1- La fonction "index" : pour afficher la liste de tous les clients
 * 2- La fonction "new" : pour ajouter un client
 * 3- La fonction "edit" : pour modifier un client
 * 4- La fonction "delete" : pour supprimer un client
 * 5- La fonction "compte" : pour voir le compte d'un client
 * 6- La fonction "etat" : pour bloquer et débloquer un client
 */

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\AffaireRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    // Fonction pour afficher la liste de tous les clients et ajouter un nouveau client
    #[Route('/index', name: 'app_client_index', methods: ['GET','POST'])]
    public function index(ClientRepository $clientRepository, Request $request): Response
    {
        // Initialiser la classe Client
        $client = new Client();

        // Créer l'objet form à partir de la classe Client et du formulaire ClientType
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Ajouter un message flash de succès
            $this->addFlash('success', "Le client a été créé");
            // Définir l'état du client à 1 (actif)
            $client->setEtat(1);
            // Sauvegarder le client dans le repository
            $clientRepository->save($client, true);
            // Rediriger vers la route index des clients
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        // Rendre la vue avec la liste des clients et le formulaire de création
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findBy([], ['id' => 'DESC']),
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    // Fonction pour ajouter un nouveau client
    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Le client a été créé");
            $client->setEtat(1);
            $clientRepository->save($client, true);
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    // Fonction pour modifier un client existant
    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->save($client, true);
            $this->addFlash('success', "Le client a été modifié");
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    // Fonction pour supprimer un client
    #[Route('/{id}', name: 'app_client_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository, AffaireRepository $affaireRepository): Response
    {
        // Vérifier si le client est lié à une affaire
        $affaire = $affaireRepository->findByClient($client);

        if ($client) {
            // Si le client n'a pas d'affaire, le supprimer
            if (!$affaire) {
                $clientRepository->remove($client, true);
                $this->addFlash('success', "Le client a été supprimé");
                return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Sinon, envoyer un message d'erreur
                $this->addFlash('danger', "Désolé, vous ne pouvez pas supprimer ce client car il possède des affaires !");
                return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
            }
        } else {
            $this->addFlash('success', "Le client n'existe pas");
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    // Fonction pour afficher le compte d'un client
    #[Route('/compte/{id}', name: 'app_client_compte', methods: ['GET'])]
    public function compte(Client $client): Response
    {
        // Afficher les informations d'un client
        return $this->render('client/compte.html.twig', [
            'client' => $client
        ]);
    }

    // Fonction pour activer et désactiver un client
    #[Route('/etat/{id}/compte', name: 'app_client_etat', methods: ['GET'])]
    public function etat(Client $client, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si le client existe
        if ($client) {
            // Vérifier l'état du client et le basculer entre actif et inactif
            if ($client->isEtat() == 1) {
                // Si actif, désactiver
                $client->setEtat(0);
            } else {
                // Sinon, activer
                $client->setEtat(1);
            }
            // Enregistrer les changements
            $entityManager->flush();
            return $this->redirectToRoute('app_client_compte', ['id' => $client->getId()]);
        }
        return $this->redirectToRoute('app_client_index');
    }
}
