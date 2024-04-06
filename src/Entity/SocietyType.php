<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\SocietyTypeRepository;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocietyTypeRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['society_type:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class SocietyType
{
  use IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'society_type:read',
      'society:read',
      'province:read',
      'society_rec:read',
      'society:read',
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
      'society_type:read',
      'society:read',
      'province:read',
      'society_rec:read',
    ])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Society::class, mappedBy: 'type')]
    private Collection $societies;

    #[ORM\OneToMany(targetEntity: SocietyRecovery::class, mappedBy: 'type')]
    private Collection $societyRecoveries;

    public function __construct()
    {
        $this->societies = new ArrayCollection();
        $this->societyRecoveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Society>
     */
    public function getSocieties(): Collection
    {
        return $this->societies;
    }

    public function addSociety(Society $society): static
    {
        if (!$this->societies->contains($society)) {
            $this->societies->add($society);
            $society->setType($this);
        }

        return $this;
    }

    public function removeSociety(Society $society): static
    {
        if ($this->societies->removeElement($society)) {
            // set the owning side to null (unless already changed)
            if ($society->getType() === $this) {
                $society->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SocietyRecovery>
     */
    public function getSocietyRecoveries(): Collection
    {
        return $this->societyRecoveries;
    }

    public function addSocietyRecovery(SocietyRecovery $societyRecovery): static
    {
        if (!$this->societyRecoveries->contains($societyRecovery)) {
            $this->societyRecoveries->add($societyRecovery);
            $societyRecovery->setType($this);
        }

        return $this;
    }

    public function removeSocietyRecovery(SocietyRecovery $societyRecovery): static
    {
        if ($this->societyRecoveries->removeElement($societyRecovery)) {
            // set the owning side to null (unless already changed)
            if ($societyRecovery->getType() === $this) {
                $societyRecovery->setType(null);
            }
        }

        return $this;
    }
}
