<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\ContreExpertise;
use App\Form\ContreExpertiseType;
use App\Repository\ContreExpertiseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contre')]
class ContreExpertiseController extends AbstractController
{
    #[Route('/contre-expertise/{id}', name: 'app_contre_expertise')]
    public function index(Parametre $parametre, ContreExpertiseRepository $contreExpertiseRepository,Request $request): Response
    {
        $contreExpertise = new ContreExpertise();

        if($parametre->getContreExpertise()){
            $contreExpertise = $parametre->getContreExpertise()->getParametre()->getContreExpertise();
        }

        $form = $this->createForm(ContreExpertiseType::class, $contreExpertise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $parametre->setContreExpertise($contreExpertise);
            $contreExpertise->setEtat(1);
            $contreExpertiseRepository->save($contreExpertise, true);
            return $this->redirectToRoute('app_contre_expertise',[
                'id' => $parametre->getId()
            ]);
        }
        return $this->render('contre_expertise/index.html.twig', [
            'form'=> $form->createView(),
            'parametre'=> $parametre
        ]);
    }
}
 