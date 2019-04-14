<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\GenreList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }



    public function getBooks(){
    $sql = 'SELECT
            `book`.`id` as `book_id` ,
            `book`.`title` as `title` ,
            `book`.`cover` as `cover` ,
            `book`.`description` as `description_Book`,
            `book`.`number_pages` as `number_pages`,
            `book`.`date` as `date`,
            `writers`.`name` as `writers_name`
            FROM `book`
            LEFT JOIN `writers` ON `book`.`writer_id` = `writers`.`id` ORDER BY `book`.`id` DESC ';
        $conn = $this->getEntityManager()->getConnection();
        $query = $conn->prepare($sql);

        $query->execute();
     //   $paginator = $this->paginate($query, 1);
        return $query->fetchAll();
    }

    public function getBook($id){
        $sql = 'SELECT
            `book`.`id` as `book_id` ,
            `book`.`title` as `title` ,
            `book`.`cover` as `cover` ,
            `book`.`description` as `description_Book`,
            `book`.`number_pages` as `number_pages`,
            `book`.`book_pdf` as `book_pdf`,
             `book`.`date` as `date`,
            `writers`.`name` as `writers_name`
            FROM `book`
            LEFT JOIN `writers` ON `book`.`writer_id` = `writers`.`id` WHERE `book`.`id`=?';

        $conn = $this->getEntityManager()->getConnection();
        $query = $conn->prepare($sql);
        $query->bindParam(1,$id);
        $query->execute();
        return $query->fetchAll();
    }

    public function delete($id){
      $this->createQueryBuilder('b')
            ->delete(Book::class, 'b')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();

    }

    public function saveFile($directory,$file){
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($directory,$filename);
        return $filename;
    }

    public function deleteFile($directory,$filename){
        $filesystem = new Filesystem();

        $filesystem->remove($directory . '/' . $filename);
    }

    public function updateFile($file,$directory,$defaultFile){

        if($file != null){

            $this->deleteFile($directory,$defaultFile);

            $filename = $this->saveFile($directory,$file);

            return $filename;
        }else{

            return $defaultFile;

        }

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

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
