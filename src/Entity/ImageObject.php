<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\Actions\MediaObjectActions\CreateImageObjectAction;
use App\Repository\DocObjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: DocObjectRepository::class)]
#[ApiResource(
  types: ['https://schema.org/ImageObject'],
  operations: [
    new Get(),
    new Delete(),
    new GetCollection(),
    new Post(
      controller: CreateImageObjectAction::class,
      openapi: new Model\Operation(
        requestBody: new Model\RequestBody(
          content: new \ArrayObject([
            'multipart/form-data' => [
              'schema' => [
                'type' => 'object',
                'properties' => [
                  'file' => [
                    'type' => 'string',
                    'format' => 'binary'
                  ]
                ]
              ]
            ]
          ])
        )
      ),
      validationContext: ['groups' => ['Default', 'image_object_create']],
      deserialize: false
    )
  ],
  normalizationContext: ['groups' => ['image_object:read']]
)]
class ImageObject
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ApiProperty(types: ['https://schema.org/contentUrl'])]
  #[Groups([
    'image_object:read',
    'property:read',
    'agent:read',
    'assignment:read',
    'salary:read',
    'vehicle:read',
    'v_ass:read',
    'society:read',
    'society_rec:read',
    'user:read',
    'serv:read',
    'grade:read',
  ])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: 'image_object', fileNameProperty: 'filePath')]
  #[Assert\NotNull(groups: ['image_object_create'])]
  public ?File $file = null;

  #[ORM\Column(nullable: true)]
  public ?string $filePath = null;

  #[ORM\OneToOne(mappedBy: 'profile')]
  private ?Agent $agent = null;

  #[ORM\OneToOne(mappedBy: 'imageObject')]
  private ?Property $property = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getAgent(): ?Agent
  {
      return $this->agent;
  }

  public function setAgent(?Agent $agent): static
  {
      // unset the owning side of the relation if necessary
      if ($agent === null && $this->agent !== null) {
          $this->agent->setProfile(null);
      }

      // set the owning side of the relation if necessary
      if ($agent !== null && $agent->getProfile() !== $this) {
          $agent->setProfile($this);
      }

      $this->agent = $agent;

      return $this;
  }

  public function getProperty(): ?Property
  {
      return $this->property;
  }

  public function setProperty(?Property $property): static
  {
      // unset the owning side of the relation if necessary
      if ($property === null && $this->property !== null) {
          $this->property->setImageObject(null);
      }

      // set the owning side of the relation if necessary
      if ($property !== null && $property->getImageObject() !== $this) {
          $property->setImageObject($this);
      }

      $this->property = $property;

      return $this;
  }
}
