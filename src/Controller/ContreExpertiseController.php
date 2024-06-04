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
 * Dernière date de modification : -
 * ----------------------------------------------------------------
 * *******Template **************************
 * Les vues client se trouvent dans le dossier "client" du template
 * ********************** Description *****************************
 * Ce contrôleur est composé d'une seule fonction :
 * 1- La fonction "index" : pour afficher et envoyer le formulaire de contre expertise
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
    // Fonction pour afficher et envoyer le formulaire de contre expertise
    #[Route('/contre-expertise/{id}', name: 'app_contre_expertise')]
    public function index(Parametre $parametre, ContreExpertiseRepository $contreExpertiseRepository, Request $request): Response
    {
        // Crée une nouvelle instance de ContreExpertise
        $contreExpertise = new ContreExpertise();

        // Si le paramètre a déjà une contre-expertise, récupère cette contre-expertise
        if ($parametre->getContreExpertise()) {
            $contreExpertise = $parametre->getContreExpertise()->getParametre()->getContreExpertise();
        }

        // Crée le formulaire pour l'entité ContreExpertise
        $form = $this->createForm(ContreExpertiseType::class, $contreExpertise);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Lie la contre-expertise au paramètre
            $parametre->setContreExpertise($contreExpertise);
            // Définit l'état de la contre-expertise
            $contreExpertise->setEtat(1);
            // Sauvegarde la contre-expertise dans la base de données
            $contreExpertiseRepository->save($contreExpertise, true);
            // Redirige vers la même route pour recharger la page
            return $this->redirectToRoute('app_contre_expertise', [
                'id' => $parametre->getId()
            ]);
        }

        // Rend la vue avec le formulaire de contre expertise
        return $this->render('contre_expertise/index.html.twig', [
            'form' => $form->createView(),
            'parametre' => $parametre
        ]);
    }
}
