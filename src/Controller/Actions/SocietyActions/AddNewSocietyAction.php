<?php

namespace App\Controller\Actions\SocietyActions;

use App\Entity\DocObject;
use App\Entity\Society;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewSocietyAction extends AbstractController
{
  public function __invoke(Society $society, Request $request): Society
  {
    $uploadedRccmFile = $request->files->get('rccmFile');
    if (!$uploadedRccmFile) {
      throw new BadRequestHttpException('Le fichier est requis.');
    }
    $rccmObject = new DocObject();
    $rccmObject->file = $uploadedRccmFile;
    $society->setRccm($rccmObject);

    return $society;
  }
}
