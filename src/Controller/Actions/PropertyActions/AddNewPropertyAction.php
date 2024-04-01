<?php

namespace App\Controller\Actions\PropertyActions;

use App\Entity\ImageObject;
use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewPropertyAction extends AbstractController
{
  public function __invoke(Property $property, Request $request): Property
  {
    $createdAt = new \DateTime();

    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $imageObject = new ImageObject();
      $imageObject->file = $uploadedFile;
      $property->setImageObject($imageObject);
    }

    $property->setCreatedAt($createdAt);

    return $property;
  }
}
