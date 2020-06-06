<?php

namespace App\EventListener;

use App\Events\UserCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Class SendWelcomeEmail
 */
class SendWelcomeEmail implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
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

        $this->mailer->send($email);
    }
}
