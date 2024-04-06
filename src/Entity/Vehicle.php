<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\VehicleActions\AddNewVehicleAction;
use App\Repository\VehicleRepository;
use App\Traits\CreatedAtTrait;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Faker\Core\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewVehicleAction::class
    ),
  ],
  normalizationContext: ['groups' => ['vehicle:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['brand' => 'ipartial'])]
class Vehicle
{
  use IsDeletedTrait, CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'vehicle:read',
      'refueling:read',
      'v_ass:read',
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
      'vehicle:read',
      'refueling:read',
      'v_ass:read',
    ])]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'vehicle:read',
      'refueling:read',
      'v_ass:read',
    ])]
    private ?string $chassis = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'vehicle:read',
      'refueling:read',
      'v_ass:read',
    ])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le N° d\'Immatriculation doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'vehicle:read',
      'refueling:read',
      'v_ass:read',
    ])]
    private ?string $numberplate = null;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?DocObject $certificate = null;

    public ?File $certificateFile = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[Assert\NotBlank(message: 'Le Type doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'vehicle:read',
      'v_ass:read',
    ])]
    private ?VehicleType $type = null;

    #[ORM\OneToOne(inversedBy: 'vehicle')]
    #[Groups([
      'vehicle:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\OneToMany(targetEntity: VehicleAssignment::class, mappedBy: 'vehicle')]
    #[Groups([
      'vehicle:read',
    ])]
    private Collection $vehicleAssignments;

    #[ORM\OneToMany(targetEntity: Refueling::class, mappedBy: 'vehicle')]
    private Collection $refuelings;

    public function __construct()
    {
        $this->vehicleAssignments = new ArrayCollection();
        $this->refuelings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getChassis(): ?string
    {
        return $this->chassis;
    }

    public function setChassis(?string $chassis): static
    {
        $this->chassis = $chassis;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): static
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getCertificate(): ?DocObject
    {
        return $this->certificate;
    }

    public function setCertificate(?DocObject $certificate): static
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getType(): ?VehicleType
    {
        return $this->type;
    }

    public function setType(?VehicleType $type): static
    {
        $this->type = $type;

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
            $vehicleAssignment->setVehicle($this);
        }

        return $this;
    }

    public function removeVehicleAssignment(VehicleAssignment $vehicleAssignment): static
    {
        if ($this->vehicleAssignments->removeElement($vehicleAssignment)) {
            // set the owning side to null (unless already changed)
            if ($vehicleAssignment->getVehicle() === $this) {
                $vehicleAssignment->setVehicle(null);
            }
        }

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
            $refueling->setVehicle($this);
        }

        return $this;
    }

    public function removeRefueling(Refueling $refueling): static
    {
        if ($this->refuelings->removeElement($refueling)) {
            // set the owning side to null (unless already changed)
            if ($refueling->getVehicle() === $this) {
                $refueling->setVehicle(null);
            }
        }

        return $this;
    }
}
