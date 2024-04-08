<?php

namespace App\Controller\Actions\UserActions;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class UserControllerAction extends AbstractController
{
  public function __construct(private readonly UserRepository $repository) { }

  #[Route('/api/get_count_users', methods: ['GET'])]
  public function getCountUsers(): JsonResponse
  {
    $countAll = $this->repository->countAllUsers();
    $countActives = $this->repository->countActiveUsers();

    $data = ['countAll' => $countAll, 'countActives' => $countActives];

    return $this->json($data);
  }

  //************************************************************************************

  #[Route('/api/search_users/{keyword}', methods: ['GET'])]
  public function getSearchUser($keyword): JsonResponse
  {
    $data = [];
    $users = $this->repository->findUsers($keyword);

    if (count($users) > 0) {
      foreach ($users as $user) {
        if ($user->isIsActive() === true && $user->isIsDeleted() === false) {
          $agent = $user->getAgentAccount();
          $data[] = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'fullName' => $user->getFullName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'isActive' => $user->isIsActive(),
            'roles' => $user->getRoles(),
            'agentAccount' => $agent ? [
              'id' => $agent->getId(),
              'name' => $agent->getName(),
              'lastName' => $agent->getLastName(),
              'firstName' => $agent->getFirstName(),
              'profile' => $agent->getProfile() ? [
                'contentUrl' => '/media/img/'.$agent->getProfile()->filePath
              ] : null,
            ] : null,
          ];
        }
      }
    }

    return $this->json($data);
  }
}
