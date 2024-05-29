<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\NewsActions\SearchNewsResourceAction;

#[ApiResource(
  operations: [
    new Post(controller: SearchNewsResourceAction::class)
  ]
)]
class SearchNewsResource
{
  public ?\DateTimeInterface $startAt = null;
  
  public ?\DateTimeInterface $endAt = null;
}
