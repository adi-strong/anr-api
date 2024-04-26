<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class MediaObjectController extends AbstractController
{
  protected ?string $uploadDir = null;

  /**
   * @param string|null $uploadDir
   */
  public function __construct(?string $uploadDir)
  {
    $this->uploadDir = $uploadDir;
  }

  #[Route('/media/img/{fileName}', methods: ['GET'])]
  public function getImgFile($fileName): JsonResponse
  {;
    return $this->json($this->uploadDir.'/'.$fileName);
  }
}
