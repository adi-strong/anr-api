<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\MedicalActions\AddNewMedicalFileAction;
use App\Repository\MedicalFileRepository;
use App\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicalFileRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Delete(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewMedicalFileAction::class
    ),
  ]
)]
class MedicalFile
{
  use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'med:read',
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'medicalFiles')]
    #[Assert\NotBlank(message: 'La Fiche médicale est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    private ?Medical $medical = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'medicalFiles')]
    #[Groups([
      'med:read',
    ])]
    private ?DocObject $docObject = null;

    #[ORM\ManyToOne(inversedBy: 'medicalFiles')]
    private ?User $user = null;

    public ?File $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedical(): ?Medical
    {
        return $this->medical;
    }

    public function setMedical(?Medical $medical): static
    {
        $this->medical = $medical;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): static
    {
        $this->user = $user;

        return $this;
    }
}
