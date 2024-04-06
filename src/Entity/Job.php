<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\JobRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\SlugTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['job:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Job
{
  use SlugTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'job:read',
      'serv:read',
      'dep:read',
      'agent:read',
      'assignment:read',
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La Fonction doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'job:read',
      'serv:read',
      'dep:read',
      'agent:read',
      'assignment:read',
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?DepartmentService $service = null;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'job')]
    private Collection $agents;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
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

    public function getService(): ?DepartmentService
    {
        return $this->service;
    }

    public function setService(?DepartmentService $service): static
    {
        $this->service = $service;

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
          $agent->setJob($this);
      }

      return $this;
  }

  public function removeAgent(Agent $agent): static
  {
      if ($this->agents->removeElement($agent)) {
          // set the owning side to null (unless already changed)
          if ($agent->getJob() === $this) {
              $agent->setJob(null);
          }
      }

      return $this;
  }
}
