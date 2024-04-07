<?php

namespace App\Controller\Actions\SalaryActions;

use App\ApiResource\SearchSalaryResource;
use App\Repository\CurrencyRepository;
use App\Repository\SalaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchSalaryActions extends AbstractController
{
  public function __construct(
    private readonly SalaryRepository $repository,
    private readonly CurrencyRepository $currencyRepository
  ) { }

  public function __invoke(SearchSalaryResource $resource): JsonResponse
  {
    $data = [];

    $yearId = $resource->yearId;
    $month = $resource->month;

    if (isset($yearId) && isset($month)) {
      $yearId = (int) $yearId;
      $month = (string) $month;
      $lastCurrency = $this->currencyRepository->find(1);

      $salaries = $this->repository->findSalaries($yearId, $month);

      if (count($salaries) > 0) {
        foreach ($salaries as $salary) {
          $rate = $salary->getRate();
          $baseAmount = $salary->getBaseAmount();
          $riskPremiumAmount = $salary->getRiskPremiumAmount();
          $functionBonusAmount = $salary->getFunctionBonusAmount();

          if ($salary->getCurrency()['code'] === $lastCurrency->getLast()['code']) {
            $baseAmount = $baseAmount / $rate;
            $riskPremiumAmount = $riskPremiumAmount / $rate;
            $functionBonusAmount = $functionBonusAmount / $rate;
          }

          $total = $baseAmount + $riskPremiumAmount + $functionBonusAmount;

          $data[] = [
            'id' => $salary->getId(),
            'grade' => $salary->getAgent()?->getGrade()?->getName(),
            'job' => $salary->getAgent()?->getJob()?->getName(),
            'baseAmount' => $baseAmount,
            'riskPremiumAmount' => $riskPremiumAmount,
            'functionBonusAmount' => $functionBonusAmount,
            'total' => $total,
            'rate' => $rate,
            'currency' => $lastCurrency->getFirst()['symbol'],
            'agent' => $salary->getAgent() ? [
              'id' => $salary->getAgent()->getId(),
              'name' => $salary->getAgent()->getName(),
              'lastName' => $salary->getAgent()->getLastName(),
              'firstName' => $salary->getAgent()->getFirstName(),
            ] : [],
          ];
        }
      }
    }

    return $this->json($data);
  }
}
