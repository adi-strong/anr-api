<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\FuelSupplyRepository;
use App\Traits\CreatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FuelSupplyRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['f_supply:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class FuelSupply
{
  use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'f_supply:read',
    ])]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: FuelStockSupply::class, mappedBy: 'supply')]
    private Collection $fuelStockSupplies;

    public function __construct()
    {
        $this->fuelStockSupplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $fuelStockSupply->setSupply($this);
        }

        return $this;
    }

    public function removeFuelStockSupply(FuelStockSupply $fuelStockSupply): static
    {
        if ($this->fuelStockSupplies->removeElement($fuelStockSupply)) {
            // set the owning side to null (unless already changed)
            if ($fuelStockSupply->getSupply() === $this) {
                $fuelStockSupply->setSupply(null);
            }
        }

        return $this;
    }
}
