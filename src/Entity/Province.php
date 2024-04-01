<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ProvinceRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\SlugTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['province:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
#[UniqueEntity('name', message: 'Ce nom de Province est déjà pris.')]
#[ORM\HasLifecycleCallbacks]
class Province
{
  use SlugTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'province:read',
      'agent:read',
      'property:read',
      'society:read',
      'society_rec:read',
      'assignment:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Le nom de la Province doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'province:read',
      'agent:read',
      'property:read',
      'society:read',
      'society_rec:read',
      'assignment:read',
    ])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'province')]
    #[Groups([
      'province:read',
    ])]
    private Collection $agents;

    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'province')]
    private Collection $assignments;

    #[ORM\OneToMany(targetEntity: Property::class, mappedBy: 'province')]
    private Collection $properties;

    #[ORM\OneToMany(targetEntity: Society::class, mappedBy: 'province')]
    #[Groups(['province:read',])]
    private Collection $societies;

    #[ORM\OneToMany(targetEntity: SocietyRecovery::class, mappedBy: 'province')]
    private Collection $societyRecoveries;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->assignments = new ArrayCollection();
        $this->properties = new ArrayCollection();
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

  #[ORM\PrePersist]
  public function onPersist(): void
  {
    $this->slug = (new Slugify())->slugify($this->getName());
  }

  #[ORM\PreUpdate]
  public function onUpdate(): void
  {
    $this->slug = (new Slugify())->slugify($this->getName());
  }

  /**
   * @return Collection<int, Agent>
   */
  public function getAgents(): Collection
  {
      return $this->agents;
  }

  public function addAgent(Agent $agent): static
  {
      if (!$this->agents->contains($agent)) {
          $this->agents->add($agent);
          $agent->setProvince($this);
      }

      return $this;
  }

  public function removeAgent(Agent $agent): static
  {
      if ($this->agents->removeElement($agent)) {
          // set the owning side to null (unless already changed)
          if ($agent->getProvince() === $this) {
              $agent->setProvince(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Assignment>
   */
  public function getAssignments(): Collection
  {
      return $this->assignments;
  }

  public function addAssignment(Assignment $assignment): static
  {
      if (!$this->assignments->contains($assignment)) {
          $this->assignments->add($assignment);
          $assignment->setProvince($this);
      }

      return $this;
  }

  public function removeAssignment(Assignment $assignment): static
  {
      if ($this->assignments->removeElement($assignment)) {
          // set the owning side to null (unless already changed)
          if ($assignment->getProvince() === $this) {
              $assignment->setProvince(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Property>
   */
  public function getProperties(): Collection
  {
      return $this->properties;
  }

  public function addProperty(Property $property): static
  {
      if (!$this->properties->contains($property)) {
          $this->properties->add($property);
          $property->setProvince($this);
      }

      return $this;
  }

  public function removeProperty(Property $property): static
  {
      if ($this->properties->removeElement($property)) {
          // set the owning side to null (unless already changed)
          if ($property->getProvince() === $this) {
              $property->setProvince(null);
          }
      }

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
          $society->setProvince($this);
      }

      return $this;
  }

  public function removeSociety(Society $society): static
  {
      if ($this->societies->removeElement($society)) {
          // set the owning side to null (unless already changed)
          if ($society->getProvince() === $this) {
              $society->setProvince(null);
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
          $societyRecovery->setProvince($this);
      }

      return $this;
  }

  public function removeSocietyRecovery(SocietyRecovery $societyRecovery): static
  {
      if ($this->societyRecoveries->removeElement($societyRecovery)) {
          // set the owning side to null (unless already changed)
          if ($societyRecovery->getProvince() === $this) {
              $societyRecovery->setProvince(null);
          }
      }

      return $this;
  }
}
