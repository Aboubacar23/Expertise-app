<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Définition de la route principale pour ce contrôleur
#[Route('/settings')]
class SettingsController extends AbstractController
{
    // Constructeur pour injecter les dépendances nécessaires
    public function __construct(private SettingsRepository $settingsRepository, private EntityManagerInterface $entityManager){}

    // Route pour créer ou mettre à jour les paramètres
    #[Route('/index-by-setting', name: 'app_settings_index')]
    public function createOrUpdate(Request $request): Response
    {
        // Vérifier s'il existe déjà des paramètres
        $settings = $this->settingsRepository->findOneBy([]);

        // S'il n'y a pas de paramètres, en créer de nouveaux
        if (!$settings) {
            $settings = new Settings();
        }

        // Créer le formulaire associé
        $form = $this->createForm(SettingsType::class, $settings);
        // Traiter la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Persister les paramètres et enregistrer les modifications dans la base de données
                $this->entityManager->persist($settings);
                $this->entityManager->flush();

                // Ajouter un message de succès
                $this->addFlash('success', 'Settings enrégistrer avec succès !');
            } catch (\Exception $e) {
                // Ajouter un message d'erreur
                $this->addFlash('error', 'An error occurred while saving settings.');
            }

            // Redirection vers la même route après soumission réussie
            return $this->redirectToRoute('app_settings_index');
        }

        // Rendu de la vue Twig 'settings/index.html.twig' avec le formulaire
        return $this->render('settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
