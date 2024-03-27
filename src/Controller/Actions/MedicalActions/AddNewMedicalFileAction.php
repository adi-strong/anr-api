<?php

namespace App\Controller\Actions\MedicalActions;

use App\Entity\DocObject;
use App\Entity\MedicalFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewMedicalFileAction extends AbstractController
{
  public function __construct(private readonly Security $security) { }

  public function __invoke(MedicalFile $medicalFile, Request $request): MedicalFile
  {
    $createdAt = new \DateTime();
    $user = $this->security->getUser();

    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) throw new BadRequestHttpException('file: Le fichier est requis.');

    $docObject = new DocObject();
    $docObject->file = $uploadedFile;

    $medicalFile
      ->setUser($user)
      ->setCreatedAt($createdAt)
      ->setDocObject($docObject);

    return $medicalFile;
  }
}
