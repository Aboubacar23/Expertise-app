<?php

namespace App\Repository;

use App\Entity\RemontageEquilibrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RemontageEquilibrage>
 *
 * @method RemontageEquilibrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemontageEquilibrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemontageEquilibrage[]    findAll()
 * @method RemontageEquilibrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemontageEquilibrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemontageEquilibrage::class);
    }

    public function save(RemontageEquilibrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RemontageEquilibrage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RemontageEquilibrage[] Returns an array of RemontageEquilibrage objects
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

//    public function findOneBySomeField($value): ?RemontageEquilibrage
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
