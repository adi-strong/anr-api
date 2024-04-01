<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\AssignmentActions\AddNewAssignmentAction;
use App\Repository\AssignmentRepository;
use App\Traits\CreatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Delete(),
    new Post(controller: AddNewAssignmentAction::class),
  ],
  normalizationContext: ['groups' => ['assignment:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Assignment
{
  use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?bool $isActive = true;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[Groups(['assignment:read', 'agent:read'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Department $origin = null;

    #[ORM\ManyToOne(inversedBy: 'assignmentDestinations')]
    #[Assert\NotBlank(message: 'La Destination doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?Department $destination = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups(['assignment:read'])]
    private ?Agent $agent = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?array $paths = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    private ?Year $year = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups(['assignment:read', 'agent:read'])]
    private ?Province $province = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getOrigin(): ?Department
    {
        return $this->origin;
    }

    public function setOrigin(?Department $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestination(): ?Department
    {
        return $this->destination;
    }

    public function setDestination(?Department $destination): static
    {
        $this->destination = $destination;

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

    public function getPaths(): ?array
    {
        return $this->paths;
    }

    public function setPaths(?array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }

  #[ORM\PrePersist]
  public function onPersist(): void
  {
    $this->setCreatedAt(new \DateTime());
  }

  public function getYear(): ?Year
  {
      return $this->year;
  }

  public function setYear(?Year $year): static
  {
      $this->year = $year;

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
}
