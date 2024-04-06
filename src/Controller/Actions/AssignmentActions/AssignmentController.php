<?php

namespace App\Controller\Actions\AssignmentActions;

use App\Repository\AssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class AssignmentController extends AbstractController
{
  public function __construct(private readonly AssignmentRepository $repository) { }

  #[Route('/api/current_assignments', methods: ['GET'])]
  public function getCurrentMissions(): JsonResponse
  {
    $data = [];
    $assignments = $this->repository->findAssignments();
    if (count($assignments) > 0) {
      foreach ($assignments as $assignment) {
        $agent = $assignment->getAgent();

        $startAt = $assignment->getStartAt() ?? null;
        $endAt = $assignment->getEndAt() ?? null;
        $duration = null;

        if (isset($startAt) && isset($endAt) && isset($duration)) {
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
        else {
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

  #[Route('/api/assignments_near_expirations', methods: ['GET'])]
  public function getMissionsNearExpirations(): JsonResponse
  {
    $data = [];
    $assignments = $this->repository->findAssignments();
    if (count($assignments) > 0) {
      foreach ($assignments as $assignment) {
        $agent = $assignment->getAgent();

        $startAt = $assignment->getStartAt() ?? null;
        $endAt = $assignment->getEndAt() ?? null;
        $duration = null;

        if (isset($startAt) && isset($endAt) && isset($duration)) {
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
        else {
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
