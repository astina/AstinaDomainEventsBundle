<?php

namespace Astina\Bundle\DomainEventsBundle\Doctrine;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * Adds the required entity listeners to all entity classes that have
 * subscribers configured.
 */
class MetadataListener
{
    /**
     * @var array(entity => array(events))
     */
    private $entityEvents = array();

    public function setEntityEvents($entityEvents)
    {
        $this->entityEvents = $entityEvents;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var $classMetadata ClassMetadataInfo */
        $classMetadata = $eventArgs->getClassMetadata();

        if (!$this->hasDomainEvents($classMetadata->getName())) {
            return;
        }

        foreach ($this->entityEvents[$classMetadata->getName()] as $event) {
            $classMetadata->addEntityListener(
                $event,
                'Astina\Bundle\DomainEventsBundle\Doctrine\EntityListener',
                $event
            );
        }
    }

    private function hasDomainEvents($name)
    {
        return array_key_exists($name, $this->entityEvents);
    }
}
