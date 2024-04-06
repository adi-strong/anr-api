<?php

namespace App\Controller\Actions\FuelActions;

use App\ApiResource\SearchFuelSupplyResource;
use App\Repository\FuelStockSupplyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchFuelSupplyAction extends AbstractController
{
  public function __construct(private readonly FuelStockSupplyRepository $repository) { }

  public function __invoke(SearchFuelSupplyResource $resource): JsonResponse
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
          'id' => $report->getSupply()->getId(),
          'quantity'=> $report->getQuantity(),
          'fuel' => $report->getFuel()?->getName(),
          'site' => $report->getSite()?->getName(),
          'createdAt' => $report->getCreatedAt() ?? null,
        ];
      }
    }

    return $this->json($data);
  }
}
