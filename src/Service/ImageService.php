<?php
// src/Service/ImageUploader.php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageService
{


    public function __construct(private SluggerInterface $slugger){}

    public function upload(UploadedFile $file, string $directory)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($directory, $fileName);
        } catch (FileException $e) {
            // handle exception if something happens during file upload
        }
        return $fileName;
    }
/*
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
*/
}


?>