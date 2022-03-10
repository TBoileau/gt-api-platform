<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function getRandomMovie(): Movie
    {
        return $this->createQueryBuilder('m')
            ->orderBy('RANDOM()')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    public function getMovies(int $page): array
    {
        return $this->createQueryBuilder('m')
            ->addSelect('g')
            ->join('m.genre', 'g')
            ->setMaxResults(20)
            ->setFirstResult(($page - 1) * 20)
            ->getQuery()
            ->getResult();
    }
}
