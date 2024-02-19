<?php
/**
 * ----------------------------------------------------------------
 * Projet : Base Métrologie
 * Entreprise : Jeumont Electric
 * ----------------------------------------------------------------
 * Service : Production
 * Demandeurs : Katia BION & Stéphane DESHAIES
 * ----------------------------------------------------------------
 * Développé par : Aboubacar Sidiki CONDE
 * Fonction : Stagiaire et Alternant (Ingénieur en développement web)
 * -----------------------------------------------------------------
 * Date de Création : 25-05-2023
 * Dérniere date de modification : -
 * ----------------------------------------------------------------
 *******Template **************************
 les views client se trouvent dans le dossier "client" du template
 * ********************** Déscription *****************************
 * Ce controleur est composé d'une seule fonction
 * 1- la fonction "index" : pour afficher et envoyer le formulaire de contre expertise
 */
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

        if($parametre->getContreExpertise())
        {
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
 