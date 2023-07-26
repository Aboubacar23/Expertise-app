<?php

namespace App\Repository;

use App\Entity\PointFonctionnementVide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointFonctionnementVide>
 *
 * @method PointFonctionnementVide|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointFonctionnementVide|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointFonctionnementVide[]    findAll()
 * @method PointFonctionnementVide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointFonctionnementVideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointFonctionnementVide::class);
    }

    public function save(PointFonctionnementVide $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PointFonctionnementVide $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PointFonctionnementVide[] Returns an array of PointFonctionnementVide objects
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

//    public function findOneBySomeField($value): ?PointFonctionnementVide
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
