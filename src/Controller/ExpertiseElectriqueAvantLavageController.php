<?php

namespace App\Controller;

use App\Entity\ControleVisuelElectrique;
use App\Entity\Parametre;
use App\Form\ControleVisuelElectriqueType;
use App\Repository\ControleVisuelElectriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/expertiseEAL')]
class ExpertiseElectriqueAvantLavageController extends AbstractController
{
    #[Route('/electrique/avant/lavage/{id}', name: 'app_expertise_electrique_avant_lavage')]
    public function index(Parametre $parametre,Request $request,ControleVisuelElectriqueRepository $controleVisuelElectriqueRepository): Response
    {
        /**
         * A- Dans cette partie nous allons mettre tout ce qui concerne le traitement 
         * de la partie controle Visuel.
         * 1- instancier un objet de type ControleVisuel
         * 2-Dans cette partie nous allons verifie si le controle Visuel est lié à un paramêtre
         * si oui on ajoute les données dans l'objet créer, si non on envoi un objet vide à notre formulaire.
         * 3- on crée un formulaire qui va prendre l'objet créer
         * 4- On rendre ici si on click sur le bouton en cours ou terminer
         * 5- on recupère le choix selon les deux actions sur le formulaire ( en cours et terminer)
         *  + si le choix est en cours : on ajout les données dans la base de donnée et met l'etat à 0
         * + si le choix est terminer : on ajout les données dans la base de donnée et on met l'etat à 1
         * 6 - envoyer les variables à la view twig
        */

        //1 
        $controleVisuelElectrique = new ControleVisuelElectrique();
        //2
       if($parametre->getControleVisuelElectrique())
       {$controleVisuelElectrique = $parametre->getControleVisuelElectrique()->getParametre()->getControleVisuelElectrique();}

       //3
       $formControleVisuelElectique = $this->createForm(ControleVisuelElectriqueType::class, $controleVisuelElectrique);
       $formControleVisuelElectique->handleRequest($request);

        //4
        if($formControleVisuelElectique->isSubmitted() && $formControleVisuelElectique->isValid())
        {   //5
            $choix = $request->get('bouton');
            if($choix == 'controle_visuel_en_cours')
            {
                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(0);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);
            }
            elseif($choix == 'controle_visuel_terminer')
            {
                $parametre->setControleVisuelElectrique($controleVisuelElectrique);
                $controleVisuelElectrique->setEtat(1);
                $controleVisuelElectriqueRepository->save($controleVisuelElectrique, true);
                $this->redirectToRoute('app_expertise_electrique_avant_lavage', ['id' => $parametre->getId()]);

            }
        }

        //6
        return $this->render('expertise_electrique_avant_lavage/index.html.twig', [
            'parametre' => $parametre,
            'formControleVisuelElectique' => $formControleVisuelElectique->createView()
        ]);
    }
}
