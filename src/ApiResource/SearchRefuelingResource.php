<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\FuelActions\SearchRefuelingAction;

#[ApiResource(
  operations: [
    new Post(controller: SearchRefuelingAction::class)
  ]
)]
class SearchRefuelingResource
{
  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;
}
