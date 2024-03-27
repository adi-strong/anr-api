<?php

namespace App\Controller\Actions\ProvinceActions;

use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class YearControllerAction extends AbstractController
{
  public function __construct(private readonly YearRepository $repository) { }

  #[Route('/api/search_years/{name}', methods: ['GET'])]
  public function onSearchYearName($name): JsonResponse
  {
    $data = [];

    $years = $this->repository->findYearByName($name);
    if (count($years) > 0) {
      foreach ($years as $year) {
        $data[] = [
          'id' => $year->getId(),
          'name' => $year->getName(),
          'slug' => $year->getSlug() ?? null,
          'isActive' => $year->isIsActive(),
        ];
      }
    }

    return $this->json($data);
  }
}
