<?php

namespace App\Controller\Actions\ExpenseActions;

use App\Repository\CurrencyRepository;
use App\Repository\ExpenseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class ExpenseControllerAction extends  AbstractController
{
  public function __construct(
    private readonly ExpenseRepository $repository,
    private readonly CurrencyRepository $currencyRepository
  ) { }

  #[Route('/api/get_this_year_expenses_sum', methods: ['GET'])]
  public function getExpensesSum(): JsonResponse
  {
    $sum = 0;
    $lastCurrency = $this->currencyRepository->find(1);
    $reports = $this->repository->findThisYearExpenses();

    if (count($reports) > 0) {
      foreach ($reports as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) {
          $sum += $total;
        }
        else {
          $total = $total / $rate;
          $sum += $total;
        }
      }
    }

    $data = ['sum' => $sum, 'currency' => $lastCurrency->getLast()['symbol']];

    return $this->json($data);
  }

  //************************************************************************************

  #[Route('/api/search_expenses/{name}', methods: ['GET'])]
  public function onSearchProvinceName($name): JsonResponse
  {
    $data = [];

    $expenses = $this->repository->findExpenseByName($name);
    if (count($expenses) > 0) {
      foreach ($expenses as $expense) {
        $data[] = [
          'id' => $expense->getId(),
          'object' => $expense->getObject(),
          'operations' => $expense->getOperations(),
          'releasedAt' => $expense->getReleasedAt(),
          'rate' => $expense->getRate(),
          'currency' => $expense->getCurrency(),
          'bearer' => $expense->getBearer(),
          'total' => $expense->getTotal(),
        ];
      }
    }

    return $this->json($data);
  }
}
