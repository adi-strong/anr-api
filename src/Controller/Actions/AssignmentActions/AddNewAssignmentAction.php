<?php

namespace App\Controller\Actions\AssignmentActions;

use App\Entity\Assignment;
use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewAssignmentAction extends AbstractController
{
  public function __construct(private readonly YearRepository $yearRepository) { }

  public function __invoke(Assignment $assignment): Assignment
  {
    $lastSession = $this->yearRepository->findLastYear();
    if (null !== $lastSession && $lastSession->isIsActive() === true) {
      $assignment->setYear($lastSession);
    }
    else throw new BadRequestHttpException('year: Aucune année en cours.');

    return $assignment;
  }
}
