<?php

namespace App\Repository;

use App\Entity\PhotoExpertiseMecanique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhotoExpertiseMecanique>
 *
 * @method PhotoExpertiseMecanique|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoExpertiseMecanique|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoExpertiseMecanique[]    findAll()
 * @method PhotoExpertiseMecanique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoExpertiseMecaniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoExpertiseMecanique::class);
    }

    public function save(PhotoExpertiseMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PhotoExpertiseMecanique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PhotoExpertiseMecanique[] Returns an array of PhotoExpertiseMecanique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PhotoExpertiseMecanique
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
