<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CategoryRepository extends ServiceEntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder('c')
             ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}