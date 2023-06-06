<?php

namespace App\Repository;

use App\Entity\ConstatElectriqueApresLavage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConstatElectriqueApresLavage>
 *
 * @method ConstatElectriqueApresLavage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConstatElectriqueApresLavage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConstatElectriqueApresLavage[]    findAll()
 * @method ConstatElectriqueApresLavage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstatElectriqueApresLavageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConstatElectriqueApresLavage::class);
    }

    public function save(ConstatElectriqueApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConstatElectriqueApresLavage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConstatElectriqueApresLavage[] Returns an array of ConstatElectriqueApresLavage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConstatElectriqueApresLavage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
