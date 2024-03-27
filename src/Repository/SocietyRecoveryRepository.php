<?php

namespace App\Repository;

use App\Entity\SocietyRecovery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocietyRecovery>
 *
 * @method SocietyRecovery|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocietyRecovery|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocietyRecovery[]    findAll()
 * @method SocietyRecovery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocietyRecoveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocietyRecovery::class);
    }

//    /**
//     * @return SocietyRecovery[] Returns an array of SocietyRecovery objects
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

//    public function findOneBySomeField($value): ?SocietyRecovery
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
