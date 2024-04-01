<?php

namespace App\Controller\Actions\MedicalActions;

use App\Entity\DocObject;
use App\Entity\Medical;
use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewMedicalAction extends AbstractController
{
  public function __construct(
    private readonly Security $security,
    private readonly YearRepository $yearRepository
  ) { }

  public function __invoke(Medical $medical, Request $request): Medical
  {
    $lastSession = $this->yearRepository->findLastYear();
    if (null !== $lastSession && $lastSession->isIsActive() === true) {
      $medical->setYear($lastSession);
    }
    else throw new BadRequestHttpException('year: Aucune année en cours.');

    $createdAt = new \DateTime();
    $user = $this->security->getUser();

    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) throw new BadRequestHttpException('file: Le fichier est requis.');

    $docObject = new DocObject();
    $docObject->file = $uploadedFile;

    $medical
      ->setDocObject($docObject);

    return $medical;
  }
}
