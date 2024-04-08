<?php

namespace App\Controller\StatsActions;

use App\Repository\CurrencyRepository;
use App\Repository\ExpenseRepository;
use App\Services\FuelStatsService;
use App\Services\MissionStatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class StatsControllerActions extends AbstractController
{
  const JAN = '01', FEB = '02', MAR = '03';
  const APR = '04', MAY = '05', JUN = '06';
  const JUL = '07', AUG = '08', SEP = '09';
  const OCT = '10', NOV = '11', DEC = '12';

  public function __construct(
    private readonly FuelStatsService $fuelStatsService,
    private readonly ExpenseRepository $expenseRepository,
    private readonly CurrencyRepository $currencyRepository,
    private readonly MissionStatsService $missionStatsService
  ) { }

  #[Route('/api/get_finances_stats', methods: ['GET'])]
  public function getFinances(): JsonResponse
  {
    $expenses = $this->expenseRepository->findThisYearExpenses();

    $lastCurrency = $this->currencyRepository->find(1);

    $others = 0;
    $missions = 0;

    if (count($expenses) > 0) {
      foreach ($expenses as $expense) {
        $rate = $expense->getRate();
        $currency = $expense->getCurrency();

        if (null === $expense->getMission()) {
          $amount1 = $expense->getTotal();
          if ($currency['code'] === $lastCurrency->getLast()['code']) $others += $amount1;
          else $others += ($amount1 / $rate);
        }

        if (null !== $expense->getMission()) {
          $amount2 = $expense->getTotal();
          if ($currency['code'] === $lastCurrency->getLast()['code']) $missions += $amount2;
          else $missions += ($amount2 / $rate);
        }
      }
    }

    $data = [
      'others' => number_format($others, 2),
      'missions' => number_format($missions, 2),
      'currency' => [
        'code' => $lastCurrency->getLast()['code'],
        'symbol' => $lastCurrency->getLast()['symbol'],
      ]
    ];

    return $this->json($data);
  }

  #[Route('/api/get_this_month_finances_stats', methods: ['GET'])]
  public function getThisMonthFinances(): JsonResponse
  {
    $month = date('m');
    $expenses = $this->expenseRepository->findExpenseByMonth($month);

    $lastCurrency = $this->currencyRepository->find(1);

    $others = 0;
    $missions = 0;

    if (count($expenses) > 0) {
      foreach ($expenses as $expense) {
        $rate = $expense->getRate();
        $currency = $expense->getCurrency();

        if (null === $expense->getMission()) {
          $amount1 = $expense->getTotal();
          if ($currency['code'] === $lastCurrency->getLast()['code']) $others += $amount1;
          else $others += ($amount1 / $rate);
        }

        if (null !== $expense->getMission()) {
          $amount2 = $expense->getTotal();
          if ($currency['code'] === $lastCurrency->getLast()['code']) $missions += $amount2;
          else $missions += ($amount2 / $rate);
        }
      }
    }

    $data = [
      'others' => number_format($others, 2),
      'missions' => number_format($missions, 2),
      'currency' => [
        'code' => $lastCurrency->getLast()['code'],
        'symbol' => $lastCurrency->getLast()['symbol'],
      ]
    ];

    return $this->json($data);
  }

  #[Route('/api/get_last_month_finances_stats', methods: ['GET'])]
  public function getLastMonthFinances(): JsonResponse
  {
    $month = date('m', strtotime('- 1 month'));
    $expenses = $this->expenseRepository->findExpenseByMonth($month);

    $lastCurrency = $this->currencyRepository->find(1);

    $others = 0;
    $missions = 0;

    if ($month !== '12') {
      if (count($expenses) > 0) {
        foreach ($expenses as $expense) {
          $rate = $expense->getRate();
          $currency = $expense->getCurrency();

          if (null === $expense->getMission()) {
            $amount1 = $expense->getTotal();
            if ($currency['code'] === $lastCurrency->getLast()['code']) $others += $amount1;
            else $others += ($amount1 / $rate);
          }

          if (null !== $expense->getMission()) {
            $amount2 = $expense->getTotal();
            if ($currency['code'] === $lastCurrency->getLast()['code']) $missions += $amount2;
            else $missions += ($amount2 / $rate);
          }
        }
      }
    }

    $data = [
      'others' => number_format($others, 2),
      'missions' => number_format($missions, 2),
      'currency' => [
        'code' => $lastCurrency->getLast()['code'],
        'symbol' => $lastCurrency->getLast()['symbol'],
      ]
    ];

    return $this->json($data);
  }

  #[Route('/api/get_synthesis_stats', methods: ['GET'])]
  public function getSynthesisStats(): JsonResponse
  {
    $year = date('Y');
    $lastCurrency = $this->currencyRepository->find(1);

    // Fuel Stats
    $janFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::JAN);
    $febFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::FEB);
    $marFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::MAR);
    $aprFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::APR);
    $mayFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::MAY);
    $junFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::JUN);
    $julFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::JUL);
    $augFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::AUG);
    $sepFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::SEP);
    $octFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::OCT);
    $novFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::NOV);
    $decFuelStats = $this->fuelStatsService->getFuelConsumptionByDate($year, self::DEC);
    // End Fuel Stats **********************************************************************************



    // Expenses Stats
    $janExpStats = $this->expenseRepository->findStatsByDate($year, self::JAN);
    $febExpStats = $this->expenseRepository->findStatsByDate($year, self::FEB);
    $marExpStats = $this->expenseRepository->findStatsByDate($year, self::MAR);
    $aprExpStats = $this->expenseRepository->findStatsByDate($year, self::APR);
    $mayExpStats = $this->expenseRepository->findStatsByDate($year, self::MAY);
    $junExpStats = $this->expenseRepository->findStatsByDate($year, self::JUN);
    $julExpStats = $this->expenseRepository->findStatsByDate($year, self::JUL);
    $augExpStats = $this->expenseRepository->findStatsByDate($year, self::AUG);
    $sepExpStats = $this->expenseRepository->findStatsByDate($year, self::SEP);
    $octExpStats = $this->expenseRepository->findStatsByDate($year, self::OCT);
    $novExpStats = $this->expenseRepository->findStatsByDate($year, self::NOV);
    $decExpStats = $this->expenseRepository->findStatsByDate($year, self::DEC);

    $janExpensesSum = 0;
    $febExpensesSum = 0;
    $marExpensesSum = 0;
    $aprExpensesSum = 0;
    $mayExpensesSum = 0;
    $junExpensesSum = 0;
    $julExpensesSum = 0;
    $augExpensesSum = 0;
    $sepExpensesSum = 0;
    $octExpensesSum = 0;
    $novExpensesSum = 0;
    $decExpensesSum = 0;

    if (count($janExpStats) > 0) {
      foreach ($janExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $janExpensesSum += $total;
        else $janExpensesSum = $total / $rate;
      }
    }

    if (count($febExpStats) > 0) {
      foreach ($febExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $febExpensesSum += $total;
        else $febExpensesSum = $total / $rate;
      }
    }

    if (count($marExpStats) > 0) {
      foreach ($marExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $marExpensesSum += $total;
        else $marExpensesSum = $total / $rate;
      }
    }

    if (count($aprExpStats) > 0) {
      foreach ($aprExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $aprExpensesSum += $total;
        else $aprExpensesSum = $total / $rate;
      }
    }

    if (count($mayExpStats) > 0) {
      foreach ($mayExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $mayExpensesSum += $total;
        else $mayExpensesSum = $total / $rate;
      }
    }

    if (count($junExpStats) > 0) {
      foreach ($junExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $junExpensesSum += $total;
        else $junExpensesSum = $total / $rate;
      }
    }

    if (count($julExpStats) > 0) {
      foreach ($julExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $julExpensesSum += $total;
        else $julExpensesSum = $total / $rate;
      }
    }

    if (count($augExpStats) > 0) {
      foreach ($augExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $augExpensesSum += $total;
        else $augExpensesSum = $total / $rate;
      }
    }

    if (count($sepExpStats) > 0) {
      foreach ($sepExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $sepExpensesSum += $total;
        else $sepExpensesSum = $total / $rate;
      }
    }

    if (count($octExpStats) > 0) {
      foreach ($octExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $octExpensesSum += $total;
        else $octExpensesSum = $total / $rate;
      }
    }

    if (count($novExpStats) > 0) {
      foreach ($novExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $novExpensesSum += $total;
        else $novExpensesSum = $total / $rate;
      }
    }

    if (count($decExpStats) > 0) {
      foreach ($decExpStats as $report) {
        $currency = $report->getCurrency();
        $rate = $report->getRate();
        $total = $report->getTotal();

        if ($currency['symbol'] === $lastCurrency->getLast()['symbol']) $decExpensesSum += $total;
        else $decExpensesSum = $total / $rate;
      }
    }
    // End Expenses Stats ******************************************************************************


    // Fuel Missions
    $janMissionStats = $this->missionStatsService->getMissionsByDate($year, self::JAN);
    $febMissionStats = $this->missionStatsService->getMissionsByDate($year, self::FEB);
    $marMissionStats = $this->missionStatsService->getMissionsByDate($year, self::MAR);
    $aprMissionStats = $this->missionStatsService->getMissionsByDate($year, self::APR);
    $mayMissionStats = $this->missionStatsService->getMissionsByDate($year, self::MAY);
    $junMissionStats = $this->missionStatsService->getMissionsByDate($year, self::JUN);
    $julMissionStats = $this->missionStatsService->getMissionsByDate($year, self::JUL);
    $augMissionStats = $this->missionStatsService->getMissionsByDate($year, self::AUG);
    $sepMissionStats = $this->missionStatsService->getMissionsByDate($year, self::SEP);
    $octMissionStats = $this->missionStatsService->getMissionsByDate($year, self::OCT);
    $novMissionStats = $this->missionStatsService->getMissionsByDate($year, self::NOV);
    $decMissionStats = $this->missionStatsService->getMissionsByDate($year, self::DEC);
    // End Missions Stats ******************************************************************************

    $data = [
      [
        'name'=> 'Carburant',
        'data' => [
          number_format($janFuelStats, 2), number_format($febFuelStats, 2), number_format($marFuelStats, 2),
          number_format($aprFuelStats, 2), number_format($mayFuelStats, 2), number_format($junFuelStats, 2),
          number_format($julFuelStats, 2), number_format($augFuelStats, 2), number_format($sepFuelStats, 2),
          number_format($octFuelStats, 2), number_format($novFuelStats, 2), number_format($decFuelStats, 2),
        ]
      ],

      [
        'name'=> 'Dépenses',
        'data' => [
          number_format($janExpensesSum, 2), number_format($febExpensesSum, 2), number_format($mayExpensesSum, 2),
          number_format($aprExpensesSum, 2), number_format($mayExpensesSum, 2), number_format($junExpensesSum, 2),
          number_format($julExpensesSum, 2), number_format($augExpensesSum, 2), number_format($sepExpensesSum, 2),
          number_format($octExpensesSum, 2), number_format($novExpensesSum, 2), number_format($decExpensesSum, 2),
        ]
      ],

      [
        'name'=> 'Missions',
        'data' => [
          $janMissionStats, $febMissionStats, $marMissionStats,
          $aprMissionStats, $mayMissionStats, $junMissionStats,
          $julMissionStats, $augMissionStats, $sepMissionStats,
          $octMissionStats, $novMissionStats, $decMissionStats
        ]
      ],
    ];

    return $this->json($data);
  }
}
