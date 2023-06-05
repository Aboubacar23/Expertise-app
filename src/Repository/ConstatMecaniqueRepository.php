<?php

namespace App\Repository;

use App\Entity\ConstatMecanique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConstatMecanique>
 *
 * @method ConstatMecanique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConstatMecanique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConstatMecanique[]    findAll()
 * @method ConstatMecanique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstatMecaniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConstatMecanique::class);
    }

    public function save(ConstatMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConstatMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConstatMecanique[] Returns an array of ConstatMecanique objects
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

//    public function findOneBySomeField($value): ?ConstatMecanique
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
