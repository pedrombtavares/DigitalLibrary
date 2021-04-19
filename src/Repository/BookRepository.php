<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneByName($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.name = :name')
            ->setParameter('name', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function add(Book $book): void
    {
        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();
    }

    public function getAllBooks()
    {
        return $this->findAll();
    }
    
}
