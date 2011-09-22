<?php

namespace Jmikola\InsecureRoutesBundle\Tests\Routing\Loader;

use Jmikola\InsecureRoutesBundle\Routing\HttpsRemovalLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class HttpsRemovalLoaderTest extends \PHPUnit_Framework_TestCase
{
    private $loader;
    private $innerLoader;

    public function setUp()
    {
        $this->innerLoader = $this->getMockLoader();
        $this->loader = new HttpsRemovalLoader($this->innerLoader);
    }

    public function testLoadShouldRemoveOnlyHttpsSchemeRequirements()
    {
        $routes = array(
            'foo' => 'https',
            'bar' => 'http',
            'baz' => null,
            'bat' => 'https',
        );

        $collection = new RouteCollection();

        foreach ($routes as $name => $scheme) {
            $route = new Route($name);

            if ($scheme) {
                $route->setRequirement('_scheme', $scheme);
            }

            $collection->add($name, $route);
        }

        $this->innerLoader->expects($this->once())
            ->method('load')
            ->with('resource', 'type')
            ->will($this->returnValue($collection));

        $loadedCollection = $this->loader->load('resource', 'type');

        foreach ($loadedCollection as $name => $route) {
            if ('http' === $routes[$name]) {
                $this->assertEquals('http', $route->getRequirement('_scheme'));
            } else {
                $this->assertNull($route->getRequirement('_scheme'));
            }
        }
    }

    public function testSupportsShouldChain()
    {
        $this->innerLoader->expects($this->once())
            ->method('supports')
            ->with('resource', 'type')
            ->will($this->returnValue(true));

        $this->assertTrue($this->loader->supports('resource', 'type'));
    }

    public function testGetResolverShouldChain()
    {
        $resolver = $this->getMockLoaderResolver();

        $this->innerLoader->expects($this->once())
            ->method('getResolver')
            ->will($this->returnValue($resolver));

        $this->assertSame($resolver, $this->loader->getResolver());
    }

    public function testSetResolverShouldChain()
    {
        $resolver = $this->getMockLoaderResolver();

        $this->innerLoader->expects($this->once())
            ->method('setResolver')
            ->with($resolver);

        $this->loader->setResolver($resolver);
    }

    private function getMockLoader()
    {
        return $this->getMock('Symfony\Component\Config\Loader\LoaderInterface');
    }

    private function getMockLoaderResolver()
    {
        return $this->getMockBuilder('Symfony\Component\Config\Loader\LoaderResolver')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
