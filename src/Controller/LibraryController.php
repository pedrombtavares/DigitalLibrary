<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
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
     * @Route("/book", methods={"POST", "GET"}, name="create_book")
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
     * @Route("/books", methods={"GET"}, name="list_books")
     */
    public function listAllBooks()
    {

        return $this->render('library/list_books.html.twig', [
            'books' =>  $this->bookRepository->findAll()
        ]);
    }
}
