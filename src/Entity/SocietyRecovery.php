<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\SocietyRecoveryActions\AddNewSocietyRecoveryAction;
use App\Repository\SocietyRecoveryRepository;
use App\Traits\ReleasedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocietyRecoveryRepository::class)]
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Delete(),
    new Patch(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: AddNewSocietyRecoveryAction::class
    ),
  ],
  normalizationContext: ['groups' => ['society_rec:read']],
  order: ['id' => 'desc'],
  forceEager: false
)]
class SocietyRecovery
{
  use ReleasedAtTrait, UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'societyRecoveries')]
    #[Assert\NotBlank(message: 'L\'Agent doit être renseigné.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'society_rec:read',
    ])]
    private ?Agent $agent = null;

    #[ORM\ManyToOne(inversedBy: 'societyRecoveries')]
    #[Assert\NotBlank(message: 'Ce champs est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?SocietyType $type = null;

    #[ORM\ManyToOne(inversedBy: 'societyRecoveries')]
    #[Assert\NotBlank(message: 'Ce champ est requis.')]
    #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?Society $society = null;

    #[ORM\OneToOne(inversedBy: 'societyRecovery', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $certificate = null;

    #[ORM\OneToOne(inversedBy: 'societyCalling', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $callingCard = null;

    #[ORM\OneToOne(inversedBy: 'societyPv', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $pv = null;

    #[ORM\OneToOne(inversedBy: 'societyForm', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $form = null;

    #[ORM\OneToOne(inversedBy: 'societyExpenseReport', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $expenseReport = null;

    #[ORM\OneToOne(inversedBy: 'societyProofOfPayment', cascade: ['persist', 'remove'])]
    #[Groups([
      'society_rec:read',
      'agent:read',
    ])]
    private ?DocObject $proofOfPayment = null;

  /* ------------------------------------ ------------------------------------ */

  public ?File $certificateFile = null;

  public ?File $callingCardFile = null;

  public ?File $pvFile = null;

  public ?File $formFile = null;

  public ?File $expenseReportFile = null;

  public ?File $proofOfPaymentFile = null;

  /* ------------------------------------ ------------------------------------ */

  #[ORM\ManyToOne(inversedBy: 'societyRecoveries')]
  #[Groups([
    'society_rec:read',
  ])]
  private ?Province $province = null;

  #[ORM\Column]
  #[Assert\NotBlank(message: 'Ce champs est requis.')]
  #[Assert\NotNull(message: 'Ce champ doit être renseigné.')]
  #[Groups([
    'society_rec:read',
  ])]
  private ?bool $isCompleted = false;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?SocietyType
    {
        return $this->type;
    }

    public function setType(?SocietyType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): static
    {
        $this->society = $society;

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

    public function getCallingCard(): ?DocObject
    {
        return $this->callingCard;
    }

    public function setCallingCard(?DocObject $callingCard): static
    {
        $this->callingCard = $callingCard;

        return $this;
    }

    public function getPv(): ?DocObject
    {
        return $this->pv;
    }

    public function setPv(?DocObject $pv): static
    {
        $this->pv = $pv;

        return $this;
    }

    public function getForm(): ?DocObject
    {
        return $this->form;
    }

    public function setForm(?DocObject $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function getExpenseReport(): ?DocObject
    {
        return $this->expenseReport;
    }

    public function setExpenseReport(?DocObject $expenseReport): static
    {
        $this->expenseReport = $expenseReport;

        return $this;
    }

    public function getProofOfPayment(): ?DocObject
    {
        return $this->proofOfPayment;
    }

    public function setProofOfPayment(?DocObject $proofOfPayment): static
    {
        $this->proofOfPayment = $proofOfPayment;

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

    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }
}
