<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\RefuelingRepository;
use App\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RefuelingRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['refueling:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Refueling
{
  use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'refueling:read',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'refueling:read',
    ])]
    private ?float $quantity = null;

    #[ORM\OneToOne(inversedBy: 'refueling')]
    #[Assert\NotBlank(message: 'Le Site doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'refueling:read',
    ])]
    private ?FuelSite $site = null;

    #[ORM\OneToOne(inversedBy: 'refueling')]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'refueling:read',
    ])]
    private ?Fuel $fuel = null;

    #[ORM\OneToOne(inversedBy: 'refueling')]
    #[Assert\NotBlank(message: 'Le Véhicule doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'refueling:read',
    ])]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToOne(inversedBy: 'refuelings')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'refueling:read',
    ])]
    private ?Agent $agent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSite(): ?FuelSite
    {
        return $this->site;
    }

    public function setSite(?FuelSite $site): static
    {
        $this->site = $site;

        return $this;
    }

    public function getFuel(): ?Fuel
    {
        return $this->fuel;
    }

    public function setFuel(?Fuel $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

  #[ORM\PrePersist]
  public function onPersist(): void
  {
    $this->setCreatedAt(new \DateTime());
  }
}
