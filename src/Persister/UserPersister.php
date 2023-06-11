<?php
declare(strict_types=1);

namespace App\Persister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserPersister
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function persist(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}