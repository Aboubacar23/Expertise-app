<?php

namespace App\Controller;

use App\Entity\Parametre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/expertiseEpAL')]
class ExpertiseElectriqueApresLavageController extends AbstractController
{
    #[Route('/index/{id}', name: 'app_expertise_electrique_apres_lavage')]
    public function index(Parametre $parametre): Response
    {
        return $this->render('expertise_electrique_apres_lavage/index.html.twig', [
            'parametre' => $parametre
        ]);
    }
}
