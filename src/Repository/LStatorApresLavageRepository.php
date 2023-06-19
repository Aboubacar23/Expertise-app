<?php

namespace App\Repository;

use App\Entity\LStatorApresLavage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LStatorApresLavage>
 *
 * @method LStatorApresLavage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LStatorApresLavage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LStatorApresLavage[]    findAll()
 * @method LStatorApresLavage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LStatorApresLavageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LStatorApresLavage::class);
    }

    public function save(LStatorApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LStatorApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LStatorApresLavage[] Returns an array of LStatorApresLavage objects
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

//    public function findOneBySomeField($value): ?LStatorApresLavage
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
