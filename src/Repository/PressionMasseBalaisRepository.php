<?php

namespace App\Repository;

use App\Entity\PressionMasseBalais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PressionMasseBalais>
 *
 * @method PressionMasseBalais|null find($id, $lockMode = null, $lockVersion = null)
 * @method PressionMasseBalais|null findOneBy(array $criteria, array $orderBy = null)
 * @method PressionMasseBalais[]    findAll()
 * @method PressionMasseBalais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressionMasseBalaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PressionMasseBalais::class);
    }

//    /**
//     * @return PressionMasseBalais[] Returns an array of PressionMasseBalais objects
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

//    public function findOneBySomeField($value): ?PressionMasseBalais
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
