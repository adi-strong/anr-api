<?php

namespace App\Repository;

use App\Entity\DepartmentService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepartmentService>
 *
 * @method DepartmentService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartmentService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartmentService[]    findAll()
 * @method DepartmentService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartmentService::class);
    }

    //    /**
    //     * @return DepartmentService[] Returns an array of DepartmentService objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DepartmentService
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
