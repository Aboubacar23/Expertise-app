<?php

namespace App\Repository;

use App\Entity\MesureResistanceEssai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MesureResistanceEssai>
 *
 * @method MesureResistanceEssai|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesureResistanceEssai|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesureResistanceEssai[]    findAll()
 * @method MesureResistanceEssai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesureResistanceEssaiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesureResistanceEssai::class);
    }

    public function save(MesureResistanceEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MesureResistanceEssai $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MesureResistanceEssai[] Returns an array of MesureResistanceEssai objects
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

//    public function findOneBySomeField($value): ?MesureResistanceEssai
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
