<?php

namespace App\Services;

use App\Repository\RefuelingRepository;

class FuelStatsService
{
  public function __construct(private readonly RefuelingRepository $repository) { }

  public function getFuelConsumptionByDate(mixed $year, mixed $month): mixed
  {
    return $this->repository->findStatsByDate($year, $month);
  }
}
