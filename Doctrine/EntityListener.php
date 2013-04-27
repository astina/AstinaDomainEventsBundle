<?php

namespace Astina\Bundle\DomainEventsBundle\Doctrine;

use Astina\Bundle\DomainEventsBundle\Subscriber\DomainEventSubscriber;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Passes events on to the appropriate subscribers
 */
class EntityListener
{
    private $subscribers = array();

    public function addSubscriber($service, $entityClass, $events)
    {
        $subscriber = new DomainEventSubscriber($service, $entityClass, $events);
        $this->subscribers[$entityClass][] = $subscriber;
    }

    /**
     * @param string $event
     * @param object $entity
     * @param \Doctrine\Common\EventArgs $eventArgs
     */
    private function handleEvent($event, $entity, EventArgs $eventArgs)
    {
        $entityClass = get_class($entity);
        if (!isset($this->subscribers[$entityClass])) {
            return;
        }

        /** @var $subscriber DomainEventSubscriber */
        foreach ($this->subscribers[$entityClass] as $subscriber) {
            $service = $subscriber->getService();
            if (in_array($event, $subscriber->getEvents())) {
                call_user_func_array(array($service, $event), array($entity, $eventArgs));
            }
        }
    }

    public function prePersist($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('prePersist', $entity, $eventArgs);
    }

    public function postPersist($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('postPersist', $entity, $eventArgs);
    }

    public function preUpdate($entity, PreUpdateEventArgs $eventArgs)
    {
        $this->handleEvent('preUpdate', $entity, $eventArgs);
    }

    public function postUpdate($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('postUpdate', $entity, $eventArgs);
    }

    public function postRemove($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('postRemove', $entity, $eventArgs);
    }

    public function preRemove($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('preRemove', $entity, $eventArgs);
    }

    public function preFlush($entity, PreFlushEventArgs $eventArgs)
    {
        $this->handleEvent('preFlush', $entity, $eventArgs);
    }

    public function postLoad($entity, LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent('postLoad', $entity, $eventArgs);
    }
}
