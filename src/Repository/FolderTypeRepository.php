<?php

namespace App\Repository;

use App\Entity\FolderType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FolderType>
 *
 * @method FolderType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FolderType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FolderType[]    findAll()
 * @method FolderType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FolderTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FolderType::class);
    }

    //    /**
    //     * @return FolderType[] Returns an array of FolderType objects
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

    //    public function findOneBySomeField($value): ?FolderType
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
