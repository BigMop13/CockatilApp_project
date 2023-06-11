<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\RatingInput;
use App\Entity\Rating;
use App\Persister\RatingPersister;
use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class AddDrinkRating extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer,
                                private readonly CocktailRepository $cocktailRepository,
                                private readonly RatingPersister $persister,
    ){
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $ratingInput = $this->serializer->deserialize($request->getContent(), RatingInput::class, 'json');
            $cocktail = $this->cocktailRepository->find($ratingInput->getCocktailId());
            $user = $this->getUser();
            $rating = (new Rating())
                ->setUser($user)
                ->setCocktail($cocktail)
                ->setStars($ratingInput->getStars());

            $user->addRating($rating);
            $cocktail->addRating($rating);

            $this->persister->persist($rating);

        }catch (\Exception $exception) {
            return new JsonResponse([
                "statusCode" => Response::HTTP_BAD_REQUEST,
                "message" => 'An error occurred'
            ]);
        }

        return new JsonResponse([
            "statusCode" => Response::HTTP_CREATED,
            "message" => "Your rating has been added!"
        ]);
    }
}