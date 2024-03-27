<?php

namespace App\Repository;

use App\Entity\Year;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Year>
 *
 * @method Year|null find($id, $lockMode = null, $lockVersion = null)
 * @method Year|null findOneBy(array $criteria, array $orderBy = null)
 * @method Year[]    findAll()
 * @method Year[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Year::class);
    }

    //    /**
    //     * @return Year[] Returns an array of Year objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('y.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Year
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

  public function findLastYear(): ?Year
  {
    $q = $this->createQueryBuilder('y')
      ->andWhere('y.isActive = :is_active')
      ->setParameter('is_active', true)
      ->orderBy('y.id', 'DESC')
      ->setMaxResults(1);

    return $q->getQuery()->getOneOrNullResult();
  }

  /**
   * @param string $name
   * @return Year[]
   */
  public function findYearByName(string $name): array
  {
    $query = $this->createQueryBuilder('y');
    $query
      ->where($query->expr()->like('y.name', ':name'))
      ->setParameter('name', '%'.$name.'%')
      ->orderBy('y.name', 'ASC');

    return $query->getQuery()->getResult();
  }
}
