<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\DepartmentServiceRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\SlugTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartmentServiceRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['serv:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class DepartmentService
{
  use SlugTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'serv:read',
      'dep:read',
      'job:read',
      'agent:read',
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Nom du service doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'serv:read',
      'dep:read',
      'job:read',
      'agent:read',
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'departmentServices')]
    #[Groups([
      'serv:read',
      'job:read',
    ])]
    private ?Department $department = null;

    #[ORM\OneToMany(targetEntity: Job::class, mappedBy: 'service')]
    #[Groups([
      'serv:read',
      'dep:read',
      'agent:read',
    ])]
    private Collection $jobs;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'service')]
    #[Groups([
      'serv:read',
      'dep:read',
    ])]
    private Collection $agents;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

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
   * @return Collection<int, Job>
   */
  public function getJobs(): Collection
  {
      return $this->jobs;
  }

  public function addJob(Job $job): static
  {
      if (!$this->jobs->contains($job)) {
          $this->jobs->add($job);
          $job->setService($this);
      }

      return $this;
  }

  public function removeJob(Job $job): static
  {
      if ($this->jobs->removeElement($job)) {
          // set the owning side to null (unless already changed)
          if ($job->getService() === $this) {
              $job->setService(null);
          }
      }

      return $this;
  }

  #[Groups([
    'serv:read',
    'dep:read',
  ])]
  public function getServiceJobs(): array
  {
    $data = [];
    $jobs = $this->getJobs();
    if ($jobs->count() > 0) {
      foreach ($jobs as $job) {
        if (false === $job->isIsDeleted()) {
          $data[] = [
            'id' => $job->getId(),
            'name' => $job->getName(),
            'slug' => $job->getSlug() ?? null,
          ];
        }
      }
    }

    return $data;
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
          $agent->setService($this);
      }

      return $this;
  }

  public function removeAgent(Agent $agent): static
  {
      if ($this->agents->removeElement($agent)) {
          // set the owning side to null (unless already changed)
          if ($agent->getService() === $this) {
              $agent->setService(null);
          }
      }

      return $this;
  }
}
