<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cocktail;
use App\Exception\NoCocktailsFound;
use App\Repository\CocktailRepository;
use App\Repository\RatingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class CocktailDetails extends AbstractController
{
    public function __construct(private readonly CocktailRepository $cocktailRepository,
                                private readonly RatingRepository $ratingRepository
    ){
    }

    /**
     * @throws NoCocktailsFound
     */
    public function __invoke(int $cocktailId): JsonResponse
    {
        try {
            $cocktail = $this->cocktailRepository->findCocktailById($cocktailId);

            if (!$cocktail)
            {
                throw new NoCocktailsFound('No cocktails found');
            }

            $user = $this->getUser();
            $userRating = $this->ratingRepository->findRatingByUserAndCocktail($user, $cocktail);
            $overallRating = $this->ratingRepository->getOverallDrinkRating($cocktail);
            $stars = $userRating?->getStars();

        }
        catch (\Exception $exception)
        {
            return new JsonResponse([
                'statusCode' => 404,
                'message' => $exception->getMessage()
            ]);
        }
        $userFavourites = $user->hasAddedCocktail($cocktail);

        return new JsonResponse([
            'id' => $cocktail->getId(),
            'name' =>$cocktail->getName(),
            'ingredients' => $cocktail->getIngredients(),
            'prepareTime' => $cocktail->getPrepareTime(),
            'difficulty' => $cocktail->getDifficulty(),
            'image' => $cocktail->getImage(),
            'category' => $cocktail->getCategory(),
            'instruction' => $cocktail->getInstruction(),
            'isFavourite' => $userFavourites,
            'userRating' => $stars,
            'overallRating' => $overallRating
        ]);
    }
}