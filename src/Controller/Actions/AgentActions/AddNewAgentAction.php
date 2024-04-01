<?php

namespace App\Controller\Actions\AgentActions;

use App\Entity\Agent;
use App\Entity\ImageObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class AddNewAgentAction extends AbstractController
{
  public function __construct(
    private readonly Security $security
  ) { }

  public function __invoke(Agent $agent, Request $request): Agent
  {
    $state = $agent->getState() ?? 'active';
    $agent
      ->setState($state)
      ->setUser($this->security->getUser());

    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $imageObject = new ImageObject();
      $imageObject->file = $uploadedFile;
      $agent->setProfile($imageObject);
    }

    return $agent;
  }
}
