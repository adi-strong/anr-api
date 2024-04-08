<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\MedicalActions\AddNewMedicalAction;
use App\Repository\MedicalRepository;
use App\Traits\ReleasedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MedicalRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Delete(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewMedicalAction::class,
    ),
  ],
  normalizationContext: ['groups' => ['med:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Medical
{
  use ReleasedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'med:read',
      'agent:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'med:read',
      'agent:read',
    ])]
    private ?string $observation = null;

    public ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'medicals')]
    #[Groups([
      'med:read',
      'agent:read',
    ])]
    private ?Year $year = null;

    #[ORM\OneToOne(inversedBy: 'medical', cascade: ['persist', 'remove'])]
    #[Groups([
      'med:read',
      'agent:read',
    ])]
    private ?DocObject $docObject = null;

    #[ORM\ManyToOne(inversedBy: 'medicals')]
    #[Groups([
      'med:read',
    ])]
    private ?Agent $agent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
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

    public function getDocObject(): ?DocObject
    {
        return $this->docObject;
    }

    public function setDocObject(?DocObject $docObject): static
    {
        $this->docObject = $docObject;

        return $this;
    }

  #[ORM\PrePersist]
  public function onPersist(): void
  {
    $this->setReleasedAt(new \DateTime());
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
}
