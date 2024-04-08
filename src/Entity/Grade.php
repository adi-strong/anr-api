<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\GradeRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\SlugTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['grade:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\HasLifecycleCallbacks]
class Grade
{
  use SlugTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'grade:read',
      'dep:read',
      'agent:read',
      'dep:read',
      'assignment:read',
      'salary:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'property:read',
      'society:read',
      'user:read',
      'serv:read',
      'med:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La Désignation du grade doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'grade:read',
      'dep:read',
      'agent:read',
      'assignment:read',
      'salary:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'property:read',
      'society:read',
      'user:read',
      'serv:read',
      'med:read',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'grades')]
    #[Groups([
      'grade:read',
    ])]
    private ?Department $department = null;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'grade')]
    #[Groups([
      'grade:read',
      'agent:read',
    ])]
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
          $agent->setGrade($this);
      }

      return $this;
  }

  public function removeAgent(Agent $agent): static
  {
      if ($this->agents->removeElement($agent)) {
          // set the owning side to null (unless already changed)
          if ($agent->getGrade() === $this) {
              $agent->setGrade(null);
          }
      }

      return $this;
  }
}
