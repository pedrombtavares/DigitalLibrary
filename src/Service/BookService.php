<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService
{
    private $bookRepo;

    public function __construct(
        BookRepository $bookRepository
    )
    {
        $this->bookRepo = $bookRepository;
    }

    public function addBook(Book $book)
    {
        $book->setAuthor(
            ucwords($book->getAuthor())
        );
        $this->bookRepo->add($book);
    }
}