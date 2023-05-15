<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * dans cette fonction nous allons récuperer le nombre total de tous les 
     * élements de l'application pour envoyer au dashboard
     *
     * @param AdminRepository $adminRepository
     * @return Response
     */
    #[Route('/home', name: 'app_home')]
    public function index(
        AdminRepository $adminRepository,
        ClientRepository $clientRepository
    ): Response
    {

        $admin = count($adminRepository->findAll());
        $client = count($clientRepository->findAll());
        return $this->render('home/index.html.twig', [
            'admin' => $admin,
            'client' => $client,
        ]);
    }
}
