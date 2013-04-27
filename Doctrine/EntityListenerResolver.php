<?php

namespace Astina\Bundle\DomainEventsBundle\Doctrine;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;

class EntityListenerResolver extends DefaultEntityListenerResolver
{
    /**
     * @var EntityListener
     */
    private $entityListener;

    function __construct(EntityListener $entityListener)
    {
        $this->entityListener = $entityListener;
    }

    public function resolve($className)
    {
        if ($className == 'Astina\Bundle\DomainEventsBundle\Doctrine\EntityListener') {
            return $this->entityListener;
        }

        return parent::resolve($className);
    }
}
