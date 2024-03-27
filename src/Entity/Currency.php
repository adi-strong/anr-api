<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\YearActions\AddNewYearAction;
use App\Controller\Actions\YearActions\EditYearAction;
use App\Repository\CurrencyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Patch(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['currency:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'currency:read',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
      'currency:read',
    ])]
    private array $first = [];

    #[ORM\Column]
    #[Groups([
      'currency:read',
    ])]
    private array $last = [];

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups([
      'currency:read',
    ])]
    private ?string $rate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirst(): array
    {
        return $this->first;
    }

    public function setFirst(array $first): static
    {
        $this->first = $first;

        return $this;
    }

    public function getLast(): array
    {
        return $this->last;
    }

    public function setLast(array $last): static
    {
        $this->last = $last;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): static
    {
        $this->rate = $rate;

        return $this;
    }
}
