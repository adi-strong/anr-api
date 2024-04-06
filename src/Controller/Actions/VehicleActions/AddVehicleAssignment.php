<?php

namespace App\Controller\Actions\VehicleActions;

use App\Entity\DocObject;
use App\Entity\VehicleAssignment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddVehicleAssignment extends AbstractController
{
  public function __invoke(VehicleAssignment $assignment, Request $request): VehicleAssignment
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
