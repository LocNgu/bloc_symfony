<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
// * @method Post[]    findAll()
 * @method Post[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('p')
            ->select('p, a, c')
            ->innerJoin('p.author', 'a')
            ->innerJoin('p.category', 'c')
            ->orderBy('p.publicationDate', 'desc')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByTag($tagId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere(':val MEMBER OF p.tags')
            ->setParameter('val', $tagId)
            ->orderBy('p.publicationDate', 'desc')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByCategory($categoryId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.category = :val')
            ->setParameter('val', $categoryId)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllPublic()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.public = true')
            ->getQuery()
            ->getResult()
            ;
    }
}
