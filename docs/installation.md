# Installation

The recommended way to install MailerBundle is through [Composer](http://getcomposer.org).

```bash
php composer.phar require cleentfaar/mailer-bundle
```

After installing, register the bundle in your `AppKernel` class:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new CL\Bundle\MailerBundle\CLMailerBundle(),
        // ...
    );
}
```
