<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\FolderActions\AddNewFolderAction;
use App\Repository\FolderRepository;
use App\Traits\ReleasedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Delete(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewFolderAction::class
    ),
  ],
  normalizationContext: ['groups' => ['folder:read']],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Folder
{
  use ReleasedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'folder:read',
      'agent:read',
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'folders')]
    #[Assert\NotBlank(message: 'Le Type de dossier doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'folder:read',
      'agent:read',
    ])]
    private ?FolderType $type = null;

    #[ORM\OneToOne(inversedBy: 'folder', cascade: ['persist', 'remove'])]
    #[Groups([
      'folder:read',
      'agent:read',
    ])]
    private ?DocObject $docObject = null;

    #[ORM\ManyToOne(inversedBy: 'folders')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups(['folder:read'])]
    private ?Agent $agent = null;

    public ?File $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?FolderType
    {
        return $this->type;
    }

    public function setType(?FolderType $type): static
    {
        $this->type = $type;

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

  #[ORM\PrePersist]
  public function onPersist(): void
  {
    $this->setReleasedAt(new \DateTime());
  }
}
