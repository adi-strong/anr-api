<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class JWTCreatedListener
{
  public function onJWTCreated(JWTCreatedEvent $event): void
  {
    $user = $event->getUser();
    $payload = $event->getData();

    $payload['id'] = $user->getId();
    $payload['username'] = $user->getUserIdentifier();
    $payload['fullName'] = $user->getFullName();
    $payload['roles'] = $user->getRoles();
    $payload['phone'] = $user->getPhone() ?? null;
    $payload['email'] = $user->getEmail();

    if ($user->isIsActive() === true) $event->setData($payload);
    else throw new BadRequestHttpException('Utilisateur non actif.');
  }
}
