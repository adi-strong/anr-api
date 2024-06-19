<?php

namespace App\Controller\Actions\NewsActions;

use App\Entity\Department;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class NewsControllerActions extends AbstractController
{
  public function __construct(
    private readonly NewsRepository $repository,
    private readonly Security $security
  ) { }
  
  #[Route('/api/daily_news', name: 'daily_news', methods: ['GET'])]
  public function getDailyNews(): JsonResponse
  {
    $data = [];
    $releasedAt = date('Y-m-d');
    
    $news = $this->repository->findDailyNews($releasedAt);
    if (!empty($news)) {
      foreach ($news as $new) {
        $data[] = [
          'id' => $new->getId(),
          'title' => $new->getTitle(),
          'releasedAt' => $new->getReleasedAt(),
          'priority' => $new->getPriority(),
          'isTreated' => $new->isIsTreated()
        ];
      }
    }
    
    return $this->json($data);
  }
  
  #[Route('/api/department_news', name: 'department_news', methods: ['GET'])]
  public function getDepartmentNews(): JsonResponse
  {
    $data = [];
    $department = null;
    $user = $this->security->getUser() ?? null;
    $account = $user?->getAgentAccount();
    if (isset($account) && $account->getDepartment() !== null) {
      $department = $account->getDepartment();
    }
    
    if (isset($department) && $department instanceof Department) {
      $news = $this->repository->findNewsByDepartment($department);
      if (!empty($news)) {
        foreach ($news as $new) {
          $data[] = [
            'id' => $new->getId(),
            'title' => $new->getTitle(),
            'priority' => $new->getPriority(),
            'releasedAt' => $new->getReleasedAt(),
          ];
        }
      }
    }
    
    return $this->json($data);
  }
}
