<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabillageController extends AbstractController
{
    #[Route('/habillage', name: 'app_habillage')]
    public function index(): Response
    {
        return $this->render('habillage/index.html.twig', [
            'controller_name' => 'HabillageController',
        ]);
    }
}
