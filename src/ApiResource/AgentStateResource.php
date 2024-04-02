<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\AgentActions\AgentStateAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  operations: [
    new Post(
      uriTemplate: '/agents/state-edit',
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AgentStateAction::class
    )
  ]
)]
class AgentStateResource
{
  public ?string $agentId = null;

  #[Assert\Choice([
    'active',
    'inactive',
    'sick',
    'suspended',
    'leave',
    'unavailable',
    'retired',
    'dead'
  ], message: 'État invalide.')]
  #[Assert\NotBlank(message: 'Ce champ est requis.')]
  #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
  public ?string $state = null;

  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;

  public ?File $file = null;
}
