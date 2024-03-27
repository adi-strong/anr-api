<?php

namespace App\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait UpdatedAtTrait
{
  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  #[Groups([
    'property:read',
  ])]
  private ?\DateTimeInterface $updatedAt = null;

  public function getUpdatedAt(): ?\DateTimeInterface
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }
}
