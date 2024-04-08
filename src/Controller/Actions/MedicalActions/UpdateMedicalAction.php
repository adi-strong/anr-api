<?php

namespace App\Controller\Actions\MedicalActions;

use App\ApiResource\MedicalResource;
use App\Entity\DocObject;
use App\Entity\Medical;
use App\Repository\MedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class UpdateMedicalAction extends AbstractController
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly MedicalRepository $repository
  ) { }

  public function __invoke(MedicalResource $resource, Request $request): Medical
  {
    $id = $resource->medicalId;
    $medical = $this->repository->find($id);
    if (!$medical) {
      throw new BadRequestHttpException('La Fiche ayant l\'ID : "'.$id.'" n\'existe pas.');
    }

    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $oldFile = $medical->getDocObject();
      $oldFile->setMedical(null);
      $medical->setDocObject(null);
      $this->em->remove($oldFile);

      $docObject = new DocObject();
      $docObject->file = $uploadedFile;
      $this->em->persist($docObject);

      $medical->setDocObject($docObject);
    }

    $medical->setObservation($resource->observation);

    $this->em->flush();

    return $medical;
  }
}
