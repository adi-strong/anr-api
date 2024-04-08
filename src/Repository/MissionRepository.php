<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    //    /**
    //     * @return Mission[] Returns an array of Mission objects
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

    //    public function findOneBySomeField($value): ?Mission
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

  /**
   * @return Mission[]
   */
  public function findMissions(): array
  {
    return $this->createQueryBuilder('m')
      ->join('m.agent', 'a')
      ->getQuery()
      ->getResult();
  }

  /**
   * @return Mission[]
   */
  public function findThisYearMissions(): array
  {
    $year = date('Y');

    $qb = $this->createQueryBuilder('m');
    $qb->where($qb->expr()->eq(
      'SUBSTRING(m.createdAt, 1, 4)', ':year'
    ))
    ->setParameter('year', $year);

    return $qb->getQuery()->getResult();
  }

  public function findStatsByDate(mixed $year, mixed $month): mixed
  {
    $qb = $this->createQueryBuilder('r')->select('COUNT(r)');
    $qb->where($qb->expr()->andX(
      $qb->expr()->eq('SUBSTRING(r.createdAt, 1, 4)', ':year'),
      $qb->expr()->eq('SUBSTRING(r.createdAt, 6, 2)', ':month')
    ))
      ->setParameter('year', $year)
      ->setParameter('month', $month);

    return $qb->getQuery()->getSingleScalarResult() ?? 0;
  }
}
