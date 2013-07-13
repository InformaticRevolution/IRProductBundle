Using Variants With IRProductBundle
===================================

## Prerequisites

You need to complete the [option configuration](options.md) before to start this section as variants have direct dependencies on options.

## Installation

1. Create your Variant class
2. Define the Product-Variant relation
3. Configure the variants
4. Import the routing file
5. Update your database schema

### Step 1: Create your Variant class

##### Annotations
``` php
<?php
// src/Acme/ProductBundle/Entity/Variant.php

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

    /**
     * @ORM\ManyToMany(targetEntity="OptionValue")
     * @ORM\JoinTable(name="acme_product_variants_options",
     *      joinColumns={@ORM\JoinColumn(name="variant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_value_id", referencedColumnName="id")}
     * )
     */
    protected $options;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ProductBundle/Entity/Variant.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\Variant as BaseVariant;

/**
 * Variant
 */
class Variant extends BaseVariant
{
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
    manyToMany:
      options:
        targetEntity: OptionValue
        joinTable:
          name: acme_product_variants_options
          joinColumns:
            variant_id:
              referencedColumnName: id
          inverseJoinColumns:
            option_value_id:
              referencedColumnName: id 
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

        <many-to-many field="options" target-entity="OptionValue">
            <join-table name="acme_product_variants_options">
                <join-columns>
                    <join-column name="variant_id" referenced-column-name="id" />
                </join-columns>
                <inverse-join-columns>
                    <join-column name="option_value_id" referenced-column-name="id" />
                </inverse-join-columns>
            </join-table>
        </many-to-many>
    </entity>
    
</doctrine-mapping>
```

### Step 2: Define the Product-Variant relation

##### Annotations

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
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Option")
     * @ORM\JoinTable(name="acme_product_products_options",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_id", referencedColumnName="id")}
     * )
     */
    protected $options;

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
    manyToMany:
        options:
            targetEntity: Option
            joinTable:
                name: acme_product_products_options
                joinColumns:
                    product_id:
                        referencedColumnName: id
                inverseJoinColumns:
                    option_id:
                        referencedColumnName: id
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

        <many-to-many field="options" target-entity="Option">
            <join-table name="acme_product_products_options">
                <join-columns>
                    <join-column name="product_id" referenced-column-name="id" />
                </join-columns>
                <inverse-join-columns>
                    <join-column name="option_id" referenced-column-name="id" />
                </inverse-join-columns>
            </join-table>
        </many-to-many>

        <one-to-many field="variants" target-entity="Variant" mapped-by="product"/>
    </entity>
    
</doctrine-mapping>
```

### Step 3: Configure the variants

Add the following configuration to your `config.yml` file:

**a) Add the variant configuration**

``` yaml
# app/config/config.yml
ir_product:
    db_driver: orm # orm is the only available driver for the moment 
    product_class: Acme\ProductBundle\Entity\Product
    option:
        option_class: Acme\ProductBundle\Entity\Option
        option_value_class: Acme\ProductBundle\Entity\OptionValue
    variant:
        variant_class: Acme\ProductBundle\Entity\Variant
```

**b) Add the ProductInterface path to the RTEL**

``` yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            IR\Bundle\ProductBundle\Model\OptionInterface: Acme\ProductBundle\Entity\Option
            IR\Bundle\ProductBundle\Model\ProductInterface: Acme\ProductBundle\Entity\Product
```    

### Step 4: Import the routing file

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_product_variant:
    resource: "@IRProductBundle/Resources/config/routing/variant.xml"
    prefix: /admin/products/variants

```

### Step 5: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```