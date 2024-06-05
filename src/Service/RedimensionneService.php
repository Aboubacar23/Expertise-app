<?php

namespace App\Service;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class RedimensionneService
{
    // Constantes pour la largeur et la hauteur maximales
    private const MAX_WIDTH = 3040;
    private const MAX_HEIGHT = 2020;

    // Méthode pour redimensionner une image
    public function resize(String $filename)
    {
        // Création d'une instance d'Imagine
        $imagine = new Imagine();

        // Obtient la largeur et la hauteur de l'image originale
        list($iwidth, $iheight) = getimagesize($filename);

        // Calcul du ratio de l'image
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;

        // Ajuste la largeur et la hauteur pour conserver le ratio
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        // Ouvre l'image, la redimensionne et la sauvegarde
        $photo = $imagine->open($filename);
        $photo->resize(new Box($width, $height))->save($filename);
    }
}
?>
