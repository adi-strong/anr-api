<?php

namespace App\Controller\Actions\YearActions;

use App\Entity\Year;
use App\Repository\YearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class EditYearAction extends AbstractController
{
  public function __construct(
    private readonly YearRepository $repository,
    private readonly EntityManagerInterface $em
  ) { }

  public function __invoke(Year $year): Year
  {
    if ($year->isIsActive() === true) {
      $lastYear = $this->repository->findLastYear();
      if (null !== $lastYear && $lastYear->isIsActive() === true) {
        $lastYear->setIsActive(false);
      }
    }

    $this->em->flush();

    return $year;
  }
}
