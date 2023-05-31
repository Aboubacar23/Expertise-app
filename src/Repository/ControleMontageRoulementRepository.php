<?php

namespace App\Repository;

use App\Entity\ControleMontageRoulement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControleMontageRoulement>
 *
 * @method ControleMontageRoulement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControleMontageRoulement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControleMontageRoulement[]    findAll()
 * @method ControleMontageRoulement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleMontageRoulementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControleMontageRoulement::class);
    }

    public function save(ControleMontageRoulement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ControleMontageRoulement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ControleMontageRoulement[] Returns an array of ControleMontageRoulement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ControleMontageRoulement
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
