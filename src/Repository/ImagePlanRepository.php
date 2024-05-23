<?php

namespace App\Repository;

use App\Entity\ImagePlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagePlan>
 *
 * @method ImagePlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagePlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagePlan[]    findAll()
 * @method ImagePlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagePlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagePlan::class);
    }

//    /**
//     * @return ImagePlan[] Returns an array of ImagePlan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImagePlan
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
