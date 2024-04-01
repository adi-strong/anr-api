<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait IsDeletedTrait
{
  #[ORM\Column(nullable: true)]
  #[Groups([
    'dep:read',
    'serv:read',
    'grade:read',
    'job:read',
    'agent:read',
    'f_site:read',
    'fuel:read',
    'society:read',
    'province:read',
  ])]
  private ?bool $isDeleted = false;

  public function isIsDeleted(): ?bool
  {
    return $this->isDeleted;
  }

  public function setIsDeleted(?bool $isDeleted): static
  {
    $this->isDeleted = $isDeleted;

    return $this;
  }
}
