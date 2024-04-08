<?php

namespace App\Controller\Actions\PropertyActions;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class UpdatePropertyAction extends AbstractController
{
  public function __invoke(Property $property): Property
  {
    if (null === $property->getAgent()) {
      $property->setIsAvailable(true);
    }

    return $property;
  }
}
