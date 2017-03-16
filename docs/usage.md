# Usage
 
First, I advise you to read up on the [Mailer documentation](https://github.com/cleentfaar/mailer), 
which is the library that this bundle implements. 

Now, assuming you have created a mailer type and configured a driver, here's an (overly simplified) example of using the bundle.

> **NOTE:** I recommend you define your [controller as a service](http://symfony.com/doc/current/controller/service.html) 
and pass the mailer service as a constructor argument instead. I choose this example as it may be more familiar to people new to Symfny.

```php
<?php

namespace AppBundle\Controller;

use AppBundle\Mailer\Type\AcmeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AcmeController extends Controller
{    
    // ...
    public function foobarAction()
    {
        $successful = false;
        
        // ...
        
        if ($successful) {
            $this->get('cl_mailer.mailer')->send(AcmeType::class, ['foo' => 'bar']);
        }
        
        // ...
    }
}
```
