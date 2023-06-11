<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\AddDrinkRating;
use App\Controller\EditDrinkRating;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Post(
        uriTemplate: '/rate_drink',
        formats: ['json' => ['application/json']],
        defaults: ['_api_receive'=>false],
        controller: AddDrinkRating::class,
        security: "is_granted('ROLE_USER')"),
    new Put(
        uriTemplate: '/edit_drink_rating',
        formats: ['json' => ['application/json']],
        defaults: ['_api_receive'=>false],
        controller: EditDrinkRating::class,
        security: "is_granted('ROLE_USER')"),
],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['rating:read']],
    denormalizationContext: ['groups' => ['rating:write']],
)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:write', 'cocktail:read', 'cocktail:write', 'rating:read', 'rating:write'])]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'user:write', 'cocktail:read', 'cocktail:write', 'rating:read', 'rating:write'])]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'user:write', 'cocktail:read', 'cocktail:write', 'rating:read', 'rating:write'])]
    private Cocktail $cocktail;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write', 'cocktail:read', 'cocktail:write', 'rating:read', 'rating:write'])]
    private int $stars;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCocktail(): Cocktail
    {
        return $this->cocktail;
    }

    public function setCocktail(Cocktail $cocktail): self
    {
        $this->cocktail = $cocktail;

        return $this;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }
}
