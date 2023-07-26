<?php

namespace App\Repository;

use App\Entity\MesureVibratoireEssais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MesureVibratoireEssais>
 *
 * @method MesureVibratoireEssais|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesureVibratoireEssais|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesureVibratoireEssais[]    findAll()
 * @method MesureVibratoireEssais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesureVibratoireEssaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesureVibratoireEssais::class);
    }

    public function save(MesureVibratoireEssais $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MesureVibratoireEssais $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MesureVibratoireEssais[] Returns an array of MesureVibratoireEssais objects
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

//    public function findOneBySomeField($value): ?MesureVibratoireEssais
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
