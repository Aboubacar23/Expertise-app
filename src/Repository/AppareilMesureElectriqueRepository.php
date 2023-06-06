<?php

namespace App\Repository;

use App\Entity\AppareilMesureElectrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppareilMesureElectrique>
 *
 * @method AppareilMesureElectrique|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppareilMesureElectrique|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppareilMesureElectrique[]    findAll()
 * @method AppareilMesureElectrique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppareilMesureElectriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppareilMesureElectrique::class);
    }

    public function save(AppareilMesureElectrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppareilMesureElectrique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppareilMesureElectrique[] Returns an array of AppareilMesureElectrique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AppareilMesureElectrique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
