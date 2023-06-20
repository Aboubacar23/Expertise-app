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

    public function getListes()
    {
        $listes = [];
        $lists = $this->em->findBy([],['id'=> 'desc']);
        foreach ($lists as $item)
        {
            if($item->isStatut() == 0 && $item->isExpertiseElectiqueAvantLavage() == 1 && $item->isExpertiseElectiqueApresLavage() == 1 && $item->isExpertiseMecanique())
            {
                array_push($listes, $item);
            }
        }
        return $listes;
    }
}