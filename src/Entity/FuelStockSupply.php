<?php

namespace App\Entity;

use App\Repository\FuelStockSupplyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FuelStockSupplyRepository::class)]
class FuelStockSupply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'f_supply:read',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La Quantité doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'f_supply:read',
    ])]
    private ?float $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'fuelStockSupplies')]
    #[Assert\NotBlank(message: 'Le carburant est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'f_supply:read',
    ])]
    private ?Fuel $fuel = null;

    #[ORM\ManyToOne(inversedBy: 'fuelStockSupplies')]
    #[Assert\NotBlank(message: 'Le Document d\'approvisionnement est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    private ?FuelSupply $supply = null;

    #[ORM\ManyToOne(inversedBy: 'fuelStockSupplies')]
    #[Groups([
      'f_supply:read',
    ])]
    private ?FuelSite $site = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFuel(): ?Fuel
    {
        return $this->fuel;
    }

    public function setFuel(?Fuel $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getSupply(): ?FuelSupply
    {
        return $this->supply;
    }

    public function setSupply(?FuelSupply $supply): static
    {
        $this->supply = $supply;

        return $this;
    }

    public function getSite(): ?FuelSite
    {
        return $this->site;
    }

    public function setSite(?FuelSite $site): static
    {
        $this->site = $site;

        return $this;
    }
}
