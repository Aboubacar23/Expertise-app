<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/validation')]
class ValidationController extends AbstractController
{
    #[Route('/index', name: 'app_validation_index')]
    public function index(ParametreRepository $parametreRepository): Response
    {
        $lists = $parametreRepository->findBy([],['id'=> 'desc']);
        $parametres  = [];
        foreach ($lists as $item)
        {
            if($item->isStatut() == null && $item->isExpertiseElectiqueAvantLavage() == 1 && $item->isExpertiseElectiqueApresLavage() == 1)           
            {
                array_push($parametres, $item);
            }
        }

        return $this->render('validation/index.html.twig', [
            'parametres' => $parametres,
        ]);
    }


    #[Route('/show/{id}', name: 'app_validation_show')]
    public function show(Parametre $parametre): Response
    {
        if($parametre)
        {
            return $this->render('validation/show.html.twig', [
                'parametre' => $parametre,
            ]);

        }
    }

    #[Route('/validation/{id}', name: 'app_validation_valide')]
    public function validation(Parametre $parametre, EntityManagerInterface $em): Response
    {
        if($parametre)
        {
            $parametre->setStatut(1);
            $em->persist($parametre);
            $em->flush();
            return $this->redirectToRoute('app_affaire_rapport');
        }
    }
}
