<?php

namespace App\Repository;

use App\Entity\Medical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medical>
 *
 * @method Medical|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medical|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medical[]    findAll()
 * @method Medical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medical::class);
    }

//    /**
//     * @return MedicalActions[] Returns an array of MedicalActions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MedicalActions
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
