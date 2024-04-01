<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait SlugTrait
{
  #[ORM\Column(length: 255, nullable: true)]
  #[Groups([
    'province:read',
    'dep:read',
    'serv:read',
    'grade:read',
    'job:read',
    'year:read',
    'agent:read',
  ])]
  private ?string $slug = null;

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(?string $slug): static
  {
    $this->slug = $slug;

    return $this;
  }
}
