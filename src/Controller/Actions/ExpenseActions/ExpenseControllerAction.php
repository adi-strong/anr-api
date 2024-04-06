<?php

namespace App\Controller\Actions\ExpenseActions;

use App\Repository\ExpenseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class ExpenseControllerAction extends  AbstractController
{
  public function __construct(private readonly ExpenseRepository $repository) { }

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
