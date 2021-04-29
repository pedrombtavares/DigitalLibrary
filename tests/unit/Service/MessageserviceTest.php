<?php

namespace Tests\Unit\Service\BookService;

use App\Entity\Book;
use App\Service\MessageService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class MessageServiceTest extends TestCase
{
     /** @var MailerInterface|MockObject */
     private $mailer;
    
     /** @var string */
     private $sender;
         
     /** @var string */
     private $receiver;

    protected function setUp(): void
    {
        $this->sender = 'f@f.com';
        $this->receiver = 'r@r.com';

        $this->mailer = $this->createMock(MailerInterface::class);
    }

    public function testMessageIsSent()
    {
        $this->mailer->expects($this->once())->method('send');
        $this->getMessageService()->notifyOnNewBook(new Book());

    }

    
    public function testMessageSubject()
    {
        $book = new Book();
        $book->setName('My name');

        $this->mailer->method('send')->with(
            $this->callback(function(TemplatedEmail $mail) use ($book){
                return $mail->getSubject() == 'New book: '.$book->getName();
              })
        );
        $service = $this->getMessageService()->notifyOnNewBook($book);

    }

    private function getMessageService()
    {
        return new MessageService($this->sender, $this->receiver, $this->mailer);
    }
}