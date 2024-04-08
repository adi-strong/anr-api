<?php

namespace App\Controller\Actions\PropertyActions;

use App\Entity\DocObject;
use App\Entity\PropertyAssignment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddPropertyAssignmentAction extends AbstractController
{
  public function __construct(private readonly EntityManagerInterface $em) { }

  public function __invoke(PropertyAssignment $assignment, Request $request): PropertyAssignment
  {
    $assignment->getProperty()?->setIsAvailable(false);

    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $docObject = new DocObject();
      $docObject->file = $uploadedFile;
      $assignment->setDocObject($docObject);
    }

    $assignment->setReleasedAt(new \DateTime());

    $this->em->flush();

    return $assignment;
  }
}
