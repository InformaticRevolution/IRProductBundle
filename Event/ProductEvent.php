<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\ProductBundle\Model\ProductInterface;

/**
 * Product event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductEvent extends Event
{
    /**
     * @var ProductInterface
     */        
    protected $product;
    
    
   /**
    * Constructor.
    *
    * @param ProductInterface $product
    */         
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Returns the product.
     * 
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }
}