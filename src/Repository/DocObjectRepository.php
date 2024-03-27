<?php

namespace App\Repository;

use App\Entity\DocObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocObject>
 *
 * @method DocObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocObject[]    findAll()
 * @method DocObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocObject::class);
    }

    //    /**
    //     * @return DocObject[] Returns an array of DocObject objects
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

    //    public function findOneBySomeField($value): ?DocObject
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
