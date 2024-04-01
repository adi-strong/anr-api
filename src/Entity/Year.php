<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\YearActions\AddNewYearAction;
use App\Controller\Actions\YearActions\EditYearAction;
use App\Repository\YearRepository;
use App\Traits\SlugTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: YearRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(controller: EditYearAction::class),
    new Post(controller: AddNewYearAction::class),
  ],
  normalizationContext: ['groups' => ['year:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
#[ORM\HasLifecycleCallbacks]
class Year
{
  use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'year:read',
      'salary:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La Désignation de l\'Année doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'year:read',
      'salary:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'year:read',
    ])]
    private ?bool $isActive = true;

    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'year')]
    private Collection $assignments;

    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'year')]
    private Collection $missions;

    #[ORM\OneToMany(targetEntity: Medical::class, mappedBy: 'year')]
    private Collection $medicals;

    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'year')]
    private Collection $expenses;

    #[ORM\OneToMany(targetEntity: Salary::class, mappedBy: 'year')]
    private Collection $salaries;

    public function __construct()
    {
        $this->assignments = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->medicals = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->salaries = new ArrayCollection();
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

  public function isIsActive(): ?bool
  {
      return $this->isActive;
  }

  public function setIsActive(?bool $isActive): static
  {
      $this->isActive = $isActive;

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
          $assignment->setYear($this);
      }

      return $this;
  }

  public function removeAssignment(Assignment $assignment): static
  {
      if ($this->assignments->removeElement($assignment)) {
          // set the owning side to null (unless already changed)
          if ($assignment->getYear() === $this) {
              $assignment->setYear(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Mission>
   */
  public function getMissions(): Collection
  {
      return $this->missions;
  }

  public function addMission(Mission $mission): static
  {
      if (!$this->missions->contains($mission)) {
          $this->missions->add($mission);
          $mission->setYear($this);
      }

      return $this;
  }

  public function removeMission(Mission $mission): static
  {
      if ($this->missions->removeElement($mission)) {
          // set the owning side to null (unless already changed)
          if ($mission->getYear() === $this) {
              $mission->setYear(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Medical>
   */
  public function getMedicals(): Collection
  {
      return $this->medicals;
  }

  public function addMedical(Medical $medical): static
  {
      if (!$this->medicals->contains($medical)) {
          $this->medicals->add($medical);
          $medical->setYear($this);
      }

      return $this;
  }

  public function removeMedical(Medical $medical): static
  {
      if ($this->medicals->removeElement($medical)) {
          // set the owning side to null (unless already changed)
          if ($medical->getYear() === $this) {
              $medical->setYear(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Expense>
   */
  public function getExpenses(): Collection
  {
      return $this->expenses;
  }

  public function addExpense(Expense $expense): static
  {
      if (!$this->expenses->contains($expense)) {
          $this->expenses->add($expense);
          $expense->setYear($this);
      }

      return $this;
  }

  public function removeExpense(Expense $expense): static
  {
      if ($this->expenses->removeElement($expense)) {
          // set the owning side to null (unless already changed)
          if ($expense->getYear() === $this) {
              $expense->setYear(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Salary>
   */
  public function getSalaries(): Collection
  {
      return $this->salaries;
  }

  public function addSalary(Salary $salary): static
  {
      if (!$this->salaries->contains($salary)) {
          $this->salaries->add($salary);
          $salary->setYear($this);
      }

      return $this;
  }

  public function removeSalary(Salary $salary): static
  {
      if ($this->salaries->removeElement($salary)) {
          // set the owning side to null (unless already changed)
          if ($salary->getYear() === $this) {
              $salary->setYear(null);
          }
      }

      return $this;
  }
}
