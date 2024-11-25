<?php

namespace App\Repository;

use App\Entity\PressionPorteBalais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PressionPorteBalais>
 *
 * @method PressionPorteBalais|null find($id, $lockMode = null, $lockVersion = null)
 * @method PressionPorteBalais|null findOneBy(array $criteria, array $orderBy = null)
 * @method PressionPorteBalais[]    findAll()
 * @method PressionPorteBalais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressionPorteBalaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PressionPorteBalais::class);
    }

//    /**
//     * @return PressionPorteBalais[] Returns an array of PressionPorteBalais objects
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

//    public function findOneBySomeField($value): ?PressionPorteBalais
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
