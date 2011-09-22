<?php

namespace Jmikola\InsecureRoutesBundle\Tests\DependencyInjection\Compiler;

use Jmikola\InsecureRoutesBundle\DependencyInjection\Compiler\ComposeRoutingLoaderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ComposeRoutingLoaderPassTest extends \PHPUnit_Framework_TestCase
{
    private $container;
    private $pass;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->pass = new ComposeRoutingLoaderPass();
    }

    public function testShouldComposeAlias()
    {
        $this->container->setDefinition('routing.loader.real', new Definition());
        $this->container->setAlias('routing.loader', 'routing.loader.real');

        $this->pass->process($this->container);

        $this->assertServiceHasAlias('routing.loader.real', 'jmikola_insecure_routes.routing.loader.inner');
        $this->assertFalse($this->container->getAlias('jmikola_insecure_routes.routing.loader.inner')->isPublic());
        $this->assertServiceHasAlias('jmikola_insecure_routes.routing.loader', 'routing.loader');
    }

    public function testShouldComposeDefinition()
    {
        $this->container->setDefinition('routing.loader', $originalDefinition = new Definition());

        $this->pass->process($this->container);

        $newDefinition = $this->container->getDefinition('jmikola_insecure_routes.routing.loader.inner');
        $this->assertFalse($newDefinition->isPublic());
        $this->assertSame($originalDefinition, $newDefinition);

        $this->assertServiceHasAlias('jmikola_insecure_routes.routing.loader', 'routing.loader');
    }

    private function assertServiceHasAlias($serviceId, $aliasId)
    {
        $this->assertEquals($serviceId, (string) $this->container->getAlias($aliasId), sprintf('Service "%s" has alias "%s"', $serviceId, $aliasId));
    }
}
