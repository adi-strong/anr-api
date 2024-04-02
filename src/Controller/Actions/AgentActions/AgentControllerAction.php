<?php

namespace App\Controller\Actions\AgentActions;

use App\Repository\AgentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class AgentControllerAction extends AbstractController
{
  public function __construct(private readonly AgentRepository $repository) { }

  #[Route('/api/search_agents/{keyword}', methods: ['GET'])]
  public function getSearchAgent($keyword): JsonResponse
  {
    $data = [];

    $agents = $this->repository->findAgents($keyword);
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
        $service = $agent?->getService();
        $department = $agent?->getDepartment();
        $grade = $agent?->getGrade();
        $job = $agent?->getJob();

        $data[] = [
          'id' => $agent->getId(),
          'name' => $agent->getName(),
          'lastName' => $agent->getLastName(),
          'firstName' => $agent->getFirstName(),
          'sex' => $agent->getSex(),
          'origin' => $agent->getOrigin(),
          'maritalStatus' => $agent->getMaritalStatus(),
          'conjoint' => $agent->getConjoint(),
          'conjointOrigin' => $agent->getConjointOrigin(),
          'service' => isset($service) ? [
            'id' => $service->getId(),
            'name' => $service->getName(),
            'slug' => $service->getSlug()
          ] : null,

          'job' => isset($job) ? [
            'id' => $job->getId(),
            'name' => $job->getName(),
            'slug' => $job->getSlug()
          ] : null,

          'grade' => isset($grade) ? [
            'id' => $grade->getId(),
            'name' => $grade->getName(),
            'slug' => $grade->getSlug()
          ] : null,
          
          'department' => isset($department) ? [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'slug' => $department->getSlug()
          ] : null,

          'phone' => $agent->getPhone(),
          'email' => $agent->getEmail(),
          'state' => $agent->getState(),
          'isDeleted' => $agent->isIsDeleted(),
        ];
      }
    }

    return $this->json($data);
  }

  #[Route('/api/active_agents', methods: ['GET'])]
  public function getActiveAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('active');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/inactive_agents', methods: ['GET'])]
  public function getInactiveAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('inactive');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/sick_agents', methods: ['GET'])]
  public function getSickAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('sick');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/leave_agents', methods: ['GET'])]
  public function getLeaveAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('leave');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/dead_agents', methods: ['GET'])]
  public function getDeadAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('dead');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/unavailable_agents', methods: ['GET'])]
  public function getUnavailableAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('unavailable');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }

  #[Route('/api/retired_agents', methods: ['GET'])]
  public function getRetiredAgents(): JsonResponse
  {
    $data = [];
    $agents = $this->repository->findAgentsByState('retired');
    if (count($agents) > 0) {
      foreach ($agents as $agent) {
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

    return $this->json($data);
  }
}
