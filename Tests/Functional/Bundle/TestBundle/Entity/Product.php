<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Functional\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\VariableProduct as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Product extends BaseProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
    
    /**
     * @ORM\OneToMany(targetEntity="ProductOption", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $options; 
    
    /**
     * @ORM\OneToMany(targetEntity="Variant", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     */
    protected $variants;  
}
