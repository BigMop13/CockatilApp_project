<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RatingInput
{
    public function __construct(private readonly int $cocktailId, private readonly int $stars)
    {
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public function getCocktailId(): int
    {
        return $this->cocktailId;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(1)
     * @Assert\GreaterThanOrEqual(1)
     * @Assert\LessThanOrEqual(5)
     */
    public function getStars(): int
    {
        return $this->stars;
    }


}