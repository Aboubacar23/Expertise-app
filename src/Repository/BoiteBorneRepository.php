<?php

namespace App\Repository;

use App\Entity\BoiteBorne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoiteBorne>
 *
 * @method BoiteBorne|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoiteBorne|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoiteBorne[]    findAll()
 * @method BoiteBorne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoiteBorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoiteBorne::class);
    }

//    /**
//     * @return BoiteBorne[] Returns an array of BoiteBorne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BoiteBorne
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
