<?php

namespace App\Repository;

use App\Entity\AutrePointFonctionnementRotor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutrePointFonctionnementRotor>
 *
 * @method AutrePointFonctionnementRotor|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutrePointFonctionnementRotor|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutrePointFonctionnementRotor[]    findAll()
 * @method AutrePointFonctionnementRotor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutrePointFonctionnementRotorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutrePointFonctionnementRotor::class);
    }

    public function save(AutrePointFonctionnementRotor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AutrePointFonctionnementRotor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AutrePointFonctionnementRotor[] Returns an array of AutrePointFonctionnementRotor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AutrePointFonctionnementRotor
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
