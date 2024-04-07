<?php

namespace App\Controller\Actions\UserActions;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
final class CreateNewUserAction extends AbstractController
{
  public function __construct(
    private readonly UserPasswordHasherInterface $encoder,
    private readonly Security $security
  ) { }

  public function __invoke(User $user): User
  {
    $password = $this->encoder->hashPassword($user, $user->getPassword());

    $user
      ->setPassword($password)
      ->setCreatedAt(new \DateTime())
      ->setAuthor($this->security->getUser());

    return $user;
  }
}
