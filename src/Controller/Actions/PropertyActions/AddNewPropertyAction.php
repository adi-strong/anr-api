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
    if (!$uploadedFile) throw new BadRequestHttpException('file: Le fichier est requis.');

    $imageObject = new ImageObject();
    $imageObject->file = $uploadedFile;

    $property
      ->setCreatedAt($createdAt)
      ->setImageObject($imageObject);

    return $property;
  }
}
