<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\AgentActions\AddNewAgentAction;
use App\Controller\Actions\AgentActions\DeleteAgentProfileAction;
use App\Repository\AgentRepository;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Patch(
      uriTemplate: '/agents/{id}/delete-profile',
      controller: DeleteAgentProfileAction::class
    ),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewAgentAction::class
    ),
  ],
  normalizationContext: ['groups' => ['agent:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Agent
{
  use IsDeletedTrait;

  public ?\DateTimeInterface $startAt = null;

  public ?\DateTimeInterface $endAt = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Nom du doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
      'user:read',
    ])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Matricule doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $register = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $cartNumber = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Pseudo doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $pseudo = null;

    #[ORM\Column(length: 1, nullable: true)]
    #[Assert\Choice(['H', 'F'], message: 'Sexe invalide.')]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $sex = null;

    #[ORM\Column(length: 8)]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Choice(['single', 'married'], message: 'État-civil invalide.')]
    #[Assert\Length(max: 8, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'society:read',
      'user:read',
    ])]
    private ?string $maritalStatus = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'society:read',
      'user:read',
    ])]
    private ?\DateTimeInterface $bornAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(message: 'Adresse Email invalide.')]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'society:read',
      'user:read',
    ])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le N° de téléphone doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Regex('#^\+?\d(?:[\s.-]?\d{2,3}){3,}$#', message: 'N° de Téléphone invalide.')]
    #[Assert\Length(max: 255, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'Origine doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $origin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
    ])]
    private ?string $father = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
    ])]
    private ?string $mother = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $conjoint = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?array $children = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Groupe sanguin doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 1,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $blood = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Niveau d\'étude doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $levelOfStudies = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Parrain doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'dep:read',
      'serv:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $godFather = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Numéro de téléphone du parrain doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'agent:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $godFatherNum = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups([
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
    ])]
    private ?Grade $grade = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups([
      'agent:read',
      'vehicle:read',
      'v_ass:read',
      'user:read',
    ])]
    private ?Department $department = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups([
      'agent:read',
      'vehicle:read',
      'v_ass:read',
      'user:read',
      'grade:read',
    ])]
    private ?DepartmentService $service = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice([
      'active',
      'inactive',
      'suspended',
      'leave',
      'unavailable',
      'retired',
      'dead',
      'sick',
    ], message: 'État invalide.')]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
      'user:read',
    ])]
    private ?string $state = 'active';

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups([
      'agent:read',
      'assignment:read',
      'vehicle:read',
      'v_ass:read',
      'user:read',
    ])]
    private ?Job $job = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups([
      'agent:read',
    ])]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $missions;

    #[ORM\ManyToMany(targetEntity: Mission::class, mappedBy: 'members')]
    #[Groups(['agent:read'])]
    private Collection $missionsMembers;

    #[ORM\OneToOne(inversedBy: 'agent', cascade: ['persist', 'remove'])]
    #[Groups([
      'agent:read',
      'assignment:read',
      'salary:read',
      'vehicle:read',
      'v_ass:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'property:read',
      'society:read',
      'user:read',
      'serv:read',
      'grade:read',
    ])]
    private ?ImageObject $profile = null;

    #[ORM\OneToMany(targetEntity: Folder::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $folders;

    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $assignments;

    #[ORM\OneToMany(targetEntity: Salary::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $salaries;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Assert\NotBlank(message: 'La Province doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups(['agent:read'])]
    private ?Province $province = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'agent:read',
      'grade:read',
      'dep:read',
      'serv:read',
      'mission:read',
      'assignment:read',
      'province:read',
      'salary:read',
      'property:read',
      'refueling:read',
      'society_rec:read',
      'vehicle:read',
      'v_ass:read',
      'p_ass:read',
      'society:read',
    ])]
    private ?string $conjointOrigin = null;

    #[ORM\OneToOne(mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private ?Property $property = null;

    #[ORM\OneToMany(targetEntity: Refueling::class, mappedBy: 'agent')]
    private Collection $refuelings;

    #[ORM\OneToMany(targetEntity: SocietyRecovery::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $societyRecoveries;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['agent:read'])]
    private ?string $bornPlace = null;

    public ?File $file = null;

    #[ORM\OneToMany(targetEntity: Medical::class, mappedBy: 'agent')]
    #[Groups([
      'folder:read',
      'agent:read',
    ])]
    private Collection $medicals;

    #[ORM\OneToMany(targetEntity: AgentState::class, mappedBy: 'agent')]
    private Collection $agentStates;

    #[ORM\OneToOne(mappedBy: 'agent')]
    private ?Vehicle $vehicle = null;

    #[ORM\OneToMany(targetEntity: VehicleAssignment::class, mappedBy: 'agent')]
    private Collection $vehicleAssignments;

    #[ORM\OneToMany(targetEntity: PropertyAssignment::class, mappedBy: 'agent')]
    private Collection $propertyAssignments;

    #[ORM\OneToOne(mappedBy: 'agentAccount')]
    #[Groups([
      'agent:read',
    ])]
    private ?User $account = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'agent:read',
      'user:read',
    ])]
    private ?string $address = null;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->missionsMembers = new ArrayCollection();
        $this->folders = new ArrayCollection();
        $this->assignments = new ArrayCollection();
        $this->salaries = new ArrayCollection();
        $this->refuelings = new ArrayCollection();
        $this->societyRecoveries = new ArrayCollection();
        $this->medicals = new ArrayCollection();
        $this->agentStates = new ArrayCollection();
        $this->vehicleAssignments = new ArrayCollection();
        $this->propertyAssignments = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getRegister(): ?string
    {
        return $this->register;
    }

    public function setRegister(string $register): static
    {
        $this->register = $register;

        return $this;
    }

    public function getCartNumber(): ?string
    {
        return $this->cartNumber;
    }

    public function setCartNumber(?string $cartNumber): static
    {
        $this->cartNumber = $cartNumber;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(?string $maritalStatus): static
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getBornAt(): ?\DateTimeInterface
    {
        return $this->bornAt;
    }

    public function setBornAt(?\DateTimeInterface $bornAt): static
    {
        $this->bornAt = $bornAt;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getFather(): ?string
    {
        return $this->father;
    }

    public function setFather(?string $father): static
    {
        $this->father = $father;

        return $this;
    }

    public function getMother(): ?string
    {
        return $this->mother;
    }

    public function setMother(?string $mother): static
    {
        $this->mother = $mother;

        return $this;
    }

    public function getConjoint(): ?string
    {
        return $this->conjoint;
    }

    public function setConjoint(?string $conjoint): static
    {
        $this->conjoint = $conjoint;

        return $this;
    }

    public function getChildren(): ?array
    {
        return $this->children;
    }

    public function setChildren(?array $children): static
    {
        $this->children = $children;

        return $this;
    }

    public function getBlood(): ?string
    {
        return $this->blood;
    }

    public function setBlood(string $blood): static
    {
        $this->blood = $blood;

        return $this;
    }

    public function getLevelOfStudies(): ?string
    {
        return $this->levelOfStudies;
    }

    public function setLevelOfStudies(string $levelOfStudies): static
    {
        $this->levelOfStudies = $levelOfStudies;

        return $this;
    }

    public function getGodFatherNum(): ?string
    {
        return $this->godFatherNum;
    }

    public function setGodFatherNum(string $godFatherNum): static
    {
        $this->godFatherNum = $godFatherNum;

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): static
    {
        $this->grade = $grade;

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

    public function getService(): ?DepartmentService
    {
        return $this->service;
    }

    public function setService(?DepartmentService $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

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
            $mission->setAgent($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getAgent() === $this) {
                $mission->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissionsMembers(): Collection
    {
        return $this->missionsMembers;
    }

    public function addMissionsMember(Mission $missionsMember): static
    {
        if (!$this->missionsMembers->contains($missionsMember)) {
            $this->missionsMembers->add($missionsMember);
            $missionsMember->addMember($this);
        }

        return $this;
    }

    public function removeMissionsMember(Mission $missionsMember): static
    {
        if ($this->missionsMembers->removeElement($missionsMember)) {
            $missionsMember->removeMember($this);
        }

        return $this;
    }

    public function getProfile(): ?ImageObject
    {
        return $this->profile;
    }

    public function setProfile(?ImageObject $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, Folder>
     */
    public function getFolders(): Collection
    {
        return $this->folders;
    }

    public function addFolder(Folder $folder): static
    {
        if (!$this->folders->contains($folder)) {
            $this->folders->add($folder);
            $folder->setAgent($this);
        }

        return $this;
    }

    public function removeFolder(Folder $folder): static
    {
        if ($this->folders->removeElement($folder)) {
            // set the owning side to null (unless already changed)
            if ($folder->getAgent() === $this) {
                $folder->setAgent(null);
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
            $assignment->setAgent($this);
        }

        return $this;
    }

    public function removeAssignment(Assignment $assignment): static
    {
        if ($this->assignments->removeElement($assignment)) {
            // set the owning side to null (unless already changed)
            if ($assignment->getAgent() === $this) {
                $assignment->setAgent(null);
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
            $salary->setAgent($this);
        }

        return $this;
    }

    public function removeSalary(Salary $salary): static
    {
        if ($this->salaries->removeElement($salary)) {
            // set the owning side to null (unless already changed)
            if ($salary->getAgent() === $this) {
                $salary->setAgent(null);
            }
        }

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getConjointOrigin(): ?string
    {
        return $this->conjointOrigin;
    }

    public function setConjointOrigin(?string $conjointOrigin): static
    {
        $this->conjointOrigin = $conjointOrigin;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        // unset the owning side of the relation if necessary
        if ($property === null && $this->property !== null) {
            $this->property->setAgent(null);
        }

        // set the owning side of the relation if necessary
        if ($property !== null && $property->getAgent() !== $this) {
            $property->setAgent($this);
        }

        $this->property = $property;

        return $this;
    }

    /**
     * @return Collection<int, Refueling>
     */
    public function getRefuelings(): Collection
    {
        return $this->refuelings;
    }

    public function addRefueling(Refueling $refueling): static
    {
        if (!$this->refuelings->contains($refueling)) {
            $this->refuelings->add($refueling);
            $refueling->setAgent($this);
        }

        return $this;
    }

    public function removeRefueling(Refueling $refueling): static
    {
        if ($this->refuelings->removeElement($refueling)) {
            // set the owning side to null (unless already changed)
            if ($refueling->getAgent() === $this) {
                $refueling->setAgent(null);
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
            $societyRecovery->setAgent($this);
        }

        return $this;
    }

    public function removeSocietyRecovery(SocietyRecovery $societyRecovery): static
    {
        if ($this->societyRecoveries->removeElement($societyRecovery)) {
            // set the owning side to null (unless already changed)
            if ($societyRecovery->getAgent() === $this) {
                $societyRecovery->setAgent(null);
            }
        }

        return $this;
    }

    public function getBornPlace(): ?string
    {
        return $this->bornPlace;
    }

    public function setBornPlace(?string $bornPlace): static
    {
        $this->bornPlace = $bornPlace;

        return $this;
    }

    public function getGodFather(): ?string
    {
        return $this->godFather;
    }

    public function setGodFather(string $godFather): static
    {
        $this->godFather = $godFather;

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
            $medical->setAgent($this);
        }

        return $this;
    }

    public function removeMedical(Medical $medical): static
    {
        if ($this->medicals->removeElement($medical)) {
            // set the owning side to null (unless already changed)
            if ($medical->getAgent() === $this) {
                $medical->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AgentState>
     */
    public function getAgentStates(): Collection
    {
        return $this->agentStates;
    }

    public function addAgentState(AgentState $agentState): static
    {
        if (!$this->agentStates->contains($agentState)) {
            $this->agentStates->add($agentState);
            $agentState->setAgent($this);
        }

        return $this;
    }

    public function removeAgentState(AgentState $agentState): static
    {
        if ($this->agentStates->removeElement($agentState)) {
            // set the owning side to null (unless already changed)
            if ($agentState->getAgent() === $this) {
                $agentState->setAgent(null);
            }
        }

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        // unset the owning side of the relation if necessary
        if ($vehicle === null && $this->vehicle !== null) {
            $this->vehicle->setAgent(null);
        }

        // set the owning side of the relation if necessary
        if ($vehicle !== null && $vehicle->getAgent() !== $this) {
            $vehicle->setAgent($this);
        }

        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Collection<int, VehicleAssignment>
     */
    public function getVehicleAssignments(): Collection
    {
        return $this->vehicleAssignments;
    }

    public function addVehicleAssignment(VehicleAssignment $vehicleAssignment): static
    {
        if (!$this->vehicleAssignments->contains($vehicleAssignment)) {
            $this->vehicleAssignments->add($vehicleAssignment);
            $vehicleAssignment->setAgent($this);
        }

        return $this;
    }

    public function removeVehicleAssignment(VehicleAssignment $vehicleAssignment): static
    {
        if ($this->vehicleAssignments->removeElement($vehicleAssignment)) {
            // set the owning side to null (unless already changed)
            if ($vehicleAssignment->getAgent() === $this) {
                $vehicleAssignment->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PropertyAssignment>
     */
    public function getPropertyAssignments(): Collection
    {
        return $this->propertyAssignments;
    }

    public function addPropertyAssignment(PropertyAssignment $propertyAssignment): static
    {
        if (!$this->propertyAssignments->contains($propertyAssignment)) {
            $this->propertyAssignments->add($propertyAssignment);
            $propertyAssignment->setAgent($this);
        }

        return $this;
    }

    public function removePropertyAssignment(PropertyAssignment $propertyAssignment): static
    {
        if ($this->propertyAssignments->removeElement($propertyAssignment)) {
            // set the owning side to null (unless already changed)
            if ($propertyAssignment->getAgent() === $this) {
                $propertyAssignment->setAgent(null);
            }
        }

        return $this;
    }

    public function getAccount(): ?User
    {
        return $this->account;
    }

    public function setAccount(?User $account): static
    {
        // unset the owning side of the relation if necessary
        if ($account === null && $this->account !== null) {
            $this->account->setAgentAccount(null);
        }

        // set the owning side of the relation if necessary
        if ($account !== null && $account->getAgentAccount() !== $this) {
            $account->setAgentAccount($this);
        }

        $this->account = $account;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
