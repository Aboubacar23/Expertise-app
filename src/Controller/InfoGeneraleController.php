<?php

namespace App\Controller;

use App\Entity\InfoGenerale;
use App\Entity\Parametre;
use App\Form\InfoGeneraleType;
use App\Repository\InfoGeneraleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Déclare la classe InfoGeneraleController qui hérite d'AbstractController
#[Route('/info')]
class InfoGeneraleController extends AbstractController
{
    // Route pour afficher et gérer les informations générales
    #[Route('/index-info-generale/{id}', name: 'app_info_generale')]
    public function index(Parametre $parametre, InfoGeneraleRepository $infoGeneraleRepository, Request $request): Response
    {
        // Initialise une nouvelle instance d'InfoGenerale
        $infoGenerale = new InfoGenerale();

        // Si le paramètre possède des informations générales, récupère les informations générales existantes
        if($parametre->getInfoGenerale())
        {
            $infoGenerale = $parametre->getInfoGenerale()->getParametre()->getInfoGenerale();
        }

        // Crée le formulaire pour les informations générales
        $form = $this->createForm(InfoGeneraleType::class, $infoGenerale);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistre les informations générales
        if ($form->isSubmitted() && $form->isValid())
        {
            $parametre->setInfoGenerale($infoGenerale);
            $infoGenerale->setEtat(1);
            $infoGeneraleRepository->save($infoGenerale, true);
            return $this->redirectToRoute('app_info_generale',[
                'id' => $parametre->getId()
            ]);
        }

        // Rend la vue pour les informations générales
        return $this->render('info_generale/index.html.twig', [
            'form'=> $form->createView(),
            'parametre'=> $parametre
        ]);
    }
}
