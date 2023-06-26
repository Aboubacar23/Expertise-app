<?php

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
    public function deletePhoto(Archive $archive,ArchiveRepository $archiveRepository): Response
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
