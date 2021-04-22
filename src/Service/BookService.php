<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\MessageService;

class BookService
{
    private $bookRepo;
    private $mailer;

    public function __construct(
        BookRepository $bookRepository,
        MessageService $messageService
    )
    {
        $this->bookRepo = $bookRepository;
        $this->mailer = $messageService;
    }

    public function addBook(Book $book)
    {
        $book->setAuthor(
            ucwords($book->getAuthor())
        );
        $book->setIsbn(strtoupper($book->getIsbn()));
        
        $this->bookRepo->add($book);
        $this->mailer->notifyOnNewBook($book);
    }
}