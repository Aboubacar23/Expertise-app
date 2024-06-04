<?php

namespace App\Controller; // Déclare le namespace du contrôleur

use App\Entity\Parametre; // Importe l'entité Parametre
use App\Entity\Phototheque; // Importe l'entité Phototheque
use App\Form\PhotothequeType; // Importe le formulaire PhotothequeType
use App\Service\RedimensionneService; // Importe le service RedimensionneService
use App\Repository\PhotothequeRepository; // Importe le repository PhotothequeRepository
use Symfony\Component\HttpFoundation\Request; // Importe Request pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Importe Response pour gérer les réponses HTTP
use Symfony\Component\Routing\Annotation\Route; // Importe Route pour la définition des routes
use Symfony\Component\String\Slugger\SluggerInterface; // Importe SluggerInterface pour gérer les slugs
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importe AbstractController comme classe de base
use Symfony\Component\HttpFoundation\File\Exception\FileException; // Importe FileException pour gérer les exceptions de fichiers

#[Route('/phototheque')] // Déclare une route principale pour ce contrôleur
class PhotothequeController extends AbstractController
{
    // Constructeur pour injecter le service de redimensionnement d'images
    public function __construct(private RedimensionneService $redimensionneService)
    {

    }

    // Fonction pour ajouter une nouvelle photo à la photothèque
    #[Route('/new-phototheque/{id}', name: 'app_phototheque', methods: ['POST','GET'])] // Déclare la route pour ajouter une nouvelle photo
    public function index(Parametre $parametre, PhotothequeRepository $photothequeRepository, Request $request, SluggerInterface $slugger): Response
    {
        // Crée une nouvelle instance de Phototheque
        $phototheque = new Phototheque();
        // Crée le formulaire pour Phototheque
        $form = $this->createForm(PhotothequeType::class, $phototheque);
        // Gère la requête
        $form->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère l'image soumise via le formulaire
            $image = $form->get('libelle')->getData();
            if ($image)
            {
                // Récupère la taille de l'image
                $size = $image->getSize();
                // Vérifie si la taille de l'image est supérieure à 2 Mo
                if($size > 2*1024*1024)
                {
                    // Ajoute un message d'erreur et redirige si l'image est trop grande
                    $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                    return $this->redirectToRoute('app_phototheque', ['id' => $parametre->getId()]);
                }else{
                    // Génère un nom de fichier sécurisé pour l'image
                    $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safePhotoname = $slugger->slug($originalePhoto);
                    $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                    try {
                        // Déplace l'image vers le répertoire spécifié
                        $image->move(
                            $this->getParameter('image_phototheque'),
                            $newPhotoname
                        );
                    } catch (FileException $e){}

                    // Définit le chemin du fichier et redimensionne l'image (optionnel)
                    $directory= $this->getParameter('kernel.project_dir').'/public/phototheques'.'/'.$newPhotoname;
                    //$this->redimensionneService->resize($directory);
                    // Définit le libellé de la photothèque avec le nouveau nom de fichier
                    $phototheque->setLibelle($newPhotoname);
                }
            }

            // Associe la photothèque au paramètre et enregistre dans la base de données
            $phototheque->setParametre($parametre);
            $photothequeRepository->save($phototheque, true);

            // Redirige vers la route de la photothèque après l'ajout
            return $this->redirectToRoute('app_phototheque', [
                'id' => $parametre->getId()
            ]);
        }

        // Retourne la vue du formulaire de photothèque
        return $this->render('phototheque/index.html.twig', [
            'form' => $form->createView(),
            'parametre' => $parametre
        ]);
    }

    // Fonction pour supprimer une photo de la photothèque
    #[Route('/phototheque-supprimer/{id}', name: 'app_delete_plaque', methods: ['GET'])] // Déclare la route pour supprimer une photo
    public function deletePhototheque(Phototheque $phototheque, PhotothequeRepository $photothequeRepository): Response
    {
        // Récupère l'ID du paramètre associé à la photothèque
        $id = $phototheque->getParametre()->getId();
        if($phototheque)
        {
            // Supprime le fichier image du répertoire
            $nom = $phototheque->getLibelle();
            unlink($this->getParameter('image_phototheque').'/'.$nom);
            // Supprime l'entrée de la base de données
            $photothequeRepository->remove($phototheque, true);
            // Redirige après suppression
            return $this->redirectToRoute('app_phototheque', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            // Redirige si la photothèque n'existe pas
            return $this->redirectToRoute('app_phototheque', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    }
}
