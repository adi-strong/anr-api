<?php

namespace App\Services;

use App\Repository\MissionRepository;

class MissionStatsService
{
  public function __construct(private readonly MissionRepository $repository) { }

  public function getMissionsByDate(mixed $year, mixed $month): mixed
  {
    return $this->repository->findStatsByDate($year, $month);
  }
}
