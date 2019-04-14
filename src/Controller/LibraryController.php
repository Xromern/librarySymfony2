<?php

namespace App\Controller;


use App\Entity\Book;
use App\Entity\GenreList;
use App\Entity\Genres;
use App\Entity\Writers;
use App\Form\BookType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Request;


class LibraryController extends AbstractController
{
    /**
     * @Route("/", name="books")
     */
    public function viewBooks(){

        $books = $this->getDoctrine()->getRepository(Book::class)->getBooks();


        return $this->render('Layout/layout-show-books.html.twig',
            array('books'=>$books)
        );
    }

    /**
     * @Route("/{id}/show", name="book")
     */
    public function viewBook($id)
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->getBook($id);
        $genre= $this->getDoctrine()->getRepository(Genres::class)->list_genres($id);
        dump($genre);
        return $this->render('Layout/layout-show-book.html.twig',
            array('book'=>$book[0],'genres'=>$genre)
        );
    }

    /**
     * @Route("/{id}/update", name="Update")
     */
    public function viewUpdate(Request $request)
    {

        $id = $request->get('id');
        $bookRepo = $this->getDoctrine()->getRepository(Book::class);
        $book= $bookRepo->find($id);

        $defaultCover = $book->getCover();
        $defaultPDF = $book->getBookPdf();

        $form = $this->createForm(BookType::class,$book,['cover_required'=>false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $select_genre = $form->get('select_genre')->getData();

            $fileCover =$form->get('cover')->getData();

            $filePFD =$form->get('book_pdf')->getData();

            $fileCoverName = $bookRepo->updateFile($fileCover,$this->getParameter('cover_directory'),$defaultCover);

            $book->setCover($fileCoverName);

            $filePDFName = $bookRepo->updateFile($filePFD,$this->getParameter('pdf_directory'),$defaultPDF);

            $book->setBookPdf($filePDFName);

            $entityManager->persist($book);

            $entityManager->flush();

            $this->getDoctrine()->getRepository(GenreList::class)->setGenreList($select_genre,$book);

            return $this->redirect( $this->generateUrl( 'books'));
        }

        return $this->render('Layout/layout-create-book.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="Create")
     */
    public function viewCreate(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $select_genre = $form->get('select_genre')->getData();

            $fileCover =$form->get('cover')->getData();

            $filePdf =$form->get('book_pdf')->getData();

            $bookRepo = $this->getDoctrine()->getRepository(Book::class);

            $filenameCover = $bookRepo->saveFile($this->getParameter('cover_directory'),$fileCover);

            $filenamePDF = $bookRepo->saveFile($this->getParameter('pdf_directory'),$filePdf);

            $entityManager->persist($book);

            $book->setCover($filenameCover);

            $book->setBookPdf($filenamePDF);

            $entityManager->flush();

            $this->getDoctrine()->getRepository(GenreList::class)->setGenreList($select_genre,$book);

            return $this->redirect( $this->generateUrl( 'books'));
        }
        return $this->render('Layout/layout-create-book.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete($id)
    {

        $this->getDoctrine()->getRepository(GenreList::class)->delete($id);

        $bookRepo = $this->getDoctrine()->getRepository(Book::class);

        $book = $bookRepo->getBook($id);

        if($book !=null) {

            $filename = $book[0]['cover'];

            $bookRepo->delete($id);

            $bookRepo->deleteFile($this->getParameter('cover_directory'),$filename);

        }
        return $this->redirect( $this->generateUrl( 'books'));

    }
}
