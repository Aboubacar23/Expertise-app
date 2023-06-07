<?php

namespace App\Repository;

use App\Entity\RemontageFinition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RemontageFinition>
 *
 * @method RemontageFinition|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemontageFinition|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemontageFinition[]    findAll()
 * @method RemontageFinition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemontageFinitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemontageFinition::class);
    }

    public function save(RemontageFinition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RemontageFinition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RemontageFinition[] Returns an array of RemontageFinition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RemontageFinition
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
