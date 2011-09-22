<?php

namespace Jmikola\InsecureRoutesBundle\Tests;

use Jmikola\InsecureRoutesBundle\JmikolaInsecureRoutesBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JmikolaInsecureRoutesBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldAddCompilerPass()
    {
        $bundle = new JmikolaInsecureRoutesBundle();
        $container = new ContainerBuilder();

        $bundle->build($container);

        $passes = $container->getCompilerPassConfig()->getBeforeOptimizationPasses();
        $this->assertInstanceOf('Jmikola\InsecureRoutesBundle\DependencyInjection\Compiler\ComposeRoutingLoaderPass', $passes[0]);
    }
}
