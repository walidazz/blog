<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * @return Query
     */
    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('a')

            ->orderBy('a.createdAt', 'DESC')
            // ->setMaxResults(10)
            ->getQuery();
    }

    public function search($mots): Query
    {
        return $this->createQueryBuilder('a')
            ->where('MATCH_AGAINST(a.titre,a.content) AGAINST(:mots boolean)>0')
            ->setParameter('mots', $mots)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function findAllByCategory($value): Query
    {
        return $this->createQueryBuilder('a')

            ->orderBy('a.createdAt', 'DESC')
            ->join('a.category', 'c')
            // ->select('a as article, c.libelle')
            ->andWhere('c.libelle = :val')
            ->setParameter('val', $value)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();
    }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
