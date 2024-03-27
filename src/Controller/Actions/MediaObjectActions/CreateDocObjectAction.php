<?php

namespace App\Controller\Actions\MediaObjectActions;

use App\Entity\DocObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateDocObjectAction extends AbstractController
{
  public function __invoke(Request $request): DocObject
  {
    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) throw new BadRequestHttpException('"file" is required.');

    $docObject = new DocObject();
    $docObject->file = $uploadedFile;

    return $docObject;
  }
}
