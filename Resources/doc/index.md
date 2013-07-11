Getting Started With IRProductBundle
====================================

....

## Prerequisites

This version of the bundle requires Symfony 2.3+.

## Installation

1. Download IRProductBundle using composer
2. Enable the Bundle
3. Create your Product class
4. Configure the IRProductBundle
5. Import IRProductBundle routing
6. Update your database schema

### Step 1: Download IRProductBundle using composer

Add IRProductBundle in your composer.json:

```js
{
    "require": {
        "informaticrevolution/product-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/product-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IR\Bundle\ProductBundle\IRProductBundle(),
    );
}
```

### Step 3: Create your Product class

The bundle provides base classes which are already mapped for most fields
to make it easier to create your entity. Here is how you use it:

1. Extend the base `Product` class
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Warning:**

> If you override the __construct() method in your Product class, be sure
> to call parent::__construct(), as the base Product class depends on
> this to initialize some fields.

**a) Doctrine ORM Product class**

``` php
<?php
// src/Acme/ProductBundle/Entity/Product.php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_product")
 */
class Product extends BaseProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```
### Step 4: Configure the IRProductBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
ir_product:
    db_driver: orm # orm is the only available driver for the moment 
    product_class: Acme\ProductBundle\Entity\Product
```

Only two configuration values are required to use the bundle:

* The type of datastore you are using (`orm`).
* The fully qualified class name (FQCN) of the `Product` class which you created in Step 3.

> When using one of the Doctrine implementation, you need either to use the
> `auto_mapping` option of the corresponding bundle (done by default for
> DoctrineBundle in the standard distribution) or to activate the mapping
> for IRProductBundle otherwise the base mapping will be ignored.

### Step 5: Import IRProductBundle routing files

In YAML:

``` yaml
# app/config/routing.yml
ir_product:
    resource: "@IRProductBundle/Resources/config/routing/product.xml"
    prefix: /admin/products
```

Or if you prefer XML:

``` xml
<!-- app/config/routing.xml -->
<import resource="@IRProductBundle/Resources/config/routing/product.xml" prefix="/admin/products" />
```

### Step 6: Update your database schema

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Next Steps
