<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Actions\NewsActions\CreateNewsAction;
use App\Repository\NewsRepository;
use App\Traits\IsDeletedTrait;
use App\Traits\ReleasedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ApiResource(
  types: ['https://schema.org/News'],
  operations: [
    new Get(),
    new Patch(),
    new GetCollection(),
    new Post(
      inputFormats: ['multipart' => ['multipart/form-data']],
      controller: CreateNewsAction::class
    ),
  ],
  normalizationContext: ['groups' => 'news:read'],
  order: ['releasedAt' => 'desc'],
  forceEager: false
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'ipartial'])]
class News
{
  use ReleasedAtTrait, IsDeletedTrait;
  
  #[Assert\NotBlank(message: 'Pictures are required')]
  #[Assert\NotNull(message: 'Pictures are required')]
  public ?array $pictures = [];
  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
      'news:read',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(['none', 'urgent', 'very_urgent', 'normal'], message: 'Priorité invalide.')]
    #[Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Ce champ doit faire au moins {{ limit }} caractères.',
      maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.'
    )]
    #[Groups([
      'news:read',
    ])]
    private ?string $priority = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'news:read',
    ])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Ce champ ne peut dépasser {{ limit }} caractères.')]
    #[Groups([
      'news:read',
    ])]
    private ?string $subTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'news:read',
    ])]
    private ?string $content = null;

    #[ORM\ManyToMany(targetEntity: ImageObject::class, inversedBy: 'news', cascade: ['persist', 'remove'])]
    #[Groups([
      'news:read',
    ])]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[Groups([
      'news:read',
    ])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
      'news:read',
    ])]
    private ?bool $isTreated = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
      'news:read',
    ])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(['none', 'c1', 'c2', 'c3'], message: 'Classification invalide.')]
    #[Groups([
      'news:read',
    ])]
    private ?string $sort = 'c2';

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, ImageObject>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageObject $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(ImageObject $image): static
    {
        $this->images->removeElement($image);

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

    public function isIsTreated(): ?bool
    {
        return $this->isTreated;
    }

    public function setIsTreated(?bool $isTreated): static
    {
        $this->isTreated = $isTreated;

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

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
