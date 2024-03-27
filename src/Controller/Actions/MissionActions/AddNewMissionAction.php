<?php

namespace App\Controller\Actions\MissionActions;

use App\Entity\DocObject;
use App\Entity\Mission;
use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewMissionAction extends AbstractController
{
  public function __construct(
    private readonly Security $security,
    private readonly YearRepository $yearRepository
  ) { }

  public function __invoke(Mission $mission, Request $request): Mission
  {
    $lastSession = $this->yearRepository->findLastYear();
    if (null !== $lastSession && $lastSession->isIsActive() === true) {
      $mission->setYear($lastSession);
    }
    else throw new BadRequestHttpException('year: Aucune année en cours.');

    /* --------------------------------------- FILES TO UPLOAD ----------------------------------------------- */
    $roadmapFileUploaded = $request->files->get('roadmapFile');
    $exitPermitFileUploaded = $request->files->get('exitPermitFile');
    $missionOrderFileUploaded = $request->files->get('$missionOrderFile');

    if (!$roadmapFileUploaded) {
      throw new BadRequestHttpException('roadmap: La Feuille de route doit être renseignée.');
    }
    if (!$exitPermitFileUploaded) {
      throw new BadRequestHttpException('exitPermit: La Permission de sortie doit être renseignée.');
    }
    if (!$missionOrderFileUploaded) {
      throw new BadRequestHttpException('exitPermit: L\'Ordre de mission doit être renseignée.');
    }

    $roadmapDoc = new DocObject();
    $roadmapDoc->file = $roadmapFileUploaded;
    $mission->setRoadmap($roadmapDoc);

    $exitPermitDoc = new DocObject();
    $exitPermitDoc->file = $exitPermitFileUploaded;
    $mission->setExitPermit($exitPermitDoc);

    $missionOrderDoc = new DocObject();
    $missionOrderDoc->file = $missionOrderFileUploaded;
    $mission->setMissionOrder($missionOrderDoc);
    /* --------------------------------------- END FILES TO UPLOAD ------------------------------------------- */

    $createdAt = $mission->getCreatedAt() ?? new \DateTime();
    $user = $this->security->getUser();

    $mission
      ->setUser($user)
      ->setCreatedAt($createdAt);

    return $mission;
  }
}
