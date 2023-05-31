<?php

namespace App\Repository;

use App\Entity\ControleMontageConssinet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControleMontageConssinet>
 *
 * @method ControleMontageConssinet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControleMontageConssinet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControleMontageConssinet[]    findAll()
 * @method ControleMontageConssinet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleMontageConssinetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControleMontageConssinet::class);
    }

    public function save(ControleMontageConssinet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ControleMontageConssinet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ControleMontageConssinet[] Returns an array of ControleMontageConssinet objects
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

//    public function findOneBySomeField($value): ?ControleMontageConssinet
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
