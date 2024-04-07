<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\SalaryActions\CreateSalaryResourceAction;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  operations: [
    new Post(controller: CreateSalaryResourceAction::class)
  ]
)]
class SalaryResource
{
  #[Assert\NotBlank(message: 'La Devise doit être renseignée.')]
  #[Assert\NotBlank(message: 'Ce champ doit être renseigné.')]
  public ?array $currency = null;

  #[Assert\NotBlank(message: 'L\'Année de paiement doit être renseignée.')]
  #[Assert\NotBlank(message: 'Ce champ doit être renseigné.')]
  public ?int $yearId = null;

  #[Assert\NotBlank(message: 'Le Mois de paiement doit être renseigné.')]
  #[Assert\NotBlank(message: 'Ce champ doit être renseigné.')]
  public ?string $month = null;

  #[Assert\NotBlank(message: 'Aucune élément détecté.')]
  #[Assert\NotBlank(message: 'Ce champ doit être renseigné.')]
  public ?array $items = [];
}
