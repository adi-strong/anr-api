<?php

namespace App\Controller\Actions\NewsActions;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class NewsControllerActions extends AbstractController
{
  public function __construct(private readonly NewsRepository $repository) { }
  
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
}
