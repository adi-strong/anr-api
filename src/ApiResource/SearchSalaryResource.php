<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\SalaryActions\SearchSalaryActions;

#[ApiResource(
  operations: [
    new Post(controller: SearchSalaryActions::class)
  ]
)]
class SearchSalaryResource
{
  public mixed $yearId = null;

  public mixed $month = null;
}
