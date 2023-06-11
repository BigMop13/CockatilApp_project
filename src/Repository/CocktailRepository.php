<?php

namespace App\Repository;

use App\Entity\Cocktail;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cocktail>
 *
 * @method Cocktail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cocktail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cocktail[]    findAll()
 * @method Cocktail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CocktailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cocktail::class);
    }

    public function findCocktailByString(string $text): array
    {
        return $this->createQueryBuilder('c')
            ->where("c.name LIKE :text")
            ->setParameter('text', $text.'%')
            ->getQuery()
            ->getArrayResult();
    }

    public function findCocktailById(int $id): ?Cocktail
    {
        return $this->createQueryBuilder('c')
            ->addSelect('ca')
            ->leftJoin('c.category', 'ca')
            ->where("c.id = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }
}
