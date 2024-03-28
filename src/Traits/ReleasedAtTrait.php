<?php

namespace App\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait ReleasedAtTrait
{
  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  #[Groups([
    'agent:read',
  ])]
  private ?\DateTimeInterface $releasedAt = null;

  public function getReleasedAt(): ?\DateTimeInterface
  {
    return $this->releasedAt;
  }

  public function setReleasedAt(?\DateTimeInterface $releasedAt): static
  {
    $this->releasedAt = $releasedAt;

    return $this;
  }
}
