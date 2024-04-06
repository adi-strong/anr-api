<?php

namespace App\Repository;

use App\Entity\PropertyAssignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyAssignment>
 *
 * @method PropertyAssignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyAssignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyAssignment[]    findAll()
 * @method PropertyAssignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyAssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyAssignment::class);
    }

    //    /**
    //     * @return PropertyAssignment[] Returns an array of PropertyAssignment objects
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

    //    public function findOneBySomeField($value): ?PropertyAssignment
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
