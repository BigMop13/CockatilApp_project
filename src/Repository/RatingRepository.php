<?php

namespace App\Repository;

use App\Entity\Cocktail;
use App\Entity\Rating;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rating>
 *
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function findRatingByUserAndCocktail(User $user, Cocktail $cocktail): ?Rating
    {
        return $this->createQueryBuilder('r')
            ->where('r.user =:user')
            ->andWhere('r.cocktail =:cocktail')
            ->setParameters([
                'user' => $user,
                'cocktail' => $cocktail
            ])
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }

    public function getOverallDrinkRating(Cocktail $cocktail): ?int
    {
        return $this->createQueryBuilder('r')
            ->addSelect()
            ->select('AVG(r.stars) as overallRating')
            ->leftJoin('r.cocktail', 'c')
            ->where('r.cocktail =:cocktail')
            ->setParameter('cocktail', $cocktail)
            ->groupBy('c.id')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
