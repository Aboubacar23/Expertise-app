<?php

namespace App\Repository;

use App\Entity\AppareilMesureEssais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppareilMesureEssais>
 *
 * @method AppareilMesureEssais|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppareilMesureEssais|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppareilMesureEssais[]    findAll()
 * @method AppareilMesureEssais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppareilMesureEssaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppareilMesureEssais::class);
    }

    public function save(AppareilMesureEssais $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppareilMesureEssais $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppareilMesureEssais[] Returns an array of AppareilMesureEssais objects
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

//    public function findOneBySomeField($value): ?AppareilMesureEssais
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
