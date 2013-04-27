<?php

namespace Astina\Bundle\DomainEventsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SubscribersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig('astina_domain_events');

        $this->processEntityListener(
            $container->getDefinition('astina_domain_events.entity_listener'),
            $config
        );

        $this->processMetadataListener(
            $container->getDefinition('astina_domain_events.metadata_listener'),
            $config
        );
    }

    private function processEntityListener(Definition $definition, $config)
    {
        foreach ($config[0]['subscribers'] as $subscriberService => $subscriberConfig) {
            $definition->addMethodCall('addSubscriber', array(
                new Reference($subscriberService),
                $subscriberConfig['entity'],
                $subscriberConfig['events'],
            ));
        }
    }

    private function processMetadataListener(Definition $definition, $config)
    {
        $entityEvents = array();

        foreach ($config[0]['subscribers'] as $subscriberConfig) {
            foreach ($subscriberConfig['events'] as $event) {
                $entityEvents[$subscriberConfig['entity']][] = $event;
            }
        }

        foreach ($entityEvents as &$entityEvent) {
            $entityEvent = array_unique($entityEvent);
        }

        $definition->addMethodCall('setEntityEvents', array($entityEvents));
    }
}
