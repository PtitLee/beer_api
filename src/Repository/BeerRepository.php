<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beer>
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function beerByStyle(): array
    {
        $qb = $this->createQueryBuilder('b')
            ->select('s.name, count(s.name) as quantity')
            ->innerJoin('b.style', 's')
            ->groupBy('s.name')
            ->orderBy('quantity', 'desc')
        ;

        return $qb->getQuery()->execute();
    }
}
