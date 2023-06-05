<?php

namespace App\Repository;

use App\Entity\PointFonctionnementRotor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointFonctionnementRotor>
 *
 * @method PointFonctionnementRotor|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointFonctionnementRotor|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointFonctionnementRotor[]    findAll()
 * @method PointFonctionnementRotor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointFonctionnementRotorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointFonctionnementRotor::class);
    }

    public function save(PointFonctionnementRotor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PointFonctionnementRotor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PointFonctionnementRotor[] Returns an array of PointFonctionnementRotor objects
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

//    public function findOneBySomeField($value): ?PointFonctionnementRotor
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
