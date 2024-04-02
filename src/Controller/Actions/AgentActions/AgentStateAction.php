<?php

namespace App\Controller\Actions\AgentActions;

use App\ApiResource\AgentStateResource;
use App\Entity\AgentState;
use App\Entity\DocObject;
use App\Repository\AgentRepository;
use App\Repository\AgentStateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AgentStateAction extends AbstractController
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly AgentRepository $repository,
    private readonly AgentStateRepository $stateRepository
  ) { }

  public function __invoke(AgentStateResource $resource, Request $request): AgentStateResource
  {
    $agent = $this->repository->find($resource->agentId);
    if (!$agent) {
      throw new BadRequestHttpException('Agent ayant l\'ID : "'.$resource->agentId.'" n\'existe pas.');
    }

    $lastState = $this->stateRepository->findLastState();
    if (null !== $lastState) {
      $lastState->setIsActive(false);
    }

    $state = new AgentState();
    $uploadedFile = $request->files->get('file');
    if (null !== $uploadedFile) {
      $docObject = new DocObject();
      $docObject->file = $uploadedFile;
      $state->setDoc($docObject);
    }

    $startAt = $resource->startAt ?? null;
    $endAt = $resource->endAt ?? null;
    $state
      ->setAgent($agent)
      ->setEndAt($endAt)
      ->setStartAt($startAt)
      ->setState($resource->state);

    $this->em->persist($state);

    $agent->setState($resource->state);

    $this->em->flush();

    return $resource;
  }
}
