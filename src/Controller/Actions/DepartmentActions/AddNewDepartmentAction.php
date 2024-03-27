<?php

namespace App\Controller\Actions\DepartmentActions;

use App\Entity\Department;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddNewDepartmentAction extends AbstractController
{
  public function __invoke(Department $department): Department
  {
    $paths = [];
    $parent = $department->getParent();
    $slug = (new Slugify())->slugify($department->getName());

    if (!empty($parent)) {
      $paths = array_merge($parent->getPaths(), [[
        'id' => $parent->getId(),
        'name' => $parent->getName(),
        'slug' => $parent->getSlug() ?? null,
      ]]);
      $department->setIsSubDep(true);
    }

    $department
      ->setSlug($slug)
      ->setPaths($paths);

    return $department;
  }
}
