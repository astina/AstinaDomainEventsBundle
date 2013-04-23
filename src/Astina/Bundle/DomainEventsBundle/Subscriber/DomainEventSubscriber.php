<?php

namespace Astina\Bundle\DomainEventsBundle\Subscriber;

class DomainEventSubscriber
{
    private $service;

    private $entity;

    private $events;

    function __construct($service, $entity, array $events)
    {
        $this->service = $service;
        $this->entity = $entity;
        $this->events = $events;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getEvents()
    {
        return $this->events;
    }
}
