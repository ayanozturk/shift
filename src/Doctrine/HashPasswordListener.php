<?php

namespace App\Doctrine;

use App\Core\PasswordUpdater;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class HashPasswordListener
 */
class HashPasswordListener implements EventSubscriber
{
    private PasswordUpdater $passwordUpdater;

    public function __construct(PasswordUpdater $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }

    public function getSubscribedEvents(): array
    {
        /** @see prePersist */
        return ['prePersist'];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        if ($entity->plainPassword) {
            $this->passwordUpdater->encodeUserPassword(
                $entity,
                $entity->plainPassword
            );
        }
    }
}
