<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\VehicleActions\AddVehicleAssignment;
use App\Repository\VehicleAssignmentRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\ReleasedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleAssignmentRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddVehicleAssignment::class
    ),
  ],
  normalizationContext: ['groups' => ['v_ass:read']],
  forceEager: false
)]
class VehicleAssignment
{
  use ReleasedAtTrait, IsDeletedTrait;

  public ?File $file = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?string $comment = null;

    #[ORM\OneToOne(inversedBy: 'agent', cascade: ['persist', 'remove'])]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?DocObject $docObject = null;

    #[ORM\ManyToOne(inversedBy: 'vehicleAssignments')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\ManyToOne(inversedBy: 'vehicleAssignments')]
    #[Assert\NotBlank(message: 'Le Véhicule doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'v_ass:read',
    ])]
    private ?Vehicle $vehicle = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?\DateTimeInterface $endAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDocObject(): ?DocObject
    {
        return $this->docObject;
    }

    public function setDocObject(?DocObject $docObject): static
    {
        $this->docObject = $docObject;

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

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }
}
