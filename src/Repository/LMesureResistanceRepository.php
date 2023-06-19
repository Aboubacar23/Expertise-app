<?php

namespace App\Repository;

use App\Entity\LMesureResistance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LMesureResistance>
 *
 * @method LMesureResistance|null find($id, $lockMode = null, $lockVersion = null)
 * @method LMesureResistance|null findOneBy(array $criteria, array $orderBy = null)
 * @method LMesureResistance[]    findAll()
 * @method LMesureResistance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LMesureResistanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LMesureResistance::class);
    }

    public function save(LMesureResistance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LMesureResistance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LMesureResistance[] Returns an array of LMesureResistance objects
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

//    public function findOneBySomeField($value): ?LMesureResistance
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
