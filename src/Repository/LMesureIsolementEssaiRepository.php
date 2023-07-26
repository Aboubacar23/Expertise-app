<?php

namespace App\Repository;

use App\Entity\LMesureIsolementEssai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LMesureIsolementEssai>
 *
 * @method LMesureIsolementEssai|null find($id, $lockMode = null, $lockVersion = null)
 * @method LMesureIsolementEssai|null findOneBy(array $criteria, array $orderBy = null)
 * @method LMesureIsolementEssai[]    findAll()
 * @method LMesureIsolementEssai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LMesureIsolementEssaiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LMesureIsolementEssai::class);
    }

    public function save(LMesureIsolementEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LMesureIsolementEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LMesureIsolementEssai[] Returns an array of LMesureIsolementEssai objects
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

//    public function findOneBySomeField($value): ?LMesureIsolementEssai
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
