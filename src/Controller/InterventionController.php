<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Entity\Lintervention;
use App\Form\InterventionType;
use App\Form\LinterventionType;
use App\Repository\AppareilRepository;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/intervention')]
class InterventionController extends AbstractController
{
    #[Route('/index-sortie', name: 'app_intervention_index', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        return $this->render('metrologies/intervention/index.html.twig', [
            'interventions' => $interventionRepository->findAll(),
        ]);
    }

    #[Route('/newadd', name: 'app_intervention_new', methods: ['POST','GET'])]
    public function create(Request $request, InterventionRepository $interventionRepository, EntityManagerInterface $entityManagerInterface,AppareilRepository $appareilRepository): Response
    {
        $intervention = new Intervention();
        $repere = new Lintervention(); 

        $form = $this->createForm(InterventionType::class, $intervention);
        $f = $this->createForm(LinterventionType::class, $repere);
 
        $form->handleRequest($request);
        $f->handleRequest($request);

        $session = $request->getSession();
        $items = $session->get('inters', []);

        $date = date('Ym');
        $numero_sortie = $date.'1';

        if ($f->isSubmitted() && $form->isSubmitted()) 
        {
            //dd($repere);
            $choix = $request->get('bouton1');
            if ($choix == 'ajouter')
            {
                $i = 0;
                foreach($items as $item)
                {

                    $i = $i + 1;
                    $repere = new Lintervention(); 
                    $repere->setLig($i);
                    $appareil = $appareilRepository->findOneBy(array('id'=>$item->getAppareil()));
                    $repere->setAppareil($appareil);
                    $appareil->setStatus(1);
                    $repere->setDesignation($item->getDesignation());
                    $repere->setMarque($item->getMarque());
                    $repere->setTypeIntervention($item->getTypeIntervention());
                    $repere->setDateRetour($item->getDateRetour());
                    $repere->setObservation($item->getObservation());
                    $repere->setIntervention($intervention);
                    $entityManagerInterface->persist($repere);

                }

                $interventionRepository->save($intervention, true);
                $session->clear();
                return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);

            } 
            elseif($choix == 'add')
            {
                $lig = sizeof($items)+1;
                $repere->setLig($lig);
                $items[$lig] = $repere;
                $session->set('inters', $items);
            }
        }

        return $this->renderForm('metrologies/intervention/new.html.twig', [
            'intervention' => $intervention,
            'lintervention' => $repere,
            'form' => $form,
            'f' => $f,
            'items' => $items,
            'numero_sortie' => $numero_sortie
        ]);
    } 

    #[Route('/show/{id}', name: 'app_intervention_show', methods: ['GET'])]
    public function show(Intervention $intervention): Response
    {
        return $this->render('metrologies/intervention/show.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interventionRepository->save($intervention, true);

            return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('metrologies/intervention/edit.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intervention_delete', methods: ['POST'])]
    public function delete(Request $request, Intervention $intervention, InterventionRepository $interventionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
            $interventionRepository->remove($intervention, true);
        }

        return $this->redirectToRoute('app_intervention_index', [], Response::HTTP_SEE_OTHER);
    }

}
