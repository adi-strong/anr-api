<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\SalaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalaryRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(),
  ],
  normalizationContext: ['groups' => ['salary:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class Salary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'salary:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6)]
    #[Assert\NotBlank(message: 'Le Montant de base est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'salary:read',
    ])]
    private ?string $baseAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    #[Groups([
      'salary:read',
    ])]
    private ?string $riskPremiumAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    #[Groups([
      'salary:read',
    ])]
    private ?string $functionBonusAmount = null;

    #[ORM\ManyToOne(inversedBy: 'salaries')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'salary:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\ManyToOne(inversedBy: 'salaries')]
    #[Assert\NotBlank(message: 'L\'Année doit être renseignée.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'salary:read',
    ])]
    private ?Year $year = null;

    #[ORM\Column(length: 2)]
    #[Assert\NotBlank(message: 'Le Mois doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Assert\Regex('#^\d+$#', message: 'Le Mois renseigné est invalide.')]
    #[Assert\Length(max: 2, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'salary:read',
    ])]
    private ?string $month = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseAmount(): ?string
    {
        return $this->baseAmount;
    }

    public function setBaseAmount(string $baseAmount): static
    {
        $this->baseAmount = $baseAmount;

        return $this;
    }

    public function getRiskPremiumAmount(): ?string
    {
        return $this->riskPremiumAmount;
    }

    public function setRiskPremiumAmount(?string $riskPremiumAmount): static
    {
        $this->riskPremiumAmount = $riskPremiumAmount;

        return $this;
    }

    public function getFunctionBonusAmount(): ?string
    {
        return $this->functionBonusAmount;
    }

    public function setFunctionBonusAmount(?string $functionBonusAmount): static
    {
        $this->functionBonusAmount = $functionBonusAmount;

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

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): static
    {
        $this->month = $month;

        return $this;
    }
}
