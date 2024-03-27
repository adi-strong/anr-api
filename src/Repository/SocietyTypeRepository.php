<?php

namespace App\Repository;

use App\Entity\SocietyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocietyType>
 *
 * @method SocietyType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocietyType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocietyType[]    findAll()
 * @method SocietyType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocietyTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocietyType::class);
    }

    //    /**
    //     * @return SocietyType[] Returns an array of SocietyType objects
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

    //    public function findOneBySomeField($value): ?SocietyType
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
