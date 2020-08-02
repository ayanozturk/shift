<?php

namespace App\EventListener;

use App\Events\UserCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Class SendWelcomeEmail
 */
class SendWelcomeEmail implements EventSubscriberInterface
{

    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            /** @see onUserCreate */
            UserCreatedEvent::class => 'onUserCreate'
        ];
    }

    public function onUserCreate(UserCreatedEvent $event): void
    {
        $user = $event->getUser();

        $email = (new Email())
            ->from('shift@ayanozturk.com')
            ->to($user->email)
            ->subject('Welcome to Shift Manager!')
            ->text('You successfully created an account in Shift Manager!')
            ->html('<p>You successfully created an account in Shift Manager!</p>');

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->critical('Email was not sent: ' . $e->getMessage());
        }
    }
}
