<?php

namespace App\ApplyToCollections;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Department;
use App\Entity\ExpenseType;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class ApplyDQLToCollections implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
  public function __construct(private readonly Security $security) { }

  private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
  {
    $user = $this->security->getUser();
    $alias = $queryBuilder->getRootAliases()[0];

    if ($resourceClass === Department::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === ExpenseType::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }
  }

  public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
  {
    $this->addWhere($queryBuilder, $resourceClass);
  }

  public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
  {
    $this->addWhere($queryBuilder, $resourceClass);
  }
}
