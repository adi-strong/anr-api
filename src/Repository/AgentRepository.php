<?php

namespace App\Repository;

use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Agent>
 *
 * @method Agent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agent[]    findAll()
 * @method Agent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }

    //    /**
    //     * @return Agent[] Returns an array of Agent objects
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

    //    public function findOneBySomeField($value): ?Agent
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

  /**
   * @param mixed $keyword
   * @return Agent[]
   */
  public function findAgents(mixed $keyword): array
  {
    $qb = $this->createQueryBuilder('a');
    $qb->where(
      $qb->expr()->orX(
        $qb->expr()->like('a.name', ':keyword'),
        $qb->expr()->like('a.lastName', ':keyword'),
        $qb->expr()->like('a.firstName', ':keyword'),
      )
    )->setParameter('keyword', '%'.$keyword.'%');

    return $qb->getQuery()->getResult();
  }

  /**
   * @param string $state
   * @return Agent[]
   */
  public function findAgentsByState(string $state): array
  {
    return $this->createQueryBuilder('a')
      ->where('a.state = :state')
      ->setParameter('state', $state)
      ->getQuery()
      ->getResult();
  }

  public function countAgents(): mixed
  {
    $qb = $this->createQueryBuilder('a')->select('COUNT(a)');

    $qb->where($qb->expr()->notIn('a.state', ['dead', 'retired']));
    $query = $qb->getQuery();

    return $query->getSingleScalarResult();
  }
}
