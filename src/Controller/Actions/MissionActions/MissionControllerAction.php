<?php

namespace App\Controller\Actions\MissionActions;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class MissionControllerAction extends AbstractController
{
  public function __construct(private readonly MissionRepository $repository) { }

  #[Route('/api/current_missions', methods: ['GET'])]
  public function getCurrentMissions(): JsonResponse
  {
    $data = [];
    $missions = $this->repository->findMissions();
    if (count($missions) > 0) {
      foreach ($missions as $mission) {
        $agent = $mission->getAgent();

        $startAt = $mission->getStartAt();
        $endAt = $mission->getEndAt();
        $duration = $endAt->diff($startAt)->days;

        if ($duration > 0 && false === $agent->isIsDeleted()) {
          $thisYear = date('Y');
          $year = $agent?->getBornAt()->format('Y');
          $age = null;

          if (null !== $year) {
            $age = $thisYear - $year;
          }

          $grade = $agent->getGrade() ? [
            'id' => $agent->getGrade()->getId(),
            'name' => $agent->getGrade()->getName()
          ] : null;

          $profile = $agent->getProfile() ? [
            'contentUrl' => '/media/img/'.$agent->getProfile()->filePath
          ] : null;

          $data[] = [
            'id' => $agent->getId(),
            'register' => $agent->getRegister(),
            'age' => $age,
            'name' => $agent->getName(),
            'lastName' => $agent->getLastName() ?? null,
            'firstName' => $agent->getFirstName() ?? null,
            'grade' => $grade,
            'profile' => $profile
          ];
        }
      }
    }

    return $this->json($data);
  }

  #[Route('/api/missions_near_expirations', methods: ['GET'])]
  public function getMissionsNerExpirations(): JsonResponse
  {
    $data = [];
    $missions = $this->repository->findMissions();
    if (count($missions) > 0) {
      foreach ($missions as $mission) {
        $agent = $mission->getAgent();

        $startAt = $mission->getStartAt();
        $endAt = $mission->getEndAt();
        $duration = $endAt->diff($startAt)->days;

        if ($duration <= 7 && false === $agent->isIsDeleted()) {
          $thisYear = date('Y');
          $year = $agent?->getBornAt()->format('Y');
          $age = null;

          if (null !== $year) {
            $age = $thisYear - $year;
          }

          $grade = $agent->getGrade() ? [
            'id' => $agent->getGrade()->getId(),
            'name' => $agent->getGrade()->getName()
          ] : null;

          $profile = $agent->getProfile() ? [
            'contentUrl' => '/media/img/'.$agent->getProfile()->filePath
          ] : null;

          $data[] = [
            'id' => $agent->getId(),
            'register' => $agent->getRegister(),
            'age' => $age,
            'name' => $agent->getName(),
            'lastName' => $agent->getLastName() ?? null,
            'firstName' => $agent->getFirstName() ?? null,
            'grade' => $grade,
            'profile' => $profile
          ];
        }
      }
    }

    return $this->json($data);
  }
}
