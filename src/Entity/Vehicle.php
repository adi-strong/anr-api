<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\VehicleActions\AddNewVehicleAction;
use App\Repository\VehicleRepository;
use App\Traits\CreatedAtTrait;
use App\Traits\IsDeletedTrait;
use Doctrine\ORM\Mapping as ORM;
use Faker\Core\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewVehicleAction::class
    ),
  ],
  normalizationContext: ['groups' => ['vehicle:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Vehicle
{
  use IsDeletedTrait, CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'vehicle:read',
      'refueling:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'vehicle:read',
      'refueling:read',
    ])]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'vehicle:read',
      'refueling:read',
    ])]
    private ?string $chassis = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'vehicle:read',
      'refueling:read',
    ])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le N° d\'Immatriculation doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'vehicle:read',
      'refueling:read',
    ])]
    private ?string $numberplate = null;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    #[Groups([
      'vehicle:read',
    ])]
    private ?DocObject $certificate = null;

    public ?File $certificateFile = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[Assert\NotBlank(message: 'Le Type doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'vehicle:read',
    ])]
    private ?VehicleType $type = null;

    #[ORM\OneToOne(mappedBy: 'vehicle')]
    private ?Refueling $refueling = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getChassis(): ?string
    {
        return $this->chassis;
    }

    public function setChassis(?string $chassis): static
    {
        $this->chassis = $chassis;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): static
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getCertificate(): ?DocObject
    {
        return $this->certificate;
    }

    public function setCertificate(?DocObject $certificate): static
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getType(): ?VehicleType
    {
        return $this->type;
    }

    public function setType(?VehicleType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRefueling(): ?Refueling
    {
        return $this->refueling;
    }

    public function setRefueling(?Refueling $refueling): static
    {
        // unset the owning side of the relation if necessary
        if ($refueling === null && $this->refueling !== null) {
            $this->refueling->setVehicle(null);
        }

        // set the owning side of the relation if necessary
        if ($refueling !== null && $refueling->getVehicle() !== $this) {
            $refueling->setVehicle($this);
        }

        $this->refueling = $refueling;

        return $this;
    }
}
