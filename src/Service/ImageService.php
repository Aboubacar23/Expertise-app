<?php
// src/Service/ImageUploader.php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageService
{
    // Constructeur avec injection de dépendance pour le SluggerInterface
    public function __construct(private SluggerInterface $slugger){}

    // Méthode pour uploader un fichier
    public function upload(UploadedFile $file, string $directory)
    {
        // Récupère le nom original du fichier sans l'extension
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Génère un nom de fichier sécurisé
        $safeFilename = $this->slugger->slug($originalFilename);

        // Génère un nom de fichier unique avec une extension
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            // Déplace le fichier vers le répertoire de destination
            $file->move($directory, $fileName);
        } catch (FileException $e) {
            // Gère les exceptions en cas de problème lors du téléchargement
        }

        // Retourne le nom du fichier
        return $fileName;
    }
}
?>
