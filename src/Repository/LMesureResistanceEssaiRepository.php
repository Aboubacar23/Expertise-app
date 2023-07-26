<?php

namespace App\Repository;

use App\Entity\LMesureResistanceEssai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LMesureResistanceEssai>
 *
 * @method LMesureResistanceEssai|null find($id, $lockMode = null, $lockVersion = null)
 * @method LMesureResistanceEssai|null findOneBy(array $criteria, array $orderBy = null)
 * @method LMesureResistanceEssai[]    findAll()
 * @method LMesureResistanceEssai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LMesureResistanceEssaiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LMesureResistanceEssai::class);
    }

    public function save(LMesureResistanceEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LMesureResistanceEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LMesureResistanceEssai[] Returns an array of LMesureResistanceEssai objects
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

//    public function findOneBySomeField($value): ?LMesureResistanceEssai
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
