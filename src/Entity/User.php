<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\Traits\CreatedAtTrait;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['user:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity('email', message: 'Cette adresse Email est déjà prise.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  use CreatedAtTrait, IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'user:read',
      'exp:read',
      'agent:read',
      'mission:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Regex('#^[a-z]+(?:[._-][a-z]+)*$#', message: 'Username invalide.')]
    #[Assert\NotBlank(message: 'Le Username doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 180,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'user:read',
      'agent:read',
      'mission:read',
    ])]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups([
      'user:read',
    ])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le Mot de passe doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 4,
      max: 12,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'user:read',
    ])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Nom doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'user:read',
      'exp:read',
      'agent:read',
      'mission:read',
    ])]
    private ?string $fullName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email(message: 'Adresse Email invalide.')]
    #[Assert\NotBlank(message: 'Le Mot de passe doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(max: 255, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups(['user:read',])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex('#^\+?\d(?:[\s.-]?\d{2,3}){3,}$#', message: 'N° de Téléphone invalide.')]
    #[Assert\Length(max: 255, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups(['user:read',])]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read',])]
    private ?bool $isActive = true;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'users')]
    private ?self $author = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'author')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'user')]
    private Collection $expenses;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'user')]
    private Collection $agents;

    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'user')]
    private Collection $missions;

    #[ORM\OneToMany(targetEntity: MedicalFile::class, mappedBy: 'user')]
    private Collection $medicalFiles;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->medicalFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
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

    public function getAuthor(): ?self
    {
        return $this->author;
    }

    public function setAuthor(?self $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAuthor($this);
        }

        return $this;
    }

    public function removeUser(self $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAuthor() === $this) {
                $user->setAuthor(null);
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
            $expense->setUser($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getUser() === $this) {
                $expense->setUser(null);
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
            $agent->setUser($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): static
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getUser() === $this) {
                $agent->setUser(null);
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
            $mission->setUser($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getUser() === $this) {
                $mission->setUser(null);
            }
        }

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
            $medicalFile->setUser($this);
        }

        return $this;
    }

    public function removeMedicalFile(MedicalFile $medicalFile): static
    {
        if ($this->medicalFiles->removeElement($medicalFile)) {
            // set the owning side to null (unless already changed)
            if ($medicalFile->getUser() === $this) {
                $medicalFile->setUser(null);
            }
        }

        return $this;
    }
}
