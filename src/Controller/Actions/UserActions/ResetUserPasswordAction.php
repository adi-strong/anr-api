<?php

namespace App\Controller\Actions\UserActions;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
final class ResetUserPasswordAction extends AbstractController
{
  public function __construct(private readonly UserPasswordHasherInterface $encoder) { }

  public function __invoke(User $user): User
  {
    $password = $this->encoder->hashPassword($user, $user->getPassword());
    $user->setPassword($password);

    return $user;
  }
}
