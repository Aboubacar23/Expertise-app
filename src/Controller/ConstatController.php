<?php

namespace App\Controller;

use App\Entity\Parametre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/constat')]
class ConstatController extends AbstractController
{
    #[Route('/{id}', name: 'app_constat_index')]
    public function index(Parametre $parametre): Response
    {
        return $this->render('constat/index.html.twig', [
            'parametre' => $parametre
        ]);
    }
}
