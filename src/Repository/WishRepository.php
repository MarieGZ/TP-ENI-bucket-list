<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Array_;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function findWishes(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('w');
        $queryBuilder->join('w.category', 'c');
        $queryBuilder->addSelect('c');
        $queryBuilder->orderBy('w.dateCreated', 'DESC');
        $query=$queryBuilder->getQuery();
        $wishes=$query->getResult();
        return $wishes;
    }
}
