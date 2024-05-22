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

#[Route('/settings')]
class SettingsController extends AbstractController
{
    public function __construct(private SettingsRepository $settingsRepository, private EntityManagerInterface $entityManager){}

    #[Route('/index-by-setting', name: 'app_settings_index')]
    public function createOrUpadate(Request $request): Response
    {
        // Vérifier s'il existe déjà des paramètres
        $settings = $this->settingsRepository->findOneBy([]);

        if (!$settings) {
            $settings = new Settings();
        }

        $form = $this->createForm(SettingsType::class, $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($settings);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_settings_index');
        }

        return $this->render('settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
