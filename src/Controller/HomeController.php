<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Repository\AffaireRepository;
use App\Repository\ClientRepository;
use App\Repository\ParametreRepository;
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
        ClientRepository $clientRepository,
        ParametreRepository $parametreRepository,
        AffaireRepository $affaireRepository
    ): Response
    {

        $admin = count($adminRepository->findAll());
        $client = count($clientRepository->findAll());
        $parametres = $parametreRepository->findAll();
        $affaire = count($affaireRepository->findAll());
        $nombre = 0;
        foreach($parametres as $item)
        {
            if($item->isStatut() == 1 && $item->isRemontage() == 1)
            {
                $nombre = $nombre + 1;
            }
        }
        return $this->render('home/index.html.twig', [
            'admin' => $admin,
            'client' => $client,
            'nombre' => $nombre,
            'affaire' => $affaire,
            
        ]);
    }
}
