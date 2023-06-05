<?php

namespace App\Repository;

use App\Entity\SondeBobinage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SondeBobinage>
 *
 * @method SondeBobinage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SondeBobinage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SondeBobinage[]    findAll()
 * @method SondeBobinage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SondeBobinageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SondeBobinage::class);
    }

    public function save(SondeBobinage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SondeBobinage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SondeBobinage[] Returns an array of SondeBobinage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SondeBobinage
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
