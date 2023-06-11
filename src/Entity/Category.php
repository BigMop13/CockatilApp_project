<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(operations: [
    new GetCollection(normalizationContext: ['groups' => ['category_collection:read']], security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Post(security: "is_granted('ROLE_USER')"),
],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']],
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'category:write', 'category_cocktail:read', 'cocktail:write', 'category_collection:read'])]
    #[ApiProperty(identifier: true)]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'category:write', 'category_cocktail:read', 'cocktail:write', 'category_collection:read'])]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['category:read', 'category:write', 'category_cocktail:read', 'cocktail:write', 'category_collection:read'])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Cocktail::class, orphanRemoval: true)]
    #[Groups(['category:read', 'category_cocktail:read'])]
    private Collection $cocktail;

    public function __construct()
    {
        $this->cocktail = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Cocktail>
     */
    public function getCocktail(): Collection
    {
        return $this->cocktail;
    }
}
