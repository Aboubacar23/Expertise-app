<?php

namespace App\Repository;

use App\Entity\ControleVisuelElectrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControleVisuelElectrique>
 *
 * @method ControleVisuelElectrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControleVisuelElectrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControleVisuelElectrique[]    findAll()
 * @method ControleVisuelElectrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleVisuelElectriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControleVisuelElectrique::class);
    }

    public function save(ControleVisuelElectrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ControleVisuelElectrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ControleVisuelElectrique[] Returns an array of ControleVisuelElectrique objects
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

//    public function findOneBySomeField($value): ?ControleVisuelElectrique
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
