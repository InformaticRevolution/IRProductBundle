Using Options With IRProductBundle
==================================

### Configure the Options

Add the following configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_product:
    db_driver: orm
    product_class: Acme\ProductBundle\Entity\Product
    option:
        option_class: Acme\ProductBundle\Entity\Option
        option_value_class: Acme\ProductBundle\Entity\OptionValue
```

### The OptionValue class

##### Annotations
``` php
// src/Acme/ProductBundle/Entity/OptionValue.php
<?php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\OptionValue as BaseOptionValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="ir_product_option_value")
 */
class OptionValue extends BaseOptionValue
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
// src/Acme/ProductBundle/Entity/OptionValue.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\OptionValue as BaseOptionValue;

/**
 * OptionValue
 */
class OptionValue extends BaseOptionValue
{
}
```

In YAML:

``` yaml
# src/Acme/ProductBundle/Resources/config/doctrine/OptionValue.orm.yml
Acme\ProductBundle\Entity\OptionValue:
    type:  entity
    table: acme_product_option_value
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/ProductBundle/Resources/config/doctrine/OptionValue.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ProductBundle\Entity\OptionValue" table="acme_product_option_value">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### The Option class

**Warning:**

> If you override the __construct() method in your Option class, be sure
> to call parent::__construct(), as the base Option class depends on
> this to initialize some fields.

##### Annotations
``` php
// src/Acme/ProductBundle/Entity/Option.php
<?php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Option as BaseOption;

/**
 * @ORM\Entity
 * @ORM\Table(name="ir_product_option")
 */
class Option extends BaseOption
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;

    /**
     * @ORM\OneToMany(targetEntity="OptionValue", mappedBy="option")
     */
    protected $values;

    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

##### Yaml or Xml

```php
<?php
// src/Acme/ProductBundle/Entity/Option.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\Option as BaseOption;

/**
 * Option
 */
class Option extends BaseOption
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/ProductBundle/Resources/config/doctrine/Option.orm.yml
Acme\ProductBundle\Entity\Option:
    type:  entity
    table: acme_product_option
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    oneToMany:
        values:
            targetEntity: OptionValue
            mappedBy: option
```

In XML:

``` xml
<!-- src/Acme/ProductBundle/Resources/config/doctrine/Option.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ProductBundle\Entity\Option" table="acme_product_option">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
        
        <one-to-many field="values" target-entity="OptionValue" mapped-by="option"/>
    </entity>
    
</doctrine-mapping>
```

### Defining the Product-Option relation

##### Annotations

``` php
// src/Acme/ProductBundle/Entity/Product.php
<?php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="ir_product")
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
     * @ORM\ManyToMany(targetEntity="Option")
     * @ORM\JoinTable(name="ir_product_products_options",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_id", referencedColumnName="id")}
     * )
     */
    protected $options;
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
    table: ir_product
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    manyToMany:
        groups:
            targetEntity: Option
            joinTable:
                name: ir_product_products_options
                joinColumns:
                    product_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    option_id:
                        referencedColumnName: id
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

        <many-to-many field="options" target-entity="Option">
            <join-table name="ir_product_products_options">
                <join-columns>
                    <join-column name="product_id" referenced-column-name="id" />
                </join-columns>
                <inverse-join-columns>
                    <join-column name="option_id" referenced-column-name="id" />
                </inverse-join-columns>
            </join-table>
        </many-to-many>
    </entity>
    
</doctrine-mapping>
```

### Enabling the routing for the OptionController

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_product_option:
    resource: "@IRProductBundle/Resources/config/routing/option.xml"
    prefix: /admin/products/options

```