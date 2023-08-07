<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Repository\AdminRepository;
use App\Repository\AffaireRepository;
use App\Repository\ClientRepository;
use App\Repository\ParametreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/expertise-jeumont')]
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
    public function index(AdminRepository $adminRepository,ClientRepository $clientRepository,ParametreRepository $parametreRepository,AffaireRepository $affaireRepository): Response
    {

        $admin = count($adminRepository->findAll());
        $client = count($clientRepository->findAll());
        $parametres = $parametreRepository->findAll();
        $affaire = count($affaireRepository->findAll());
        $nombre = 0;
        $encours = 0;
        $terminer = 0;
        $var_encours = 0;
        $var_terminer = 0;
        $encoursPourc = 0;
        $terminerPourc = 0;
        $bloqueVal = 0;
        $bloque = 0;
        $var_par = count($parametres);

        $tables = $affaireRepository->findBy([],['id' => 'desc']);
        $affaires = [];

        foreach($tables as $item2)
        {
            foreach($item2->getParametres() as $item)
            {
                if($item->isStatut() == 1 && $item->isRemontage() == 1)
                {
                    $nombre = $nombre + 1;
                }
    
                if($item->isStatut() == 0)
                {
                    $var_encours = $var_encours + 1;
                }else{
                    $var_terminer = $var_terminer + 1;
                }

                if($item->getAffaire()->isBloque())
                {
                    $bloqueVal = $bloqueVal + 1;
                }
            }

            if($item2->isEtat() != 1)
            {
                array_push($affaires, $item2);
            }
        }

        $encoursPourc = 100 *($var_encours/$var_par);
        $terminerPourc = 100 *($var_terminer/$var_par);
        $bloque = 100 *($bloqueVal/$var_par);

        $encours = $var_encours;
        $terminer = $var_terminer;
      //  dd($var_par);


        return $this->render('home/index.html.twig', [
            'admin' => $admin,
            'client' => $client,
            'nombre' => $nombre,
            'var_par' => $var_par,
            'affaire' => $affaire,
            'encours' => $encours,
            'encoursPourc' => $encoursPourc,
            'terminerPourc' => $terminerPourc,
            'bloque' => $bloque,
            'bloqueVal' => $bloqueVal,
            'terminer' => $terminer,
            'affaires' => $affaires,

            
        ]);
    }


    //la fonction qui affiche la liste des affaires terminer
    #[Route('/corbeille-listes', name: 'app_corbeille_listes', methods: ['GET'])]
    public function rapport(ParametreRepository $parametreRepository): Response
    {
        $listes = $parametreRepository->findBy([],['id' => 'desc']);
        $parametres = [];

        foreach($listes as $item)
        {
            if($item->isCorbeille() == true)
            {
                array_push($parametres, $item);
            }
        }

        return $this->render('home/corbeille.html.twig', [
            'parametres' => $parametres,
        ]);
    }
}
