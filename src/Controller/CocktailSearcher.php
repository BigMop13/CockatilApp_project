<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CocktailSearcher extends AbstractController
{
    public function __construct(private readonly CocktailRepository $cocktailRepository)
    {
    }

    public function __invoke(string $text): array
    {
        return $this->cocktailRepository->findCocktailByString($text);
    }
}