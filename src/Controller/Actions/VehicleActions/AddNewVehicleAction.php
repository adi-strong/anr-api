<?php

namespace App\Controller\Actions\VehicleActions;

use App\Entity\DocObject;
use App\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewVehicleAction extends AbstractController
{
  public function __invoke(Vehicle $vehicle, Request $request): Vehicle
  {
    $certificateFileUploaded = $request->files->get('certificateFile');
    if (!$certificateFileUploaded) {
      throw new BadRequestHttpException('certificateFile: Le fichier est requis.');
    }

    $docObject = new DocObject();
    $docObject->file = $certificateFileUploaded;

    $vehicle
      ->setCertificate($docObject)
      ->setCreatedAt(new \DateTime());

    return $vehicle;
  }
}
