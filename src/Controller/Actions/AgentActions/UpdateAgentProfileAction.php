<?php

namespace App\Controller\Actions\AgentActions;

use App\ApiResource\UpdateAgentProfileResource;
use App\Entity\ImageObject;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class UpdateAgentProfileAction extends AbstractController
{
  public function __construct(
    private readonly AgentRepository $repository,
    private readonly EntityManagerInterface $em
  ) { }

  public function __invoke(UpdateAgentProfileResource $resource, Request $request): JsonResponse
  {
    $data = [];
    $id = $resource->agentId;

    $agent = $this->repository->find($id);
    if (!$agent) throw new BadRequestHttpException("L'Agent avec l'ID : '".$id." n'existe pas.");

    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) throw new BadRequestHttpException('Le Fichier est requis.');

    $profile = $agent->getProfile();
    if (null !== $profile) {
      $profile->setAgent(null);
      $this->em->remove($profile);
    }

    $newProfile = new ImageObject();
    $newProfile->file = $uploadedFile;

    $agent->setProfile($newProfile);
    $this->em->flush();

    $data = [
      '@id' => '/api/profile/'.$agent->getProfile()->getId(),
      'contentUrl' => '/media/img/'.$agent->getProfile()->filePath
    ];

    return $this->json($data);
  }
}
