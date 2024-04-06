<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\ExpenseActions\SearchExpenseAction;

#[ApiResource(
  operations: [
    new Post(controller: SearchExpenseAction::class)
  ]
)]
class SearchExpenseResource
{
  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;
}
