<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Manager;

use IR\Bundle\ProductBundle\Model\ProductInterface;

/**
 * Abstract Variant Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class VariantManager implements VariantManagerInterface
{
    /**
     * {@inheritdoc}
     */  
    public function createVariant(ProductInterface $product = null)
    {
        $class = $this->getClass();
        $variant = new $class();
        $variant->setProduct($product);
        
        return $variant;
    } 
}
