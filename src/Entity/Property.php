<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\PropertyActions\AddNewPropertyAction;
use App\Repository\PropertyRepository;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(controller: AddNewPropertyAction::class),
  ],
  normalizationContext: ['groups' => ['property:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Property
{
  use CreatedAtTrait, UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'property:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 6, nullable: true)]
    #[Assert\NotBlank(message: 'Le Code postal doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(max: 6, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'property:read',
    ])]
    private ?string $postalCode = null;

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
      'property:read',
    ])]
    private ?string $avenue = null;

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
      'property:read',
    ])]
    private ?string $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $quarter = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $commune = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La Surface du type doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'property:read',
    ])]
    private ?string $surface = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?int $pieces = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $price = '0';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'état doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'property:read',
    ])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[Groups([
      'property:read',
    ])]
    private ?PropertyType $type = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[Assert\NotBlank(message: 'La Province doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'property:read',
    ])]
    private ?Province $province = null;

    #[ORM\OneToOne(inversedBy: 'property')]
    #[Groups([
      'property:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?bool $isAvailable = false;

    #[ORM\OneToOne(inversedBy: 'property', cascade: ['persist', 'remove'])]
    #[Groups([
      'property:read',
    ])]
    private ?ImageObject $imageObject = null;

    public ?File $file = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $longitude = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'property:read',
    ])]
    private ?string $latitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAvenue(): ?string
    {
        return $this->avenue;
    }

    public function setAvenue(string $avenue): static
    {
        $this->avenue = $avenue;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getQuarter(): ?string
    {
        return $this->quarter;
    }

    public function setQuarter(?string $quarter): static
    {
        $this->quarter = $quarter;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(?int $pieces): static
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?PropertyType
    {
        return $this->type;
    }

    public function setType(?PropertyType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): static
    {
        $this->province = $province;

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

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getImageObject(): ?ImageObject
    {
        return $this->imageObject;
    }

    public function setImageObject(?ImageObject $imageObject): static
    {
        $this->imageObject = $imageObject;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }
}
