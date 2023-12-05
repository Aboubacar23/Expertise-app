<?php

namespace App\Repository;

use App\Entity\LMesureVibratoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LMesureVibratoire>
 *
 * @method LMesureVibratoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method LMesureVibratoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method LMesureVibratoire[]    findAll()
 * @method LMesureVibratoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LMesureVibratoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LMesureVibratoire::class);
    }

    public function save(LMesureVibratoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LMesureVibratoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LMesureVibratoire[] Returns an array of LMesureVibratoire objects
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

//    public function findOneBySomeField($value): ?LMesureVibratoire
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
