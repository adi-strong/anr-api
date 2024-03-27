<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\SocietyActions\AddNewSocietyAction;
use App\Repository\SocietyRepository;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocietyRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewSocietyAction::class
    ),
  ],
  normalizationContext: ['groups' => ['society:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Society
{
  use IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'society:read',
      'province:read',
      'society_rec:read',
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
      'society:read',
      'province:read',
      'society_rec:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
      'society:read',
      'province:read',
      'society_rec:read',
    ])]
    private ?string $tradeName = null;

    #[ORM\ManyToOne(inversedBy: 'societies')]
    #[Assert\NotBlank(message: 'La Province doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'society:read',
    ])]
    private ?Province $province = null;

    /* ------------------------------------ ------------------------------------ */
    #[ORM\OneToOne(inversedBy: 'society', cascade: ['persist', 'remove'])]
    #[Groups([
      'society:read',
      'province:read',
    ])]
    private ?DocObject $rccm = null;

    public ?File $rccmFile = null;
  /* ------------------------------------ ------------------------------------ */

    #[ORM\ManyToOne(inversedBy: 'societies')]
    #[Assert\NotBlank(message: 'Le Type doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'society:read',
      'province:read',
    ])]
    private ?SocietyType $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[ORM\OneToMany(targetEntity: SocietyRecovery::class, mappedBy: 'society')]
    private Collection $societyRecoveries;

    public function __construct()
    {
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

    public function getTradeName(): ?string
    {
        return $this->tradeName;
    }

    public function setTradeName(?string $tradeName): static
    {
        $this->tradeName = $tradeName;

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

    public function getRccm(): ?DocObject
    {
        return $this->rccm;
    }

    public function setRccm(?DocObject $rccm): static
    {
        $this->rccm = $rccm;

        return $this;
    }

    public function getType(): ?SocietyType
    {
        return $this->type;
    }

    public function setType(?SocietyType $type): static
    {
        $this->type = $type;

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
            $societyRecovery->setSociety($this);
        }

        return $this;
    }

    public function removeSocietyRecovery(SocietyRecovery $societyRecovery): static
    {
        if ($this->societyRecoveries->removeElement($societyRecovery)) {
            // set the owning side to null (unless already changed)
            if ($societyRecovery->getSociety() === $this) {
                $societyRecovery->setSociety(null);
            }
        }

        return $this;
    }
}
