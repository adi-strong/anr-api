<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\FuelSiteRepository;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FuelSiteRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['f_site:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class FuelSite
{
  use IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'f_site:read',
      'f_supply:read',
      'refueling:read',
      'f_supply:read',
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
      'f_site:read',
      'f_supply:read',
      'refueling:read',
      'f_supply:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'f_site:read',
      'f_supply:read',
      'refueling:read',
    ])]
    private ?string $address = null;

    #[ORM\ManyToMany(targetEntity: Fuel::class, inversedBy: 'fuelSites')]
    #[Groups([
      'f_site:read',
    ])]
    private Collection $fuels;

    #[ORM\OneToOne(mappedBy: 'site')]
    private ?Refueling $refueling = null;

    #[ORM\OneToMany(targetEntity: FuelStockSupply::class, mappedBy: 'site')]
    private Collection $fuelStockSupplies;

    public function __construct()
    {
        $this->fuels = new ArrayCollection();
        $this->fuelStockSupplies = new ArrayCollection();
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
     * @return Collection<int, Fuel>
     */
    public function getFuels(): Collection
    {
        return $this->fuels;
    }

    public function addFuel(Fuel $fuel): static
    {
        if (!$this->fuels->contains($fuel)) {
            $this->fuels->add($fuel);
        }

        return $this;
    }

    public function removeFuel(Fuel $fuel): static
    {
        $this->fuels->removeElement($fuel);

        return $this;
    }

    public function getRefueling(): ?Refueling
    {
        return $this->refueling;
    }

    public function setRefueling(?Refueling $refueling): static
    {
        // unset the owning side of the relation if necessary
        if ($refueling === null && $this->refueling !== null) {
            $this->refueling->setSite(null);
        }

        // set the owning side of the relation if necessary
        if ($refueling !== null && $refueling->getSite() !== $this) {
            $refueling->setSite($this);
        }

        $this->refueling = $refueling;

        return $this;
    }

    /**
     * @return Collection<int, FuelStockSupply>
     */
    public function getFuelStockSupplies(): Collection
    {
        return $this->fuelStockSupplies;
    }

    public function addFuelStockSupply(FuelStockSupply $fuelStockSupply): static
    {
        if (!$this->fuelStockSupplies->contains($fuelStockSupply)) {
            $this->fuelStockSupplies->add($fuelStockSupply);
            $fuelStockSupply->setSite($this);
        }

        return $this;
    }

    public function removeFuelStockSupply(FuelStockSupply $fuelStockSupply): static
    {
        if ($this->fuelStockSupplies->removeElement($fuelStockSupply)) {
            // set the owning side to null (unless already changed)
            if ($fuelStockSupply->getSite() === $this) {
                $fuelStockSupply->setSite(null);
            }
        }

        return $this;
    }
}
