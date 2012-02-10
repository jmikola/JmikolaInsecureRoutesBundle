# JmikolaInsecureRoutesBundle

This bundle removes HTTPS schema requirements from all routes in your Symfony2
application, and is especially helpful if your `dev` or `test` environments are
not configured with SSL and you would like to avoid maintaining a separate copy
of your routing configuration with HTTPS requirements removed.

You probabably should not use this bundle in your `prod` environment.

## Compatibility

This bundle's master branch maintains compatibility with Symfony2's master
branch. Use the **2.0** branch of this bundle if your project uses 2.0.x.

## Installation

### Application Kernel

Add JmikolaInsecureRoutesBundle to the `registerBundles()` method of your
application kernel. Like WebProfilerBundle, this bundle should only be enabled
for your `dev` and `test` environments:

``` php
# app/AppKernel.php

public function registerBundles()
{
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        $bundles[] = new Jmikola\InsecureRoutesBundle\JmikolaInsecureRoutesBundle();
    }
}
```

## Configuration

There are no configuration options. Symfony2 will load the bundle's dependency
injection extension automatically.

The extension will create a service that [composes][] the existing
`routing.loader` service and assumes its service ID. Whenever a RouteCollection
is loaded, any HTTPS `_scheme` requirements among its routes will then be
removed. The filtering process is very similar to that of FrameworkBundle's
DelegatingLoader, which resolves short notation for `_controller` defaults.

  [composes]: http://en.wikipedia.org/wiki/Object_composition
