<?php

namespace Jmikola\InsecureRoutesBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;

class HttpsRemovalLoader implements LoaderInterface
{
    private $loader;

    /**
     * Constructor.
     *
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Loads a RouteCollection but removes HTTPS scheme requirements from its
     * routes before returning the collection.
     *
     * @see Symfony\Component\Config\Loader\LoaderInterface::load()
     */
    public function load($resource, $type = null)
    {
        $collection = $this->loader->load($resource, $type);

        foreach ($collection->all() as $route) {
            if ('https' === $route->getRequirement('_scheme')) {
                $requirements = $route->getRequirements();
                unset($requirements['_scheme']);
                $route->setRequirements($requirements);
            }
        }

        return $collection;
    }

    /**
     * @see Symfony\Component\Config\Loader\LoaderInterface::supports()
     */
    public function supports($resource, $type = null)
    {
        return $this->loader->supports($resource, $type);
    }

    /**
     * @see Symfony\Component\Config\Loader\LoaderInterface::getResolver()
     */
    public function getResolver()
    {
        return $this->loader->getResolver();
    }

    /**
     * @see Symfony\Component\Config\Loader\LoaderInterface::setResolver()
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        $this->loader->setResolver($resolver);
    }
}
