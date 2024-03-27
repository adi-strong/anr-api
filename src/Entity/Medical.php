<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\MedicalActions\AddNewMedicalAction;
use App\Repository\MedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewMedicalAction::class,
    ),
  ],
  normalizationContext: ['groups' => ['med:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Medical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'med:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'med:read',
    ])]
    private ?string $observation = null;

    #[ORM\OneToMany(targetEntity: MedicalFile::class, mappedBy: 'medical', cascade: ['persist', 'remove'])]
    #[Groups([
      'med:read',
    ])]
    private Collection $medicalFiles;

    public ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'medicals')]
    private ?Year $year = null;

    public function __construct()
    {
        $this->medicalFiles = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, MedicalFile>
     */
    public function getMedicalFiles(): Collection
    {
        return $this->medicalFiles;
    }

    public function addMedicalFile(MedicalFile $medicalFile): static
    {
        if (!$this->medicalFiles->contains($medicalFile)) {
            $this->medicalFiles->add($medicalFile);
            $medicalFile->setMedical($this);
        }

        return $this;
    }

    public function removeMedicalFile(MedicalFile $medicalFile): static
    {
        if ($this->medicalFiles->removeElement($medicalFile)) {
            // set the owning side to null (unless already changed)
            if ($medicalFile->getMedical() === $this) {
                $medicalFile->setMedical(null);
            }
        }

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
}
