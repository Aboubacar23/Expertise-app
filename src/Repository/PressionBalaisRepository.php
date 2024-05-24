<?php

namespace App\Repository;

use App\Entity\PressionBalais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PressionBalais>
 *
 * @method PressionBalais|null find($id, $lockMode = null, $lockVersion = null)
 * @method PressionBalais|null findOneBy(array $criteria, array $orderBy = null)
 * @method PressionBalais[]    findAll()
 * @method PressionBalais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressionBalaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PressionBalais::class);
    }

//    /**
//     * @return PressionBalais[] Returns an array of PressionBalais objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PressionBalais
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
