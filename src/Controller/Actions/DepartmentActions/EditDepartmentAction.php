<?php

namespace App\Controller\Actions\DepartmentActions;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class EditDepartmentAction extends AbstractController
{
  public function __construct(private readonly EntityManagerInterface $em) { }

  public function __invoke(Department $department): Department
  {
    $paths = [];
    $isDeleted = $department->isIsDeleted();
    $grades = $department->getGrades();

    if (true === $isDeleted) {
      $department
        ->setPaths($paths)
        ->setParent(null);

      if ($grades->count() > 0) {
        foreach ($grades as $grade) {
          $grade
            ->setIsDeleted(true)
            ->setDepartment(null);
        }
      }
    }

    $this->em->flush();
    return $department;
  }
}
