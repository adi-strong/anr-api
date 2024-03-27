<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\ExpenseActions\AddExpenseAction;
use App\Repository\ExpenseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpenseRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Delete(),
    new Post(controller: AddExpenseAction::class),
  ],
  normalizationContext: ['groups' => ['exp:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Expense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'exp:read',
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
      'exp:read',
      'agent:read',
    ])]
    private ?string $object = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le Porteur doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private ?string $bearer = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Les dépenses doivent être renseignées.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private array $operations = [];

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6)]
    #[Assert\NotBlank(message: 'Le Montant total doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private ?string $total = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La devise doivent être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private array $currency = [];

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank(message: 'Le taux doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private ?string $rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
      'exp:read',
      'agent:read',
    ])]
    private ?\DateTimeInterface $releasedAt = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[Groups([
      'exp:read',
    ])]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'expense')]
    private ?Mission $mission = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    private ?Year $year = null;

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

    public function getBearer(): ?string
    {
        return $this->bearer;
    }

    public function setBearer(string $bearer): static
    {
        $this->bearer = $bearer;

        return $this;
    }

    public function getOperations(): array
    {
        return $this->operations;
    }

    public function setOperations(array $operations): static
    {
        $this->operations = $operations;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getCurrency(): array
    {
        return $this->currency;
    }

    public function setCurrency(array $currency): static
    {
        $this->currency = $currency;

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

    public function getReleasedAt(): ?\DateTimeInterface
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(?\DateTimeInterface $releasedAt): static
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): static
    {
        // unset the owning side of the relation if necessary
        if ($mission === null && $this->mission !== null) {
            $this->mission->setExpense(null);
        }

        // set the owning side of the relation if necessary
        if ($mission !== null && $mission->getExpense() !== $this) {
            $mission->setExpense($this);
        }

        $this->mission = $mission;

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
