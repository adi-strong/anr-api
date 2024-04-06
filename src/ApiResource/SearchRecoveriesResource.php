<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\RecoveryActions\SearchRecoveryAction;

#[ApiResource(
  operations: [
    new Post(controller: SearchRecoveryAction::class)
  ]
)]
final class SearchRecoveriesResource
{
  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;
}
