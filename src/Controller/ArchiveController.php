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
 *******Template **************************
 les views de d'archives (historiques)
    /archive
 * ********************** Déscription *****************************
 * l'accès à cette page est obligatoire 
 * Dans ce contrôleur il y a 
 *******Template **************************deux fonction
 *  1- la fonction "index" : pour afficher la liste des dossiers archivers (historiques)
 *  2- la fonction "delete" : pour supprimer un archive 
 * 
 */
namespace App\Controller;

use App\Entity\Affaire;
use App\Entity\Archive;
use App\Repository\ArchiveRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/archive')]
class ArchiveController extends AbstractController
{
    #[Route('/index-archive', name: 'app_archive_index')]
    public function index(ArchiveRepository $archiveRepository): Response
    {
        $archives = $archiveRepository->findBy([],['id' => 'desc']);
        return $this->render('archive/index.html.twig', [
            'archives' => $archives,
        ]);
    }

    //la fonction qui supprime une archive
    #[Route('/supprimer-archive/{id}', name: 'app_archive_delete', methods: ['GET'])]
    public function delete(Archive $archive,ArchiveRepository $archiveRepository): Response
    {
        if($archive)
        {
            $nom = $archive->getFichier();
            unlink($this->getParameter('fichier_archives').'/'.$nom);
            $archiveRepository->remove($archive, true);
            return $this->redirectToRoute('app_archive_index', [], Response::HTTP_SEE_OTHER);

        }
        else
        {
            return $this->redirectToRoute('app_archive_index', [], Response::HTTP_SEE_OTHER);
        } 
    }
}
