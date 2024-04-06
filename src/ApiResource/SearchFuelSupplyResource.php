<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\FuelActions\SearchFuelSupplyAction;

#[ApiResource(
  operations: [
    new Post(controller: SearchFuelSupplyAction::class)
  ]
)]
class SearchFuelSupplyResource
{
  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;
}
