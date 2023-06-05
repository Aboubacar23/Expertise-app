<?php

namespace App\Repository;

use App\Entity\ReleveDimmensionnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReleveDimmensionnel>
 *
 * @method ReleveDimmensionnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReleveDimmensionnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReleveDimmensionnel[]    findAll()
 * @method ReleveDimmensionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReleveDimmensionnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReleveDimmensionnel::class);
    }

    public function save(ReleveDimmensionnel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReleveDimmensionnel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReleveDimmensionnel[] Returns an array of ReleveDimmensionnel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReleveDimmensionnel
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
