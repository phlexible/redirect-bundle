PhlexibleRedirectBundle
=======================

The PhlexibleRedirectBundle adds support for redirection in phlexible.

Installation
------------

1. Download PhlexibleRedirectBundle using composer
2. Enable the Bundle
3. Update your database schema
4. Clear the symfony cache

### Step 1: Download PhlexibleRedirectBundle using composer

Add PhlexibleRedirectBundle by running the command:

``` bash
$ php composer.phar require phlexible/ct-bundle "~1.0.0"
```

Composer will install the bundle to your project's `vendor/phlexible` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Phlexible\Bundle\RedirectBundle\PhlexibleRedirectBundle(),
    );
}
```

### Step 3: Update your database schema

Now that the bundle is set up, the last thing you need to do is update your database schema because the redirect bundle includes entities that need to be installed in your database.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 4: Clear the symfony cache

If you access your phlexible application with environment prod, clear the cache:

``` bash
$ php app/console cache:clear --env=prod
```
