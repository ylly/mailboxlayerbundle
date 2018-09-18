Installation
============

Step 1 : Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ylly/mailboxlayerbundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2 : Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Ylly\Bundle\MailboxLayer\YllyMailboxLayerBundle(),
        );
    }
}
```

Step 3 : Generate access_key
-------------------------

You need to generate a key on mailboxLayer and add it to the config.yml

See https://mailboxlayer.com/product

Then, add it to the `app/config/config.yml` file of your project :

```yaml
ylly_mailbox_layer:
  access_key: generated access key from mailboxLayer 
```

For a maximal configuration (and in cases you are using your own proxy or the monolog bundle), there is some 
config parameters you can modify. 

By default, the level of the message displayed is 200 (a.k.a. INFO) and the channel is app. 
For more information, see : https://symfony.com/doc/current/logging.html

```yaml
ylly_mailbox_layer:
  access_key: generated access key from mailboxLayer 
  proxy: null
  monolog_level: 200
  monolog_channel: app
```

Step 4 : Use
-------------------------

To allow email verifications, the ylly/mailboxLayerBundle use a very simple assertion (or constraint) 
who can be applied to any email's attributes.

```php
<?php

namespace App\Bundle\YourBundle\YourEntity;

use Ylly\Bundle\MailboxLayer\Validator\Constraints as MailboxLayerAssert;

class User
{
    /**
    * @var string
    * @MailboxLayerAssert\MailboxLayer
    */
    private $email;
}
 ```

Step 5 : Optionals
-------------------------

There is a few options you can tweak to perform your email verifications :
 
- CheckMx verify if there is MX-records for the email address.
  
- CheckSmtp verify if the smtp request was handled by the server.

- CatchAll checks if the requested email address is found to be part of a catch-all mailbox.
Warning ! the catchAll option can only be used by mailboxlayer's professional accounts. Default false.
   
- RefuseDisposable check that the email address is not precarious. 
set true if you don't want disposable address. Default false.

- RefuseUnderScore check The quality score of the email address. 
Allow float between 0 and 1 if you don't want the email's scores to be lower of your chosen limit. Default 0.

- SkipIfServerErrors. When true, this option permits email to pass the verifications
when API mailboxLayer is down or when there's a problem of user's right. Default true.

```php
<?php
 
 namespace App\Bundle\YourBundle\YourEntity;
 
 use Ylly\Bundle\MailboxLayer\Validator\Constraints as MailboxLayerAssert;
 
 class User
 {
     /**
     * @var string
     * 
     * @MailboxLayerAssert\MailboxLayer(
     * checkMx = true, 
     * checkSmtp = true, 
     * isCatchAll = false,
     * refuseDisposable = false,
     * refuseUnderScore = 0,
     * skipIfServerErrors = true
     * )
     */
     private $email;
 }
```

Step 6 : Logger
-------------------------

If using Symfony/Monolog-Bundle, the ylly/mailboxlayerbundle provides a way to log email in case 
the verification's is accepted despite server errors (see Step 5: Optionals : SkipIfServerErrors).

If you are using another logger interface, you can implement your own Logger class & add the Logger service 
using the tag 'ylly.logger' in the services_logger.yml file.

For your information
-------------------------

For more information on the Ylly/mailboxMailer library which is implemented by ylly/mailboxlayerbundle :

See https://github.com/ylly/mailboxlayer