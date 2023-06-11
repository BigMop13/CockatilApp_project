<?php
declare(strict_types=1);

namespace App\Persister;

use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;

class RatingPersister
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function persist(Rating $rating): void
    {
        $this->entityManager->persist($rating);
        $this->entityManager->flush();
    }
}