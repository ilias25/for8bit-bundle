For8BitBundle
================

This symfony3 bundle allows you to get JSON-encoded locations data stored in predefined format.

Transport layer is provided by third-party bundle [guzzlehttp/guzzle](https://github.com/guzzle/guzzle).

You can find more
information about Buzz on its dedicated page at
https://github.com/ilias25/for8bit-bundle.

## Installation

Installing the bundle via packagist is the quickest and simplest method of installing the bundle. Here are the steps:

### Step 1: Composer require

    $ php composer.phar require "ilias25/for8bit-bundle":"dev-master"

### Step 2: Enable the bundle in the kernel

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Ilias25\For8BitBundle\For8BitBundle(),
            // ...
        );
    }

### Step 3: Add routing (for default controller)
    ilias25-for8bit:
        resource: '@For8BitBundle/Resources/config/routing.yml'
        prefix:   /for8bit
        
That's it! You are ready to use For8BitBundle by path <your_http_root>/for8bit with symfony3!
