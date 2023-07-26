<?php

namespace App\Repository;

use App\Entity\MesureIsolementEssai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MesureIsolementEssai>
 *
 * @method MesureIsolementEssai|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesureIsolementEssai|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesureIsolementEssai[]    findAll()
 * @method MesureIsolementEssai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesureIsolementEssaiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesureIsolementEssai::class);
    }

    public function save(MesureIsolementEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MesureIsolementEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MesureIsolementEssai[] Returns an array of MesureIsolementEssai objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MesureIsolementEssai
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
