<?php

namespace App\Repository;

use App\Entity\AppareilMesureMecanique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppareilMesureMecanique>
 *
 * @method AppareilMesureMecanique|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppareilMesureMecanique|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppareilMesureMecanique[]    findAll()
 * @method AppareilMesureMecanique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppareilMesureMecaniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppareilMesureMecanique::class);
    }

    public function save(AppareilMesureMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppareilMesureMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppareilMesureMecanique[] Returns an array of AppareilMesureMecanique objects
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

//    public function findOneBySomeField($value): ?AppareilMesureMecanique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
