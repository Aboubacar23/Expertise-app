<?php

namespace App\Twig;
use Twig\TwigFunction;
use App\Entity\Parametre;
use Twig\Extension\AbstractExtension;
use App\Repository\ParametreRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParametreExtension extends AbstractExtension
{
    private $em;

    public function __construct(ParametreRepository $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombre', [$this, 'nombres'])
        ];
    }

    public function nombres()
    {
         $lists = $this->em->findBy([],['id'=> 'desc']);
         $nombre  = 0;
         foreach ($lists as $item)
         {
             if($item->isStatut() == 0 && $item->isExpertiseElectiqueAvantLavage() == 1 && $item->isExpertiseElectiqueApresLavage() == 1 && $item->isRemontage() == 1 && $item->isRemontage() == 1)
             {
                $nombre = $nombre + 1;
             }
         }
        return $nombre;
    }
}