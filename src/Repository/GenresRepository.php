<?php

namespace App\Repository;

use App\Entity\Genres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Genres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genres[]    findAll()
 * @method Genres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Genres::class);
    }

    public function list_genres($id){
        $sql = 'SELECT 
                `genres`.`id`    as `genre_id` ,
                `genres`.`title` as `genre_title` , 
                `Book`.`title`   as `Book_title` 
                 FROM `Book` 
                 LEFT JOIN `genre_list` ON `genre_list`.`Book_id` = `Book`.`id`
                 LEFT JOIN `genres`     ON `genres`.`id` = `genre_list`.`genre_id` 
                 WHERE `Book`.`id` = ?';

        $conn = $this->getEntityManager()->getConnection();
        $query = $conn->prepare($sql);
        $query->bindParam(1,$id);
        $query->execute();
        return $query->fetchAll();
    }



    // /**
    //  * @return Genres[] Returns an array of Genres objects
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
    public function findOneBySomeField($value): ?Genres
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
