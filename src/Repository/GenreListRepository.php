<?php

namespace App\Repository;


use App\Entity\GenreList;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GenreList|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenreList|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenreList[]    findAll()
 * @method GenreList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenreList::class);
    }

    public function setGenreList($genreList, $Book){
        $entityManager = $this->getEntityManager();
        foreach ($genreList as $item){

            $genre = new GenreList();

            $genre->setBook($Book);

            $genre->setGenre($item);

            $entityManager->persist($genre);
        }
        $entityManager->flush();
    }

    public function getGenre($id){
        $genre = $this->createQueryBuilder('g')
            ->where('g.book = :id')
            ->select('g.id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
        return $genre;

    }

    public function delete($id){
        $this->createQueryBuilder('g')
     ->delete(GenreList::class, 'g')
     ->where('g.book = :id')
     ->setParameter('id', $id)
     ->getQuery()
     ->execute();
    }
    // /**
    //  * @return GenreList[] Returns an array of GenreList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GenreList
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
