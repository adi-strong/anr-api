<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\DepartmentActions\AddNewDepartmentAction;
use App\Controller\Actions\DepartmentActions\EditDepartmentAction;
use App\Repository\DepartmentRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(controller: EditDepartmentAction::class),
    new Post(controller: AddNewDepartmentAction::class),
  ],
  normalizationContext: ['groups' => ['dep:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Department
{
  use SlugTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'dep:read',
      'serv:read',
      'grade:read',
      'job:read',
      'agent:read',
      'assignment:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Nom du département doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'dep:read',
      'serv:read',
      'grade:read',
      'job:read',
      'agent:read',
      'assignment:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'dep:read',
      'serv:read',
      'agent:read',
      'assignment:read',
    ])]
    private ?array $paths = [];

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'departments')]
    #[Groups([
      'dep:read',
    ])]
    private ?self $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[Groups([
      'dep:read',
    ])]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: DepartmentService::class, mappedBy: 'department')]
    #[Groups([
      'dep:read',
    ])]
    private Collection $departmentServices;

    #[ORM\Column(nullable: true)]
    #[Groups(['dep:read'])]
    private ?bool $isSubDep = false;

    #[ORM\OneToMany(targetEntity: Grade::class, mappedBy: 'department')]
    private Collection $grades;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'department')]
    #[Groups([
      'dep:read',
    ])]
    private Collection $agents;

    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'origin')]
    private Collection $assignments;

    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'destination')]
    private Collection $assignmentDestinations;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->departmentServices = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->assignments = new ArrayCollection();
        $this->assignmentDestinations = new ArrayCollection();
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

    public function getPaths(): ?array
    {
        return $this->paths;
    }

    public function setPaths(?array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(self $department): static
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setParent($this);
        }

        return $this;
    }

    public function removeDepartment(self $department): static
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getParent() === $this) {
                $department->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DepartmentService>
     */
    public function getDepartmentServices(): Collection
    {
        return $this->departmentServices;
    }

    public function addDepartmentService(DepartmentService $departmentService): static
    {
        if (!$this->departmentServices->contains($departmentService)) {
            $this->departmentServices->add($departmentService);
            $departmentService->setDepartment($this);
        }

        return $this;
    }

    public function removeDepartmentService(DepartmentService $departmentService): static
    {
        if ($this->departmentServices->removeElement($departmentService)) {
            // set the owning side to null (unless already changed)
            if ($departmentService->getDepartment() === $this) {
                $departmentService->setDepartment(null);
            }
        }

        return $this;
    }

  #[Groups(['serv:read',])]
  public function getDepartmentsServices(): ArrayCollection|Collection|array
  {
    return $this->departmentServices ?? [];
  }

  public function isIsSubDep(): ?bool
  {
      return $this->isSubDep;
  }

  public function setIsSubDep(?bool $isSubDep): static
  {
      $this->isSubDep = $isSubDep;

      return $this;
  }

  #[Groups(['dep:read', 'serv:read'])]
  public function getNbServices(): int
  {
    return $this->departmentServices->count();
  }


  #[Groups(['dep:read', 'serv:read', 'grade:read',])]
  public function getNbAgents(): int
  {
    return 0;
  }

  #[Groups(['dep:read', 'serv:read', 'grade:read',])]
  public function getServices(): array
  {
    $data = [];
    $services = $this->getDepartmentServices() ?? [];
    if ($services->count() > 0) {
      foreach ($services as $service) {
        if (false === $service->isIsDeleted()) {
          $data[] = [
            'id' => $service->getId(),
            'name' => $service->getName(),
            'slug' => $service->getSlug()
          ];
        }
      }
    }

    return $data;
  }

  #[Groups(['dep:read', 'serv:read', 'grade:read',])]
  public function getDeps(): array
  {
    $data = [];
    $departments = $this->getDepartments() ?? [];
    if ($departments->count() > 0) {
      foreach ($departments as $department) {
        $services = $department->getDepartmentServices();
        $totalServices = 0;

        foreach ($services as $service) {
          if (false === $service->isIsDeleted()) {
            $totalServices += 1;
          }
        }

        if (false === $department->isIsDeleted()) {
          $data[] = [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'slug' => $department->getSlug(),
            'nbServices' => $totalServices
          ];
        }
      }
    }

    return $data;
  }

  #[Groups(['dep:read', 'serv:read', 'grade:read',])]
  public function getDepGrades(): array
  {
    $data = [];
    $grades = $this->getGrades() ?? [];
    if ($grades->count() > 0) {
      foreach ($grades as $grade) {

        if (false === $grade->isIsDeleted()) {
          $data[] = [
            'id' => $grade->getId(),
            'name' => $grade->getName(),
            'slug' => $grade->getSlug(),
          ];
        }
      }
    }

    return $data;
  }

  /**
   * @return Collection<int, Grade>
   */
  public function getGrades(): Collection
  {
      return $this->grades;
  }

  public function addGrade(Grade $grade): static
  {
      if (!$this->grades->contains($grade)) {
          $this->grades->add($grade);
          $grade->setDepartment($this);
      }

      return $this;
  }

  public function removeGrade(Grade $grade): static
  {
      if ($this->grades->removeElement($grade)) {
          // set the owning side to null (unless already changed)
          if ($grade->getDepartment() === $this) {
              $grade->setDepartment(null);
          }
      }

      return $this;
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
          $agent->setDepartment($this);
      }

      return $this;
  }

  public function removeAgent(Agent $agent): static
  {
      if ($this->agents->removeElement($agent)) {
          // set the owning side to null (unless already changed)
          if ($agent->getDepartment() === $this) {
              $agent->setDepartment(null);
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
          $assignment->setOrigin($this);
      }

      return $this;
  }

  public function removeAssignment(Assignment $assignment): static
  {
      if ($this->assignments->removeElement($assignment)) {
          // set the owning side to null (unless already changed)
          if ($assignment->getOrigin() === $this) {
              $assignment->setOrigin(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Assignment>
   */
  public function getAssignmentDestinations(): Collection
  {
      return $this->assignmentDestinations;
  }

  public function addAssignmentDestination(Assignment $assignmentDestination): static
  {
      if (!$this->assignmentDestinations->contains($assignmentDestination)) {
          $this->assignmentDestinations->add($assignmentDestination);
          $assignmentDestination->setDestination($this);
      }

      return $this;
  }

  public function removeAssignmentDestination(Assignment $assignmentDestination): static
  {
      if ($this->assignmentDestinations->removeElement($assignmentDestination)) {
          // set the owning side to null (unless already changed)
          if ($assignmentDestination->getDestination() === $this) {
              $assignmentDestination->setDestination(null);
          }
      }

      return $this;
  }
}
