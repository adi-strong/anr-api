<?php

namespace App\Repository;

use App\Entity\VehicleAssignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleAssignment>
 *
 * @method VehicleAssignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleAssignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleAssignment[]    findAll()
 * @method VehicleAssignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleAssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleAssignment::class);
    }

//    /**
//     * @return VehicleAssignment[] Returns an array of VehicleAssignment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VehicleAssignment
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
