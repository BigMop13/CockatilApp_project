<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\NoCocktailsFound;
use App\Repository\CocktailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AddFavDrink extends AbstractController
{
    public function __construct(private readonly CocktailRepository $cocktailRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $cocktailId = json_decode($request->getContent())->cocktailId;
        $cocktail = $this->cocktailRepository->find($cocktailId);

        if (!$cocktail)
        {
            throw new NoCocktailsFound('No cocktail found');
        }

        try {
            $user = $this->getUser();
            $user->addCocktail($cocktail);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }catch (\Exception $e)
        {
            Return new JsonResponse([
                "statusCode" => 400,
                "message" => "Error occured"
            ]);
        }

        return new JsonResponse([
            "statusCode" => 200,
            "message" => sprintf("Drink with id %s added to user %s favourites", $cocktailId, $user->getEmail())
        ]);
    }
}