<?php

namespace Jmikola\InsecureRoutesBundle\Tests\DependencyInjection;

use Jmikola\InsecureRoutesBundle\DependencyInjection\JmikolaInsecureRoutesExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JmikolaInsecureRoutesExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldLoadServiceDefinition()
    {
        $container = new ContainerBuilder();
        $loader = new JmikolaInsecureRoutesExtension();

        $loader->load(array(array()), $container);

        $this->assertTrue($container->hasDefinition('jmikola_insecure_routes.routing.loader'));
    }
}