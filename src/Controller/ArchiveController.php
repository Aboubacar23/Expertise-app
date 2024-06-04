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
 * Dernière date de modification : -
 * ----------------------------------------------------------------
 * ********************** Description *****************************
 * L'accès à cette page est obligatoire.
 * Dans ce contrôleur, il y a deux fonctions principales :
 *  1- la fonction "index" : pour afficher la liste des dossiers archivés (historiques).
 *  2- la fonction "delete" : pour supprimer une archive.
 *
 */

namespace App\Controller;

use App\Entity\Archive;
use App\Repository\ArchiveRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/archive')]
class ArchiveController extends AbstractController
{
    // Fonction pour afficher la liste des archives
    #[Route('/index-archive', name: 'app_archive_index')]
    public function index(ArchiveRepository $archiveRepository): Response
    {
        // Récupère toutes les archives, triées par identifiant de manière décroissante
        $archives = $archiveRepository->findBy([], ['id' => 'desc']);

        // Rend la vue 'archive/index.html.twig' avec la liste des archives
        return $this->render('archive/index.html.twig', [
            'archives' => $archives,
        ]);
    }

    // Fonction pour supprimer une archive
    #[Route('/supprimer-archive/{id}', name: 'app_archive_delete', methods: ['GET'])]
    public function delete(Archive $archive, ArchiveRepository $archiveRepository): Response
    {
        // Vérifie si l'archive existe
        if ($archive)
        {
            // Récupère le nom du fichier de l'archive
            $nom = $archive->getFichier();

            // Supprime le fichier physique du système de fichiers
            unlink($this->getParameter('fichier_archives').'/'.$nom);

            // Supprime l'archive de la base de données
            $archiveRepository->remove($archive, true);

            // Redirige vers la liste des archives
            return $this->redirectToRoute('app_archive_index', [], Response::HTTP_SEE_OTHER);
        }
        else
        {
            // Redirige vers la liste des archives si l'archive n'existe pas
            return $this->redirectToRoute('app_archive_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
