<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\MedicalActions\UpdateMedicalAction;
use Symfony\Component\HttpFoundation\File\File;

#[ApiResource(
  operations: [
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: UpdateMedicalAction::class
    )
  ]
)]
class MedicalResource
{
  public mixed $medicalId = null;

  public ?string $observation = null;

  public ?File $file = null;
}
