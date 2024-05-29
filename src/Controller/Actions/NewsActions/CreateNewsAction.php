<?php

namespace App\Controller\Actions\NewsActions;

use App\Entity\ImageObject;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateNewsAction extends AbstractController
{
  public function __construct(private readonly Security $security) { }
  
  public function __invoke(News $data, Request $request): News
  {
    // Handle add pictures
    $files = $request->files->get('pictures');
    if (!empty($files)) {
      foreach ($files as $uploadedFile) {
        if ($uploadedFile instanceof UploadedFile) {
          $image = new ImageObject();
          $image->file = $uploadedFile; // Assume you have a setter for the file property
          $data->addImage($image);
        }
      }
    }
    else throw new BadRequestHttpException('Pictures are required.');
    // End Handle add pictures
    
    $data
      ->setReleasedAt(new \DateTime())
      ->setUser($this->security->getUser());
    
    return $data;
  }
}
