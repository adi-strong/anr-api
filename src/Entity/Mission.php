<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\MissionActions\AddNewMissionAction;
use App\Repository\MissionRepository;
use App\Traits\CreatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Delete(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewMissionAction::class
    ),
  ],
  normalizationContext: ['groups' => ['mission:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Mission
{
  use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'Objet doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $object = null;

    #[ORM\OneToOne(inversedBy: 'roadmap', cascade: ['persist', 'remove'])]

    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $roadmap = null;

    #[ORM\OneToOne(inversedBy: 'exitPermit', cascade: ['persist', 'remove'])]
    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $exitPermit = null;

    #[ORM\OneToOne(inversedBy: 'missionOrder', cascade: ['persist', 'remove'])]
    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $missionOrder = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Lieu de la mission doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $place = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: 'La Date de début doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: 'La Date de fin doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Moyen de transport doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $transport = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $transportName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $ticketNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $accommodation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $accommodationAddress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?string $observation = null;

    #[ORM\OneToOne(inversedBy: 'mission', cascade: ['persist', 'remove'])]
    #[Groups([
      'mission:read',
      'agent:read',
    ])]
    private ?Expense $expense = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'mission:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\ManyToMany(targetEntity: Agent::class, inversedBy: 'missionsMembers')]
    #[Groups([
      'mission:read',
    ])]
    private Collection $members;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[Groups([
      'mission:read',
    ])]
    private ?User $user = null;

    /*
    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $roadmap = null;

    #[ORM\OneToOne(inversedBy: 'exitPermit', cascade: ['persist', 'remove'])]
    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $exitPermit = null;

    #[ORM\OneToOne(inversedBy: 'missionOrder', cascade: ['persist', 'remove'])]
    #[Groups(['mission:read', 'agent:read'])]
    private ?DocObject $missionOrder = null;
    */

  /* --------------------------------------- FILES TO UPLOAD ----------------------------------------------- */

  public ?File $roadmapFile = null;

  public ?File $exitPermitFile = null;

  public ?File $missionOrderFile = null;
  /* --------------------------------------- END FILES TO UPLOAD ------------------------------------------- */

  #[ORM\ManyToOne(inversedBy: 'missions')]
  private ?Year $year = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): static
    {
        $this->object = $object;

        return $this;
    }

    public function getRoadmap(): ?DocObject
    {
        return $this->roadmap;
    }

    public function setRoadmap(?DocObject $roadmap): static
    {
        $this->roadmap = $roadmap;

        return $this;
    }

    public function getExitPermit(): ?DocObject
    {
        return $this->exitPermit;
    }

    public function setExitPermit(?DocObject $exitPermit): static
    {
        $this->exitPermit = $exitPermit;

        return $this;
    }

    public function getMissionOrder(): ?DocObject
    {
        return $this->missionOrder;
    }

    public function setMissionOrder(?DocObject $missionOrder): static
    {
        $this->missionOrder = $missionOrder;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getTransportName(): ?string
    {
        return $this->transportName;
    }

    public function setTransportName(?string $transportName): static
    {
        $this->transportName = $transportName;

        return $this;
    }

    public function getTicketNumber(): ?string
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(?string $ticketNumber): static
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    public function getAccommodation(): ?string
    {
        return $this->accommodation;
    }

    public function setAccommodation(?string $accommodation): static
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getAccommodationAddress(): ?string
    {
        return $this->accommodationAddress;
    }

    public function setAccommodationAddress(?string $accommodationAddress): static
    {
        $this->accommodationAddress = $accommodationAddress;

        return $this;
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

    public function getExpense(): ?Expense
    {
        return $this->expense;
    }

    public function setExpense(?Expense $expense): static
    {
        $this->expense = $expense;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Agent $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(Agent $member): static
    {
        $this->members->removeElement($member);

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
