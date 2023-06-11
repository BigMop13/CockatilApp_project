<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserFavDrinks extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(): JsonResponse
    {
        return $this->json($this->getUser()->getCocktails());
    }
}