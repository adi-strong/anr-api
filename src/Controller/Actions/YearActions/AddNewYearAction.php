<?php

namespace App\Controller\Actions\YearActions;

use App\Entity\Year;
use App\Repository\YearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddNewYearAction extends AbstractController
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly YearRepository $repository,
  ) { }

  public function __invoke(Year $year): Year
  {
    $lastYear = $this->repository->findLastYear();

    if (null !== $lastYear && $lastYear->isIsActive() === true) {
      $lastYear->setIsActive(false);
    }

    $year->setIsActive(true);
    $this->em->flush();

    return $year;
  }
}
