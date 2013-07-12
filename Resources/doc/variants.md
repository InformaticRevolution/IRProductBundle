Using Variants With IRProductBundle
===================================

### Configure the Variants

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_product:
    db_driver: orm
    product_class: Acme\ProductBundle\Entity\Product
    variant:
        variant_class: Acme\ProductBundle\Entity\Variant
```

### The Variant class

##### Annotations
``` php
// src/Acme/ProductBundle/Entity/Variant.php
<?php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Variant as BaseVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_product_variant")
 */
class Variant extends BaseVariant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
}
```

##### Yaml or Xml

```php
<?php
// src/Acme/ProductBundle/Entity/Variant.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\Variant as BaseVariant;

/**
 * Variant
 */
class Variant extends BaseVariant
{
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/ProductBundle/Resources/config/doctrine/Variant.orm.yml
Acme\ProductBundle\Entity\Variant:
    type:  entity
    table: acme_product_variant
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/ProductBundle/Resources/config/doctrine/Variant.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ProductBundle\Entity\Variant" table="acme_product_variant">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### Defining the Product-Variant relation

##### Annotations

``` php
// src/Acme/ProductBundle/Entity/Product.php
<?php

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
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Variant", mappedBy="product")
     */
    protected $variants;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ProductBundle/Entity/Product.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\Product as BaseProduct;

/**
 * Product
 */
class Product extends BaseProduct
{
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/ProductBundle/Resources/config/doctrine/Product.orm.yml
Acme\ProductBundle\Entity\Product:
    type:  entity
    table: acme_product
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    oneToMany:
        variants:
            targetEntity: Variant
            mappedBy: product
```

In XML:

``` xml
<!-- src/Acme/ProductBundle/Resources/config/doctrine/Product.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ProductBundle\Model\Product" table="acme_product">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id>

        <one-to-many field="variants" target-entity="Variant" mapped-by="product" />
    </entity>
    
</doctrine-mapping>
```

### Enabling the routing for the VariantController

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_product_variant:
    resource: "@IRProductBundle/Resources/config/routing/variant.xml"
    prefix: /admin/products/variants

```