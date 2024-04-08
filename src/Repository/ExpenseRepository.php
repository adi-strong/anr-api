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
  public function findReportByDate(string $date): array
  {
    return $this->createQueryBuilder('e')
      ->andWhere('SUBSTRING(e.releasedAt, 1, 10) = :date')
      ->setParameter('date', $date)
      ->orderBy('e.releasedAt', 'DESC')
      ->getQuery()
      ->getResult();
  }

  public function findThisYearExpensesSum(): mixed
  {
    $year = date('Y');

    $qb = $this->createQueryBuilder('e')->select('SUM(e.total)');
    $qb->where($qb->expr()->eq(
      'SUBSTRING(e.releasedAt, 1, 4)', ':year'
    ))
    ->setParameter('year', $year);

    return $qb->getQuery()->getSingleScalarResult();
  }

  /**
   * @return Expense[]
   */
  public function findThisYearExpenses(): array
  {
    $year = date('Y');

    $qb = $this->createQueryBuilder('e');
    $qb->where($qb->expr()->eq(
      'SUBSTRING(e.releasedAt, 1, 4)', ':year'
    ))
    ->setParameter('year', $year);

    return $qb->getQuery()->getResult();
  }

  /**
   * @param mixed $year
   * @param mixed $month
   * @return Expense[]
   */
  public function findStatsByDate(mixed $year, mixed $month): array
  {
    $qb = $this->createQueryBuilder('r');
    $qb->where($qb->expr()->andX(
      $qb->expr()->eq('SUBSTRING(r.releasedAt, 1, 4)', ':year'),
      $qb->expr()->eq('SUBSTRING(r.releasedAt, 6, 2)', ':month')
    ))
    ->setParameter('year', $year)
    ->setParameter('month', $month);

    return $qb->getQuery()->getResult();
  }

  /**
   * @param string $month
   * @return Expense[]
   */
  public function findExpenseByMonth(string $month): array
  {
    $year = date('Y');
    $qb = $this->createQueryBuilder('e');
    $qb->where($qb->expr()->andX(
      $qb->expr()->eq('SUBSTRING(e.releasedAt, 1, 4)', ':year'),
      $qb->expr()->eq('SUBSTRING(e.releasedAt, 6, 2)', ':month'),
    ))
    ->setParameter('year', $year)
    ->setParameter('month', $month);

    return $qb->getQuery()->getResult();
  }
}
