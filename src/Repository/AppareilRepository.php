<?php

namespace App\Repository;

use App\Entity\Appareil;
use App\Entity\Chercher;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Appareil>
 *
 * @method Appareil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appareil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appareil[]    findAll()
 * @method Appareil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppareilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appareil::class);
    }

    public function save(Appareil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appareil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Appareil[] Returns an array of Appareil objects
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

//    public function findOneBySomeField($value): ?Appareil
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

     /**
     * Recherche les annonces en fonction du formulaire
     * @return void 
    */
    public function findChercher(Chercher $recherche)
    {
        $query = $this->createQueryBuilder('a');

            if($recherche->getEtat()){
                $query = $query->andWhere('a.etat = :valEtat')
                                ->setParameter('valEtat', $recherche->getEtat());
            }

            if($recherche->getPeriodicite()){
                $query = $query->andWhere('a.periodicite = :valPeriodicite')
                                ->setParameter('valPeriodicite', $recherche->getPeriodicite());
            }

            if($recherche->getDateMin()){
                $query = $query->andWhere('a.date_validite >= :minperiode')
                                ->setParameter('minperiode', $recherche->getDateMin());
            }

            if($recherche->getDateMax()){
                $query = $query->andWhere('a.date_validite <= :maxperiode')
                                ->setParameter('maxperiode', $recherche->getDateMax());
            }
            


        return $query->orderBy('a.id', 'DESC')->getQuery()->getResult();
    }
}
