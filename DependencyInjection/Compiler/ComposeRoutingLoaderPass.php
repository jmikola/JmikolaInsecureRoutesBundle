<?php

namespace Jmikola\InsecureRoutesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ComposeRoutingLoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        /* Copy the alias or definition of the original event dispatcher that
         * this bundle's event dispatcher will compose, and then assume the
        * "routing.loader" service ID.
        */
        if ($container->hasAlias('routing.loader')) {
            $container->setAlias('jmikola_insecure_routes.routing.loader.inner', new Alias((string) $container->getAlias('routing.loader'), false));
        } else {
            $definition = $container->getDefinition('routing.loader');
            $definition->setPublic(false);
            $container->setDefinition('jmikola_insecure_routes.routing.loader.inner', $definition);
        }

        $container->setAlias('routing.loader', 'jmikola_insecure_routes.routing.loader');
    }
}
