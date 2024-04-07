<?php

namespace App\Controller\Actions\UserActions;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class UpdateUserAction extends  AbstractController
{
  public function __invoke(User $user): User
  {
    $isDeleted = $user->isIsDeleted();
    if ($isDeleted === true) {
      $user->setAgentAccount(null);
    }

    return $user;
  }
}
