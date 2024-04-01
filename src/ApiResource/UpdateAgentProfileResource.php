<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\AgentActions\UpdateAgentProfileAction;
use Symfony\Component\HttpFoundation\File\File;

#[ApiResource(
  operations: [
    new Post(
      uriTemplate: '/agents/profile-edit',
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: UpdateAgentProfileAction::class
    )
  ]
)]
class UpdateAgentProfileResource
{
  public ?string $agentId = null;

  public ?File $file = null;
}
