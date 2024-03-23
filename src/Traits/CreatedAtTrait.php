<?php

namespace App\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait CreatedAtTrait
{

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  #[Groups([
    'user:read',
  ])]
  private ?\DateTimeInterface $createdAt = null;

  public function getCreatedAt(): ?\DateTimeInterface
  {
    return $this->createdAt;
  }

  public function setCreatedAt(?\DateTimeInterface $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }
}
