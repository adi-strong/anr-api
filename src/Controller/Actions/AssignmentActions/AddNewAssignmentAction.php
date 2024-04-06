<?php

namespace App\Controller\Actions\AssignmentActions;

use App\Entity\Assignment;
use App\Repository\YearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewAssignmentAction extends AbstractController
{
  public function __construct(
    private readonly YearRepository $yearRepository,
    private readonly EntityManagerInterface $em
  ) { }

  public function __invoke(Assignment $assignment): Assignment
  {
    $lastSession = $this->yearRepository->findLastYear();
    if (null !== $lastSession && $lastSession->isIsActive() === true) {
      $assignment->setYear($lastSession);
    }
    else throw new BadRequestHttpException('year: Aucune année en cours.');

    $destination = $assignment->getDestination();
    $paths = [];
    if (null !== $destination) {
      $paths = $destination->getPaths();
    }

    $agent = $assignment->getAgent();

    $assignment
      ->setPaths($paths)
      ->setOrigin($agent->getDepartment())
      ->setOriginProvince($agent->getProvince());

    $agent
      ->setProvince($assignment->getProvince())
      ->setDepartment($assignment->getDestination());

    $this->em->flush();

    return $assignment;
  }
}
