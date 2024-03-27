<?php

namespace App\Repository;

use App\Entity\FuelStockSupply;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FuelStockSupply>
 *
 * @method FuelStockSupply|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuelStockSupply|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuelStockSupply[]    findAll()
 * @method FuelStockSupply[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelStockSupplyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FuelStockSupply::class);
    }

    //    /**
    //     * @return FuelStockSupply[] Returns an array of FuelStockSupply objects
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

    //    public function findOneBySomeField($value): ?FuelStockSupply
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
