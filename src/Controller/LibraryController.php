<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use App\Form\BookSearchType;
use App\Form\BookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Repository\BookRepository;
use App\Service\BookService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LibraryController extends AbstractController
{
    private $movieService;
    private $movieRepository;
    private $validator;
    private $em;

    public function __construct(
        BookService $bookService,
        BookRepository $bookRepository,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {
        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
        $this->validator = $validator;
        $this->em = $entityManager;
    }
    /**
     * @Route("/library", name="library")
     */
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    /**
     * @Route("/book/add", methods={"POST", "GET"}, name="create_book")
     * @Template()
     */
    public function createBook(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('create_book'),
            'method' => 'POST'
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->bookService->addBook($book);

                return $this->redirectToRoute('library');
            }
        }
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/books", methods={"GET", "POST"}, name="list_books")
     */
    public function listAllBooks(Request $request)
    {
        $book = new Book();

        $books = $this->bookRepository->findAll();

        $form = $this->createForm(BookSearchType::class, $book, [
            'action' => $this->generateUrl('list_books'),
            'method' => 'POST'
        ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $books = $this->bookRepository->findOneByName($form->getData()->getName());
            }

        return $this->render('library/list_books.html.twig', [
            'form' => $form->createView(),
            'books' => $books 
        ]);
    }

    /**
     * @Route("/book/edit/{id}", methods={"GET", "POST"}, name="update_books")
     */
    public function updateBook(Request $request, $id)
    {
        $book = new Book();
        
        $book = $this->bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('update_books', ['id' => $id]),
            'method' => 'POST'
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->bookRepository->update($book);

                return $this->redirectToRoute('list_books');
            }
        }
        return $this->render('library/update_books.html.twig', [
            'form' => $form->createView(),
            'books' => $book ]);

    }

    /**
     * @Route("/book/delete/{id}", methods={"GET", "POST"}, name="delete_book")
     */
    public function deleteBook($id)
    {
        $book = new Book();
        $book = $this->bookRepository->find($id);
        $this->bookRepository->delete($book);

        return $this->redirectToRoute('list_books');
    }
}
