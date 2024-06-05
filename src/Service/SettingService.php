<?php

namespace App\Service;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;

class SettingService
{
    // Constructeur avec injection de dépendances
    public function __construct(private SettingsRepository $settingsRepository, private EntityManagerInterface $entityManager){}

    // Méthode pour créer ou mettre à jour les paramètres
    public function createOrUpdateSettings($data): void
    {
        // Vérifie si une instance unique de paramètres existe
        if ($this->settingsRepository->hasSingleInstance()) {
            // Récupère l'instance unique existante
            $settings = $this->settingsRepository->findOneBy([]);
        } else {
            // Crée une nouvelle instance de paramètres
            $settings = new Settings();
            // Persiste la nouvelle instance
            $this->entityManager->persist($settings);
        }

        // Mise à jour des champs de settings avec les données fournies (exemple)
        // $settings->setSomeField($data['someField']);
        // $settings->setAnotherField($data['anotherField']);

        // Sauvegarde les changements dans la base de données
        $this->entityManager->flush();
    }
}
