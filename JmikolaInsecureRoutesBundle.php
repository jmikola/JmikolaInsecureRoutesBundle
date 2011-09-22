<?php

namespace Jmikola\InsecureRoutesBundle;

use Jmikola\InsecureRoutesBundle\DependencyInjection\Compiler\ComposeRoutingLoaderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JmikolaInsecureRoutesBundle extends Bundle
{
    /**
     * @see Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ComposeRoutingLoaderPass());
    }
}
