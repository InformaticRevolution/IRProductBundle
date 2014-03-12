Using Options With IRProductBundle
==================================

## Installation

1. Create your classes
2. Define the Product-Option relation
3. Configure the options
4. Import the routing file
5. Update your database schema

### Step 1: Create your classes

**a) Create your OptionValue class**

##### Annotations
``` php
<?php
// src/Acme/ProductBundle/Entity/OptionValue.php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\OptionValue as BaseOptionValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_product_option_value")
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

``` php
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

**b) Create your Option class**

**Warning:**

> If you override the __construct() method in your Option class, be sure
> to call parent::__construct(), as the base Option class depends on
> this to initialize some fields.

##### Annotations
``` php
<?php
// src/Acme/ProductBundle/Entity/Option.php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Option as BaseOption;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_product_option")
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
     * @ORM\OneToMany(targetEntity="OptionValue", mappedBy="option", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
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

``` php
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
            cascade: [ all ]
            orphanRemoval: true
            orderBy: { position: ASC }
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
        
        <one-to-many field="values" target-entity="OptionValue" mapped-by="option" orphan-removal="true">
            <cascade>
                <cascade-all />
            </cascade>       
            <order-by>
                <order-by-field name="position" direction="ASC" />
            </order-by>        
        </one-to-many>
    </entity>
    
</doctrine-mapping>
```

### Step 2: Define the Product-Option relation

**a) Create your ProductOption class**

##### Annotations
``` php
<?php
// src/Acme/ProductBundle/Entity/ProductOption.php

namespace Acme\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\ProductOption as BaseProductOption;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="acme_product_products_options", 
 *     uniqueConstraints={@ORM\UniqueConstraint(name="product_option_idx", columns={"product_id", "option_id"})}
 * )
 */
class ProductOption extends BaseProductOption
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

``` php
<?php
// src/Acme/ProductBundle/Entity/ProductOption.php

namespace Acme\ProductBundle\Entity;

use IR\Bundle\ProductBundle\Model\ProductOption as BaseProductOption;

/**
 * ProductOption
 */
class ProductOption extends BaseProductOption
{
}
```

In YAML:

``` yaml
# src/Acme/ProductBundle/Resources/config/doctrine/ProductOption.orm.yml
Acme\ProductBundle\Entity\ProductOption:
    type:  entity
    table: acme_product_products_options
    uniqueConstraints:
            product_option_idx:
                columns: product_id, option_id
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/ProductBundle/Resources/config/doctrine/ProductOption.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ProductBundle\Entity\ProductOption" table="acme_product_products_options">
        <unique-constraints>
            <unique-constraint columns="product_id,option_id" name="product_option_idx" />
        </unique-constraints>

        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

**b) Update the Product class**

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
     * @ORM\OneToMany(targetEntity="ProductOption", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $options;


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
        options:
            targetEntity: ProductOption
            mappedBy: product
            cascade: [ all ]
            orphanRemoval: true
            orderBy: { position: ASC }
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

        <one-to-many field="options" target-entity="ProductOption" mapped-by="product" orphan-removal="true">
            <cascade>
                <cascade-all />
            </cascade>   
            <order-by>
                <order-by-field name="position" direction="ASC" />
            </order-by>         
        </one-to-many>
    </entity>
    
</doctrine-mapping>
```

### Step 3: Configure the options

Add the following configuration to your `config.yml` file:

**a) Add the option configuration**

``` yaml
# app/config/config.yml
ir_product:
    db_driver: orm # orm is the only available driver for the moment 
    product_class: Acme\ProductBundle\Entity\Product
    option:
        option_class: Acme\ProductBundle\Entity\Option
        option_value_class: Acme\ProductBundle\Entity\OptionValue
        product_option_class: Acme\ProductBundle\Entity\ProductOption
```

**b) Add the ProductInterface and OptionInterface paths to the RTEL**

``` yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            IR\Bundle\ProductBundle\Model\ProductInterface: Acme\ProductBundle\Entity\Product
            IR\Bundle\ProductBundle\Model\OptionInterface: Acme\ProductBundle\Entity\Option
```

**c) Enable the sortable extension in your `config.yml` file**

``` yaml
# app/config/config.yml
stof_doctrine_extensions:
    orm:
        default:
            sortable:true
            sluggable: true
            timestampable: true
```

### Step 4: Import the routing file

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_product_option:
    resource: "@IRProductBundle/Resources/config/routing/admin/option.xml"
    prefix: /admin/products/options

```

### Step 5: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```