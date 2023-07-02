<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{

    /**
     * @Route("/", name="app_book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
//        $link = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'));
//
//        if(!mysqli_select_db($link,'test')){
//            mysqli_query($link,'CREATE DATABASE test');
//            mysqli_select_db($link,'test');
//            mysqli_query($link,'CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, count_books INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//            mysqli_query($link,'CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, image LONGBLOB NOT NULL, year_public INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//            mysqli_query($link,'INSERT INTO author(name,count_books) VALUES (\'Иванов Иван Петрович\', 0)');
//            mysqli_query($link,'INSERT INTO author(name,count_books) VALUES (\'Иванов Ивана Петровна\', 0)');
//            mysqli_query($link,'INSERT INTO author(name,count_books) VALUES (\'Иванович Иван Петровичввв\', 0)');
//            mysqli_query($link,'INSERT INTO book(name,description,image,year_public) VALUES (\'Золушка\',\'Из мультфильма\',\'\', 1996)');
//            mysqli_query($link,'INSERT INTO book(name,description,image,year_public) VALUES (\'Трое из Лас-Вегаса\',\'Из мультфильма\',\'\', 1997)');
//            mysqli_query($link,'INSERT INTO book(name,description,image,year_public) VALUES (\'Побез из замка\',\'Из мультфильма\',\'\', 2022)');
//            mysqli_query($link,'CREATE TABLE author_books (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_5C930A5F16A2B381 (book_id), INDEX IDX_5C930A5FF675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//            mysqli_query($link,'ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE ON UPDATE CASCADE ');
//            mysqli_query($link,'ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5FF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE ON UPDATE CASCADE ');
//        }
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $book->setImage(file_get_contents($file));
            $bookRepository->add($book);
            foreach ($book->getAuthorBooks() as $authorBook){
                $bookRepository->setCountBooksOfAuthor($authorBook);
            }
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $book->setImage(file_get_contents($file));
            $bookRepository->add($book);
            foreach ($book->getAuthorBooks() as $authorBook){
                $bookRepository->setCountBooksOfAuthor($authorBook);
            }
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
