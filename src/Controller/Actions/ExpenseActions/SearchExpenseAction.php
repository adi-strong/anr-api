<?php

namespace App\Controller\Actions\ExpenseActions;

use App\ApiResource\SearchExpenseResource;
use App\Repository\CurrencyRepository;
use App\Repository\ExpenseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchExpenseAction extends AbstractController
{
  public function __construct(
    private readonly ExpenseRepository $repository,
    private readonly CurrencyRepository $currencyRepository
  ) { }

  public function __invoke(SearchExpenseResource $resource): JsonResponse
  {
    $data = [];
    $startAt = $resource->startAt;
    $endAt = $resource->endAt;

    $reports = [];

    $lastCurrency = $this->currencyRepository->find(1);

    if (isset($startAt) && isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findExpensesBetweenDates($startAt, $endAt);
    }
    elseif (isset($startAt) && !isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $reports = $this->repository->findReportByDate($startAt);
    }
    elseif (isset($endAt) && !isset($startAt)) {
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findReportByDate($endAt);
    }

    $total1 = 0;
    $total2 = 0;

    if (count($reports) > 0) {
      foreach ($reports as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();

        if ($currency['symbol'] === $lastCurrency->getFirst()['symbol']) {
          $amount1 = $report->getTotal();
          $amount2 = $amount1 / $rate;
        }
        else {
          $amount2 = $report->getTotal();
          $amount1 = $amount2 * $rate;
        }

        $total1 += $amount1;
        $total2 += $amount2;

        $data[] = [
          'id' => $report->getId(),
          'object' => $report->getObject(),
          'bearer' => $report->getBearer(),
          'amount1' => $amount1,
          'amount2' => $amount2,
          'currency' => $currency,
          'rate'=> $rate,
        ];
      }
    }

    return $this->json([
      'data' => $data,
      'total1' => $total1,
      'total2' => $total2
    ]);
  }
}
