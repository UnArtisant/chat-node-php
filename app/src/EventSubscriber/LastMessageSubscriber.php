<?php

namespace App\EventSubscriber;

use App\Entity\Message;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\Events;

class LastMessageSubscriber implements EventSubscriberInterface
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Message) {
            return;
        }

        $conversation = $entity->getConversation();
        $conversation->setLastMessage($entity);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
        ];
    }
}
