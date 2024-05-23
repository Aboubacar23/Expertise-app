<?php

namespace App\Service;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;



class SettingService
{
    public function __construct(private SettingsRepository $settingsRepository, private EntityManagerInterface $entityManager){}

    public function createOrUpdateSettings($data): void
    {
        if ($this->settingsRepository->hasSingleInstance())
        {
            $settings = $this->settingsRepository->findOneBy([]);
        }else{
            $settings = new Settings();
            $this->entityManager->persist($settings);
        }

        $this->entityManager->flush();
    }
}