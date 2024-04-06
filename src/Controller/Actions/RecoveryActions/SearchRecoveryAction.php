<?php

namespace App\Controller\Actions\RecoveryActions;

use App\ApiResource\SearchRecoveriesResource;
use App\Repository\SocietyRecoveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchRecoveryAction extends AbstractController
{
  public function __construct(private readonly SocietyRecoveryRepository $repository) { }

  public function __invoke(SearchRecoveriesResource $resource): JsonResponse
  {
    $data = [];
    $startAt = $resource->startAt;
    $endAt = $resource->endAt;

    $recoveries = [];

    if (isset($startAt) && isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $endAt = $endAt->format('Y-m-d');
      $recoveries = $this->repository->findRecoveriesBetweenDates($startAt, $endAt);
    }
    elseif (isset($startAt) && !isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $recoveries = $this->repository->findRecoveryByDate($startAt);
    }
    elseif (isset($endAt) && !isset($startAt)) {
      $endAt = $endAt->format('Y-m-d');
      $recoveries = $this->repository->findRecoveryByDate($endAt);
    }

    if (count($recoveries) > 0) {
      foreach ($recoveries as $recovery) {
        $data[] = [
          'id' => $recovery->getId(),
          'activity' => $recovery->getType()?->getName(),
          'province' => $recovery->getProvince()?->getName(),
          'society' => $recovery->getSociety()
            ? [
              'id' => $recovery->getSociety()->getId(),
              'name' => $recovery->getSociety()->getName(),
            ] : null,
          'agent' => $recovery->getAgent()
            ? [
              'id' => $recovery->getAgent()->getId(),
              'name' => $recovery->getAgent()->getName(),
              'lastName' => $recovery->getAgent()?->getLastName(),
              'firstName' => $recovery->getAgent()?->getFirstName()
            ] : null,
          'releasedAt' => $recovery?->getReleasedAt(),
        ];
      }
    }

    return $this->json($data);
  }
}
