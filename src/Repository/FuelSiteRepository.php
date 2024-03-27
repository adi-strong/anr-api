<?php

namespace App\Repository;

use App\Entity\FuelSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FuelSite>
 *
 * @method FuelSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuelSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuelSite[]    findAll()
 * @method FuelSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FuelSite::class);
    }

//    /**
//     * @return FuelSite[] Returns an array of FuelSite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FuelSite
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
