# JmikolaInsecureRoutesBundle

This bundle removes HTTPS schema requirements from all routes in your Symfony2
application, and is especially helpful if your *dev* or *test* environments are
not configured with SSL and you would like to avoid maintaining a separate copy
of your routing configuration with HTTPS requirements removed.

You probabably should not use this bundle in your *prod* environment.

## Documentation

This bundle's documentation lives in [Resources/doc/index.md][].

  [Resources/doc/index.md]: https://github.com/jmikola/JmikolaInsecureRoutesBundle/blob/master/Resources/doc/index.md
