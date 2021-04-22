<?php

namespace App\Service;

use App\Entity\Book;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MessageService
{
    /** @var MailerInterface */
    private $mailer;
    
    /** @var string */
    private $sender;
        
    /** @var string */
    private $receiver;

    public function __construct(
        string $sender,
        string $receiver,
        MailerInterface $mailer
    )
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    public function notifyOnNewBook(Book $book): void 
    {
       $email = $this->createEmail($book);
       $this->mailer->send($email);
    }

    private function createEmail(Book $book): TemplatedEmail
    {
        return (new TemplatedEmail())
        ->from($this->sender)
        ->to($this->receiver)
        ->subject('New book: '.$book->getName())
        ->htmlTemplate('emails/new_book.html.twig')
        ->context([
            'book' => $book
        ]);
    }
}