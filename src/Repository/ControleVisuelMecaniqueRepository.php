<?php

namespace App\Repository;

use App\Entity\ControleVisuelMecanique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControleVisuelMecanique>
 *
 * @method ControleVisuelMecanique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControleVisuelMecanique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControleVisuelMecanique[]    findAll()
 * @method ControleVisuelMecanique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleVisuelMecaniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControleVisuelMecanique::class);
    }

    public function save(ControleVisuelMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ControleVisuelMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ControleVisuelMecanique[] Returns an array of ControleVisuelMecanique objects
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

//    public function findOneBySomeField($value): ?ControleVisuelMecanique
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
