<?php

namespace App\Controller;

use App\Entity\Chercher;
use App\Form\ChercherType;
use App\Repository\AppareilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/chercher')]
class ChercherController extends AbstractController
{
    #[Route('/index-filtre-par-attributs', name: 'app_chercher')]
    public function index(AppareilRepository $appareilRepository, Request $request): Response
    {
        $chercher = new Chercher();
        $form = $this->createForm(ChercherType::class, $chercher);
        $form->handleRequest($request);

        $appareils = $appareilRepository->findAll();

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($request->get('bouton') == 'ajouter')
            {
                dd('aaa');
                $appareils = $appareilRepository->findChercher($chercher);
                dd($appareils);
            }
        }

        return $this->render('metrologies/chercher/index.html.twig', [
            'form' => $form->createView(),
            'chercher' => $chercher
        ]);
    }
}
