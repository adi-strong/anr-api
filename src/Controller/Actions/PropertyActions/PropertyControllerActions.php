<?php

namespace App\Controller\Actions\PropertyActions;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class PropertyControllerActions extends AbstractController
{
  public function __construct(private readonly PropertyRepository $repository) { }

  #[Route('/api/search_properties/{keyword}', methods: ['GET'])]
  public function getSearchProperty($keyword): JsonResponse
  {
    $data = [];

    $properties = $this->repository->findProperties($keyword);
    if (count($properties) > 0) {
      foreach ($properties as $property) {
        $data[] = [
          'id' => $property->getId(),

          'province' => $property->getProvince() !== null ? [
            'id' => $property->getProvince()->getId(),
            'name' => $property->getProvince()->getName(),
            'slug' => $property->getProvince()->getSlug(),
          ] : null,

          'type' => $property->getType() !== null ? [
            'id' => $property->getType()->getId(),
            'name' => $property->getType()->getName(),
          ] : null,

          'status' => $property->getStatus(),
          'surface' => $property->getSurface(),
          'pieces' => $property->getPieces(),
        ];
      }
    }

    return $this->json($data);
  }
}
