<?php

namespace App\Repository;

use App\Entity\FuelSupply;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FuelSupply>
 *
 * @method FuelSupply|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuelSupply|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuelSupply[]    findAll()
 * @method FuelSupply[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelSupplyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FuelSupply::class);
    }

    //    /**
    //     * @return FuelSupply[] Returns an array of FuelSupply objects
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

    //    public function findOneBySomeField($value): ?FuelSupply
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
