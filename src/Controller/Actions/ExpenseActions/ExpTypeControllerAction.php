<?php

namespace App\Controller\Actions\ExpenseActions;

use App\Repository\DepartmentRepository;
use App\Repository\ExpenseTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class ExpTypeControllerAction extends AbstractController
{
  public function __construct(private readonly ExpenseTypeRepository $repository) { }

  #[Route('/api/search_exp_types/{name}', methods: ['GET'])]
  public function onSearchDepartmentName($name): JsonResponse
  {
    $data = [];

    $provinces = $this->repository->findProvinceByName($name);
    if (count($provinces) > 0) {
      foreach ($provinces as $province) {
        $data[] = [
          'id' => $province->getId(),
          'name' => $province->getName(),
        ];
      }
    }

    return $this->json($data);
  }
}
