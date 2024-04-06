<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\Actions\MediaObjectActions\CreateDocObjectAction;
use App\Repository\DocObjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: DocObjectRepository::class)]
#[ApiResource(
  types: ['https://schema.org/DocObject'],
  operations: [
    new Get(),
    new Delete(),
    new GetCollection(),
    new Post(
      controller: CreateDocObjectAction::class,
      openapi: new Model\Operation(
        requestBody: new Model\RequestBody(
          content: new \ArrayObject([
            'multipart/form-data' => [
              'schema' => [
                'type' => 'object',
                'properties' => [
                  'file' => [
                    'type' => 'string',
                    'format' => 'binary'
                  ]
                ]
              ]
            ]
          ])
        )
      ),
      validationContext: ['groups' => ['Default', 'doc_object_create']],
      deserialize: false
    )
  ],
  normalizationContext: ['groups' => ['doc_object:read']]
)]
class DocObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

  #[ApiProperty(types: ['https://schema.org/contentUrl'])]
  #[Groups([
    'doc_object:read',
    'mission:read',
    'agent:read',
    'med:read',
    'society:read',
    'province:read',
    'vehicle:read',
    'v_ass:read',
    'p_ass:read',
    'property:read',
    'society:read',
    'society_rec:read',
  ])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: 'doc_object', fileNameProperty: 'filePath')]
  #[Assert\NotNull(groups: ['doc_object_create'])]
  public ?File $file = null;

  #[ORM\Column(nullable: true)]
  public ?string $filePath = null;

  #[ORM\OneToOne(mappedBy: 'roadmap')]
  private ?Mission $roadmap = null;

  #[ORM\OneToOne(mappedBy: 'exitPermit')]
  private ?Mission $exitPermit = null;

  #[ORM\OneToOne(mappedBy: 'missionOrder')]
  private ?Mission $missionOrder = null;

  #[ORM\OneToOne(mappedBy: 'docObject')]
  private ?Folder $folder = null;

  #[ORM\OneToOne(mappedBy: 'certificate')]
  private ?Vehicle $vehicle = null;

  #[ORM\OneToOne(mappedBy: 'rccm')]
  private ?Society $society = null;

  #[ORM\OneToOne(mappedBy: 'certificate')]
  private ?SocietyRecovery $societyRecovery = null;

  #[ORM\OneToOne(mappedBy: 'callingCard')]
  private ?SocietyRecovery $societyCalling = null;

  #[ORM\OneToOne(mappedBy: 'pv')]
  private ?SocietyRecovery $societyPv = null;

  #[ORM\OneToOne(mappedBy: 'form')]
  private ?SocietyRecovery $societyForm = null;

  #[ORM\OneToOne(mappedBy: 'expenseReport')]
  private ?SocietyRecovery $societyExpenseReport = null;

  #[ORM\OneToOne(mappedBy: 'proofOfPayment')]
  private ?SocietyRecovery $societyProofOfPayment = null;

  #[ORM\OneToOne(mappedBy: 'docObject')]
  private ?Medical $medical = null;

  #[ORM\OneToOne(mappedBy: 'doc')]
  private ?AgentState $agentState = null;

  #[ORM\OneToOne(mappedBy: 'docObject', cascade: ['persist', 'remove'])]
  private ?VehicleAssignment $agent = null;

  #[ORM\OneToOne(mappedBy: 'docObject')]
  private ?PropertyAssignment $propertyAssignment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoadmap(): ?Mission
    {
        return $this->roadmap;
    }

    public function setRoadmap(?Mission $roadmap): static
    {
        // unset the owning side of the relation if necessary
        if ($roadmap === null && $this->roadmap !== null) {
            $this->roadmap->setRoadmap(null);
        }

        // set the owning side of the relation if necessary
        if ($roadmap !== null && $roadmap->getRoadmap() !== $this) {
            $roadmap->setRoadmap($this);
        }

        $this->roadmap = $roadmap;

        return $this;
    }

    public function getExitPermit(): ?Mission
    {
        return $this->exitPermit;
    }

    public function setExitPermit(?Mission $exitPermit): static
    {
        // unset the owning side of the relation if necessary
        if ($exitPermit === null && $this->exitPermit !== null) {
            $this->exitPermit->setExitPermit(null);
        }

        // set the owning side of the relation if necessary
        if ($exitPermit !== null && $exitPermit->getExitPermit() !== $this) {
            $exitPermit->setExitPermit($this);
        }

        $this->exitPermit = $exitPermit;

        return $this;
    }

    public function getMissionOrder(): ?Mission
    {
        return $this->missionOrder;
    }

    public function setMissionOrder(?Mission $missionOrder): static
    {
        // unset the owning side of the relation if necessary
        if ($missionOrder === null && $this->missionOrder !== null) {
            $this->missionOrder->setMissionOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($missionOrder !== null && $missionOrder->getMissionOrder() !== $this) {
            $missionOrder->setMissionOrder($this);
        }

        $this->missionOrder = $missionOrder;

        return $this;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFolder(?Folder $folder): static
    {
        // unset the owning side of the relation if necessary
        if ($folder === null && $this->folder !== null) {
            $this->folder->setDocObject(null);
        }

        // set the owning side of the relation if necessary
        if ($folder !== null && $folder->getDocObject() !== $this) {
            $folder->setDocObject($this);
        }

        $this->folder = $folder;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        // unset the owning side of the relation if necessary
        if ($vehicle === null && $this->vehicle !== null) {
            $this->vehicle->setCertificate(null);
        }

        // set the owning side of the relation if necessary
        if ($vehicle !== null && $vehicle->getCertificate() !== $this) {
            $vehicle->setCertificate($this);
        }

        $this->vehicle = $vehicle;

        return $this;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): static
    {
        // unset the owning side of the relation if necessary
        if ($society === null && $this->society !== null) {
            $this->society->setRccm(null);
        }

        // set the owning side of the relation if necessary
        if ($society !== null && $society->getRccm() !== $this) {
            $society->setRccm($this);
        }

        $this->society = $society;

        return $this;
    }

    public function getSocietyRecovery(): ?SocietyRecovery
    {
        return $this->societyRecovery;
    }

    public function setSocietyRecovery(?SocietyRecovery $societyRecovery): static
    {
        // unset the owning side of the relation if necessary
        if ($societyRecovery === null && $this->societyRecovery !== null) {
            $this->societyRecovery->setCertificate(null);
        }

        // set the owning side of the relation if necessary
        if ($societyRecovery !== null && $societyRecovery->getCertificate() !== $this) {
            $societyRecovery->setCertificate($this);
        }

        $this->societyRecovery = $societyRecovery;

        return $this;
    }

    public function getSocietyCalling(): ?SocietyRecovery
    {
        return $this->societyCalling;
    }

    public function setSocietyCalling(?SocietyRecovery $societyCalling): static
    {
        // unset the owning side of the relation if necessary
        if ($societyCalling === null && $this->societyCalling !== null) {
            $this->societyCalling->setCallingCard(null);
        }

        // set the owning side of the relation if necessary
        if ($societyCalling !== null && $societyCalling->getCallingCard() !== $this) {
            $societyCalling->setCallingCard($this);
        }

        $this->societyCalling = $societyCalling;

        return $this;
    }

    public function getSocietyPv(): ?SocietyRecovery
    {
        return $this->societyPv;
    }

    public function setSocietyPv(?SocietyRecovery $societyPv): static
    {
        // unset the owning side of the relation if necessary
        if ($societyPv === null && $this->societyPv !== null) {
            $this->societyPv->setPv(null);
        }

        // set the owning side of the relation if necessary
        if ($societyPv !== null && $societyPv->getPv() !== $this) {
            $societyPv->setPv($this);
        }

        $this->societyPv = $societyPv;

        return $this;
    }

    public function getMedical(): ?Medical
    {
        return $this->medical;
    }

    public function setMedical(?Medical $medical): static
    {
        // unset the owning side of the relation if necessary
        if ($medical === null && $this->medical !== null) {
            $this->medical->setDocObject(null);
        }

        // set the owning side of the relation if necessary
        if ($medical !== null && $medical->getDocObject() !== $this) {
            $medical->setDocObject($this);
        }

        $this->medical = $medical;

        return $this;
    }

    public function getAgentState(): ?AgentState
    {
        return $this->agentState;
    }

    public function setAgentState(?AgentState $agentState): static
    {
        // unset the owning side of the relation if necessary
        if ($agentState === null && $this->agentState !== null) {
            $this->agentState->setDoc(null);
        }

        // set the owning side of the relation if necessary
        if ($agentState !== null && $agentState->getDoc() !== $this) {
            $agentState->setDoc($this);
        }

        $this->agentState = $agentState;

        return $this;
    }

    public function getAgent(): ?VehicleAssignment
    {
        return $this->agent;
    }

    public function setAgent(?VehicleAssignment $agent): static
    {
        // unset the owning side of the relation if necessary
        if ($agent === null && $this->agent !== null) {
            $this->agent->setDocObject(null);
        }

        // set the owning side of the relation if necessary
        if ($agent !== null && $agent->getDocObject() !== $this) {
            $agent->setDocObject($this);
        }

        $this->agent = $agent;

        return $this;
    }

    public function getPropertyAssignment(): ?PropertyAssignment
    {
        return $this->propertyAssignment;
    }

    public function setPropertyAssignment(?PropertyAssignment $propertyAssignment): static
    {
        // unset the owning side of the relation if necessary
        if ($propertyAssignment === null && $this->propertyAssignment !== null) {
            $this->propertyAssignment->setDocObject(null);
        }

        // set the owning side of the relation if necessary
        if ($propertyAssignment !== null && $propertyAssignment->getDocObject() !== $this) {
            $propertyAssignment->setDocObject($this);
        }

        $this->propertyAssignment = $propertyAssignment;

        return $this;
    }
}
