<?php

namespace App\Repository;

use App\Entity\LSondeBobinage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LSondeBobinage>
 *
 * @method LSondeBobinage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LSondeBobinage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LSondeBobinage[]    findAll()
 * @method LSondeBobinage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LSondeBobinageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LSondeBobinage::class);
    }

    public function save(LSondeBobinage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LSondeBobinage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LSondeBobinage[] Returns an array of LSondeBobinage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LSondeBobinage
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
