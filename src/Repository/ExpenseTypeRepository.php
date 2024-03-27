<?php

namespace App\Repository;

use App\Entity\ExpenseType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpenseType>
 *
 * @method ExpenseType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseType[]    findAll()
 * @method ExpenseType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseType::class);
    }

    //    /**
    //     * @return ExpenseType[] Returns an array of ExpenseType objects
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

    //    public function findOneBySomeField($value): ?ExpenseType
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
   * @return ExpenseType[]
   */
  public function findProvinceByName(string $name): array
  {
    $query = $this->createQueryBuilder('p');
    $query
      ->where($query->expr()->like('p.name', ':name'))
      ->andWhere('p.isDeleted = :isDeleted')
      ->setParameter('isDeleted', false)
      ->setParameter('name', '%'.$name.'%')
      ->orderBy('p.name', 'ASC');

    return $query->getQuery()->getResult();
  }
}
