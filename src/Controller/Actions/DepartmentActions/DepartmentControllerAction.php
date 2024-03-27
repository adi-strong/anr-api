<?php

namespace App\Controller\Actions\DepartmentActions;

use App\Repository\DepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class DepartmentControllerAction extends AbstractController
{
  public function __construct(private readonly DepartmentRepository $repository) { }

  #[Route('/api/search_departments/{name}', methods: ['GET'])]
  public function onSearchDepartmentName($name): JsonResponse
  {
    $data = [];

    $provinces = $this->repository->findProvinceByName($name);
    if (count($provinces) > 0) {
      foreach ($provinces as $province) {
        $data[] = [
          'id' => $province->getId(),
          'name' => $province->getName(),
          'slug' => $province->getSlug(),
        ];
      }
    }

    return $this->json($data);
  }
}
