<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/metrologie')]
class MetrologieController extends AbstractController
{
    #[Route('/index-metrologie', name: 'app_metrologie')]
    public function index(): Response
    {
        return $this->render('metrologies/index.html.twig', [
            'controller_name' => 'MetrologieController',
        ]);
    }
}
