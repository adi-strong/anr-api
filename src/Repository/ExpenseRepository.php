<?php

namespace App\Repository;

use App\Entity\Expense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expense>
 *
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expense::class);
    }

//    /**
//     * @return Expense[] Returns an array of Expense objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Expense
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

  /**
   * @param string $name
   * @return Expense[]
   */
  public function findExpenseByName(string $name): array
  {
    $query = $this->createQueryBuilder('p');
    $query
      ->where($query->expr()->like('p.object', ':name'))
      ->setParameter('name', '%'.$name.'%')
      ->orderBy('p.object', 'ASC');

    return $query->getQuery()->getResult();
  }

  /**
   * @param string $startAt
   * @param string $endAt
   * @return Expense[]
   */
  public function findExpensesBetweenDates(string $startAt, string $endAt): array
  {
    return $this->createQueryBuilder('e')
      ->andWhere('SUBSTRING(e.releasedAt, 1, 10) BETWEEN :startAt AND :endAt')
      ->setParameter('startAt', $startAt)
      ->setParameter('endAt', $endAt)
      ->orderBy('e.releasedAt', 'DESC')
      ->getQuery()
      ->getResult();
  }

  /**
   * @param string $date
   * @return Expense[]
   */
  public function findRportByDate(string $date): array
  {
    return $this->createQueryBuilder('e')
      ->andWhere('SUBSTRING(e.releasedAt, 1, 10) = :date')
      ->setParameter('date', $date)
      ->orderBy('e.releasedAt', 'DESC')
      ->getQuery()
      ->getResult();
  }
}
