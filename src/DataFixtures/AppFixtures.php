<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\GenreList;
use App\Entity\Genres;
use App\Entity\Writers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /*писатели*/
        $writers = [];
        $writer1 = new Writers();
        $writer1->setName('А. С. Пушкин');
        $writer1->setDescription('Это писатель');
        $manager->persist($writer1);
        $writers[] = $writer1;

        $writer2 = new Writers();
        $writer2->setName('Л. Н. Толстой');
        $writer2->setDescription('Это писатель');
        $manager->persist($writer2);
        $writers[] = $writer2;


        $writer3 = new Writers();
        $writer3->setName('М. Горький');
        $writer3->setDescription('Это писатель');
        $manager->persist($writer3);
        $writers[] = $writer3;



        $writer4 = new Writers();
        $writer4->setName('А. П. Чехов');
        $writer4->setDescription('Это писатель');
        $manager->persist($writer4);
        $writers[] = $writer4;



        /*Жанры*/
        $genre1 = new Genres();
        $genre1->setTitle('Фантастика');
        $manager->persist($genre1);
        $Genres[] = $genre1;

        $genre1 = new Genres();
        $genre1->setTitle('Ужасы');
        $manager->persist($genre1);
        $Genres[] = $genre1;

        $genre1 = new Genres();
        $genre1->setTitle('Триллер');
        $manager->persist($genre1);
        $Genres[] = $genre1;

        $genre1 = new Genres();
        $genre1->setTitle('Юмор');
        $manager->persist($genre1);
        $Genres[] = $genre1;


        foreach ($writers as $writer){
            $count_Book = rand(1,12);
            for($i = 0;$i<$count_Book;$i++){
                $Book = new Book();
                $Book->setTitle('Книга'.rand(1,4325235));
                $Book->set_number_pages(rand(5,10000));
                $Book->setCover('image.png');
               // $Book->setPublication((new Date())->getDefaultOption());
                $Book->setDescription('В этой книге собраны тексты, написанные еще 
                в девяностые годы прошлого века для разных интернет-проектов: рубрика Macht Frei 
                в легендарной Газете.ру; книжка-игрушка "Идеальный роман", состоящая из последних
                 абзацев вымышленных книг; просветительская "Азбука современного искусства", призванная
                  рассказать простыми словами об очень сложных явлениях. В этой книге Макс Фрай предстает 
                  перед нами не столько писателем, сколько страстным читателем, человеком, которому нравилось 
                  играть в литературные игры. И вообще играть.');

                $Book->setWriter($writers[rand(0,3)]);
                $manager->persist($Book);
                $count_genre = rand(1,4);
                for($j = 0;$j<$count_genre;$j++){
                    $list_genre = new GenreList();
                    $list_genre->setGenre($Genres[$j]);
                    $list_genre->setBook($Book);
                    $manager->persist($list_genre);
                }
            }
        }

        $manager->flush();
    }
}
