<?php

namespace App\Controller\Actions\NewsActions;

use App\ApiResource\SearchNewsResource;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class SearchNewsResourceAction extends AbstractController
{
  public function __construct(private readonly NewsRepository $repository) { }
  
  public function __invoke(SearchNewsResource $resource): JsonResponse
  {
    $startAt = $resource->startAt;
    $endAt = $resource->endAt;
    
    $reports = [];
    $data = [];
    
    if (isset($startAt) && isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findNewsBetweenDated($startAt, $endAt);
    }
    elseif (isset($startAt) && !isset($endAt)) {
      $startAt = $startAt->format('Y-m-d');
      $reports = $this->repository->findDailyNews($startAt);
    }
    elseif (isset($endAt) && !isset($startAt)) {
      $endAt = $endAt->format('Y-m-d');
      $reports = $this->repository->findDailyNews($endAt);
    }
    
    if (!empty($reports)) {
      foreach ($reports as $new) {
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
}
