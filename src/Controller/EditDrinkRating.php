<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\RatingInput;
use App\Persister\RatingPersister;
use App\Repository\CocktailRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class EditDrinkRating extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer,
                                private readonly CocktailRepository $cocktailRepository,
                                private readonly RatingRepository $ratingRepository,
                                private readonly RatingPersister $persister
    ){
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $ratingInput = $this->serializer->deserialize($request->getContent(), RatingInput::class, 'json');
            $cocktail = $this->cocktailRepository->find($ratingInput->getCocktailId());
            $rating = $this->ratingRepository->findRatingByUserAndCocktail($this->getUser(), $cocktail);
            $rating->setStars($ratingInput->getStars());

            $this->persister->persist($rating);
        }catch (\Exception $exception) {
            return new JsonResponse([
                "statusCode" => Response::HTTP_BAD_REQUEST,
                "message" => 'An error occurred'
            ]);
            }

        return new JsonResponse([
            "statusCode" => Response::HTTP_CREATED,
            "message" => 'Rating edited successfully'
        ]);
    }
}