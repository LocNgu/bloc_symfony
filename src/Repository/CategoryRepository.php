<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder('c')
             ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
