<?php

namespace App\Controller\Actions\FuelActions;

use App\ApiResource\SearchRefuelingResource;
use App\Repository\RefuelingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchRefuelingAction extends AbstractController
{
  public function __construct(private readonly RefuelingRepository $repository) { }

  public function __invoke(SearchRefuelingResource $resource): JsonResponse
  {
    $data = [];
    $startAt = $resource->startAt;
    $endAt = $resource->endAt;

    $reports = [];

    if (isset($startAt) && isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findRecoveriesBetweenDates($startAt, $endAt);
    }
    elseif (isset($startAt) && !isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $reports = $this->repository->findRecoveryByDate($startAt);
    }
    elseif (isset($endAt) && !isset($startAt)) {
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findRecoveryByDate($endAt);
    }

    if (count($reports) > 0) {
      foreach ($reports as $report) {
        $data[] = [
          'quantity' => $report->getQuantity(),
          'fuel' => $report->getFuel()?->getName(),
          'site' => $report->getSite()?->getName(),
          'vehicle' => $report->getVehicle()?->getBrand(),
          'createdAt' => $report->getCreatedAt() ?? null,
          'grade' => $report->getAgent()?->getGrade()?->getName() ?? null,
          'agent' => $report->getAgent() ? [
            'name' => $report->getAgent()->getName(),
            'lastName' => $report->getAgent()->getLastName() ?? null,
            'firstName' => $report->getAgent()->getLastName() ?? null,
          ] : [],
        ];
      }
    }

    return $this->json($data);
  }
}
