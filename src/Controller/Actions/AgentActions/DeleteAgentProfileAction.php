<?php

namespace App\Controller\Actions\AgentActions;

use App\Entity\Agent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class DeleteAgentProfileAction extends  AbstractController
{
  public function __construct(private readonly EntityManagerInterface $em) { }

  public function __invoke(Agent $agent): Agent
  {
    $profile = $agent->getProfile();
    if (null !== $profile) {
      $this->em->remove($agent->getProfile());
    }

    $agent->setProfile(null);
    $this->em->flush();

    return $agent;
  }
}
