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

#[Route('/info')]
class InfoGeneraleController extends AbstractController
{
    #[Route('/index-info-generale/{id}', name: 'app_info_generale')]
    public function index(Parametre $parametre, InfoGeneraleRepository $infoGeneraleRepository,Request $request): Response
    {  
        $infoGenerale = new InfoGenerale();

        if($parametre->getInfoGenerale())
        {
            $infoGenerale = $parametre->getInfoGenerale()->getParametre()->getInfoGenerale();
        }

        $form = $this->createForm(InfoGeneraleType::class, $infoGenerale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $parametre->setInfoGenerale($infoGenerale);
            $infoGenerale->setEtat(1);
            $infoGeneraleRepository->save($infoGenerale, true);
            return $this->redirectToRoute('app_info_generale',[
                'id' => $parametre->getId()
            ]);
        }

        return $this->render('info_generale/index.html.twig', [
            'form'=> $form->createView(),
            'parametre'=> $parametre
        ]);
    }
}
