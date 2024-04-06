<?php

namespace App\Controller\Actions\PropertyActions;

use App\Entity\DocObject;
use App\Entity\PropertyAssignment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddPropertyAssignmentAction extends AbstractController
{
  public function __invoke(PropertyAssignment $assignment, Request $request): PropertyAssignment
  {
    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $docObject = new DocObject();
      $docObject->file = $uploadedFile;
      $assignment->setDocObject($docObject);
    }

    $assignment->setReleasedAt(new \DateTime());

    return $assignment;
  }
}
