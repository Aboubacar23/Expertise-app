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
 * Date de Création : 02-10-2023
 * Dérniere date de modification : -
 * ----------------------------------------------------------------
 * ********************** Déscription *****************************
 * ## À savoir que l'accès à la page affaire est obligatoire
 * Base de données : 
 *      + nom table : affaireMetrologie
 * 
 * template :
 *      chaque fonction pointe sur une page vue du projet dans le dossier 
 * 
 * Dans ce controleur vous avez 5 fonctions qui assure le bon fonctionnement du module affaireMetrologie.
 *      2- la fonction "index",qui affiche la liste de tous les appareils
 *      3- la fonction "new", pour ajouter une nouvelle affaireMetrologie dans la base de données
 *      4- la fonction "show", affiche les informations d'une seule affaireMetrologie en fonction de son ID
 *      5- la fonction "edit", permet de modifier une affaireMetrologie
 *      6- la fonction "delete", permet de supprimer une affaireMetrologie
 */

namespace App\Controller;

use App\Entity\AffaireMetrologie;
use App\Form\AffaireMetrologieType;
use App\Repository\AffaireMetrologieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chantier/metrologie')]
class AffaireMetrologieController extends AbstractController
{
    #[Route('/index-affaire', name: 'app_affaire_metrologie_index', methods: ['GET'])]
    public function index(AffaireMetrologieRepository $affaireMetrologieRepository): Response
    {
        return $this->render('metrologies/affaire_metrologie/index.html.twig', [
            'affaire_metrologies' => $affaireMetrologieRepository->findBy([],['id' =>'desc']),
        ]);
    }

    #[Route('/new', name: 'app_affaire_metrologie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffaireMetrologieRepository $affaireMetrologieRepository): Response
    {
        $affaireMetrologie = new AffaireMetrologie();
        $form = $this->createForm(AffaireMetrologieType::class, $affaireMetrologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaireMetrologie->setStatut(0);
            $affaireMetrologieRepository->save($affaireMetrologie, true);
            return $this->redirectToRoute('app_affaire_metrologie_index', [], Response::HTTP_SEE_OTHER);
            $this->addFlash('success', "Ajouter avec succès");
        }

        return $this->renderForm('metrologies/affaire_metrologie/new.html.twig', [
            'affaire_metrologie' => $affaireMetrologie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_metrologie_show', methods: ['GET'])]
    public function show(AffaireMetrologie $affaireMetrologie): Response
    {
        return $this->render('metrologies/affaire_metrologie/show.html.twig', [
            'affaire_metrologie' => $affaireMetrologie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_metrologie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AffaireMetrologie $affaireMetrologie, AffaireMetrologieRepository $affaireMetrologieRepository): Response
    {
        $form = $this->createForm(AffaireMetrologieType::class, $affaireMetrologie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affaireMetrologieRepository->save($affaireMetrologie, true);

            return $this->redirectToRoute('app_affaire_metrologie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('metrologies/affaire_metrologie/edit.html.twig', [
            'affaire_metrologie' => $affaireMetrologie,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_affaire_metrologie_delete', methods: ['GET'])]
    public function delete(Request $request, AffaireMetrologie $affaireMetrologie, AffaireMetrologieRepository $affaireMetrologieRepository): Response
    {
        if ($affaireMetrologie) {
            if(count($affaireMetrologie->getAffectations()) != 0)
            {
                $this->addFlash('danger', 'Désolé vous ne pouvez pas supprimer cette affaire !');
                return $this->redirectToRoute('app_affaire_metrologie_index', [], Response::HTTP_SEE_OTHER);
            }
            $affaireMetrologieRepository->remove($affaireMetrologie, true);
            $this->addFlash('success', "Supprimer avec succès");
        }

        return $this->redirectToRoute('app_affaire_metrologie_index', [], Response::HTTP_SEE_OTHER);
    }
}
