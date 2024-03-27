<?php

namespace App\Controller\Actions\ProvinceActions;

use App\Repository\ProvinceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ProvinceControllerAction extends AbstractController
{
  public function __construct(private readonly ProvinceRepository $repository) { }

  #[Route('/api/search_provinces/{name}', methods: ['GET'])]
  public function onSearchProvinceName($name): JsonResponse
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
