<?php

namespace Astina\Bundle\DomainEventsBundle;

use Astina\Bundle\DomainEventsBundle\DependencyInjection\Compiler\SubscribersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AstinaDomainEventsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SubscribersPass());
    }

}
