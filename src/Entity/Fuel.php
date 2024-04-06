<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\FuelRepository;
use App\Traits\IsDeletedTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FuelRepository::class)]
#[ApiResource(
  operations: [
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['fuel:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Fuel
{
  use IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
    'fuel:read',
    'f_site:read',
    'f_supply:read',
      'refueling:read',
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
      'fuel:read',
      'f_site:read',
      'f_supply:read',
      'refueling:read',
    ])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'fuel:read',
      'f_site:read',
      'f_supply:read',
      'refueling:read',
    ])]
    private ?float $stock = 0;

    #[ORM\ManyToMany(targetEntity: FuelSite::class, mappedBy: 'fuels')]
    #[Groups(['f_supply:read'])]
    private Collection $fuelSites;

    #[ORM\OneToMany(targetEntity: FuelStockSupply::class, mappedBy: 'fuel')]
    private Collection $fuelStockSupplies;

    #[ORM\OneToMany(targetEntity: Refueling::class, mappedBy: 'fuel')]
    private Collection $refuelings;

    public function __construct()
    {
        $this->fuelSites = new ArrayCollection();
        $this->fuelStockSupplies = new ArrayCollection();
        $this->refuelings = new ArrayCollection();
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

    public function getStock(): ?float
    {
        return $this->stock;
    }

    public function setStock(?float $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, FuelSite>
     */
    public function getFuelSites(): Collection
    {
        return $this->fuelSites;
    }

    public function addFuelSite(FuelSite $fuelSite): static
    {
        if (!$this->fuelSites->contains($fuelSite)) {
            $this->fuelSites->add($fuelSite);
            $fuelSite->addFuel($this);
        }

        return $this;
    }

    public function removeFuelSite(FuelSite $fuelSite): static
    {
        if ($this->fuelSites->removeElement($fuelSite)) {
            $fuelSite->removeFuel($this);
        }

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
            $fuelStockSupply->setFuel($this);
        }

        return $this;
    }

    public function removeFuelStockSupply(FuelStockSupply $fuelStockSupply): static
    {
        if ($this->fuelStockSupplies->removeElement($fuelStockSupply)) {
            // set the owning side to null (unless already changed)
            if ($fuelStockSupply->getFuel() === $this) {
                $fuelStockSupply->setFuel(null);
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
            $refueling->setFuel($this);
        }

        return $this;
    }

    public function removeRefueling(Refueling $refueling): static
    {
        if ($this->refuelings->removeElement($refueling)) {
            // set the owning side to null (unless already changed)
            if ($refueling->getFuel() === $this) {
                $refueling->setFuel(null);
            }
        }

        return $this;
    }
}
