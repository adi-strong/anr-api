<?php

namespace App\Repository;

use App\Entity\AgentState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgentState>
 *
 * @method AgentState|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentState|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentState[]    findAll()
 * @method AgentState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentState::class);
    }

    //    /**
    //     * @return AgentState[] Returns an array of AgentState objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AgentState
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

  public function findLastState(): ?AgentState
  {
    return $this->createQueryBuilder('a')
      ->where('a.isActive = :is_active')
      ->setParameter('is_active', true)
      ->orderBy('a.id', 'DESC')
      ->setMaxResults(1)
      ->getQuery()
      ->getOneOrNullResult();
  }
}
