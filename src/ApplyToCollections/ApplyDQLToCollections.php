<?php

namespace App\ApplyToCollections;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Agent;
use App\Entity\Department;
use App\Entity\DepartmentService;
use App\Entity\ExpenseType;
use App\Entity\FolderType;
use App\Entity\Fuel;
use App\Entity\FuelSite;
use App\Entity\Grade;
use App\Entity\Job;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\Province;
use App\Entity\Society;
use App\Entity\SocietyType;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehicleType;
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

    if ($resourceClass === Agent::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === DepartmentService::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === FolderType::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Fuel::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === FuelSite::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Grade::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Job::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Property::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === PropertyType::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Province::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Society::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === SocietyType::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === User::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === Vehicle::class && $user instanceof User) {
      $queryBuilder
        ->andWhere("$alias.isDeleted = :isDeleted")
        ->setParameter('isDeleted', false);
    }

    if ($resourceClass === VehicleType::class && $user instanceof User) {
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
