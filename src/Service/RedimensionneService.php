<?php

namespace App\Service;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class RedimensionneService{

    private const MAX_WIDTH = 300;
    private const MAX_HEIGHT = 300;

    private $imagine;
    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(String $filename)
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;

        if($width / $height)
        {
            $width = $height * $ratio;
        }else{
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($filename);
        $photo->resize(new Box($width, $height))->save($filename);
    }
}

?>