<?php

namespace App\Service;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class RedimensionneService{

    private const MAX_WIDTH = 3040;
    private const MAX_HEIGHT = 2020;

    public function resize(String $filename)
    {
        $imagine = new Imagine();

        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;

        if($width / $height > $ratio)
        {
            $width = $height * $ratio;
        }else{
            $height = $width / $ratio;
        }

        $photo = $imagine->open($filename);
        $photo->resize(new Box($width, $height))->save($filename);
    }
}

?>