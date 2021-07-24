<?php

namespace App\Repository;

use App\Entity\Casting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Casting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casting[]    findAll()
 * @method Casting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CastingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casting::class);
    }

    // /**
    //  * @return Casting[] Returns an array of Casting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Casting
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Casting[]
     */
    public function findAllByMovieJoinedToPersonDQL($movie): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT c, p
            FROM App\Entity\Casting c
            INNER JOIN c.person p
            WHERE c.movie = :movie
            ORDER BY c.credit_order ASC"

        )->setParameter('movie', $movie);

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * @return Casting[]
     */
    public function findAllByMovieJoinedToPersonQB($movie): ?array
    {
        return $this->createQueryBuilder('c')
        ->addSelect('p')
        ->innerJoin('c.person', 'p')
        ->where('c.movie = :movie')
        ->orderBy('c.credit_order', 'ASC')
        ->setParameter('movie', $movie)
        ->getQuery()
        ->getResult();
    }

    /**
     * @return Casting[]
     */
    public function findAllJoinedToPersonToMovieOrderByIdQB(): ?array
    {
        return $this->createQueryBuilder('c')
        ->addSelect('p', 'm')
        ->innerJoin('c.person', 'p')
        ->innerJoin('c.movie', 'm')
        ->orderBy('c.id', 'ASC')
        ->getQuery()
        ->getResult();
    }

}
