<?php

namespace App\Controller\Actions\MediaObjectActions;

use App\Entity\ImageObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateImageObjectAction extends AbstractController
{
  public function __invoke(Request $request): ImageObject
  {
    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) throw new BadRequestHttpException('"file" is required.');

    $imageObject = new ImageObject();
    $imageObject->file = $uploadedFile;

    return $imageObject;
  }
}
