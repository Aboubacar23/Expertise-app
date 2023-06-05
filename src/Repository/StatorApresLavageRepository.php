<?php

namespace App\Repository;

use App\Entity\StatorApresLavage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatorApresLavage>
 *
 * @method StatorApresLavage|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatorApresLavage|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatorApresLavage[]    findAll()
 * @method StatorApresLavage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatorApresLavageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatorApresLavage::class);
    }

    public function save(StatorApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatorApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StatorApresLavage[] Returns an array of StatorApresLavage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatorApresLavage
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
