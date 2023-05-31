<?php

namespace App\Repository;

use App\Entity\ControleGeometrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControleGeometrique>
 *
 * @method ControleGeometrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControleGeometrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControleGeometrique[]    findAll()
 * @method ControleGeometrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleGeometriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControleGeometrique::class);
    }

    public function save(ControleGeometrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ControleGeometrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ControleGeometrique[] Returns an array of ControleGeometrique objects
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

//    public function findOneBySomeField($value): ?ControleGeometrique
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
