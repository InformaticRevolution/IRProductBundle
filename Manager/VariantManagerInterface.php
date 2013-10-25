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

use IR\Bundle\ProductBundle\Model\VariantInterface;
use IR\Bundle\ProductBundle\Model\ProductInterface;

/**
 * Variant Manager Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface VariantManagerInterface
{   
    /**
     * Creates an empty variant instance.
     *
     * @param ProductInterface|null $product
     * 
     * @return VariantInterface
     */    
    public function createVariant(ProductInterface $product = null);

    /**
     * Finds a variant by the given criteria.
     *
     * @param array $criteria
     *
     * @return VariantInterface|null
     */
    public function findVariantBy(array $criteria);    
    
    /**
     * Finds variants by product.
     * 
     * This method should also loads the options associated to each variant.
     * 
     * @param ProductInterface $product
     * 
     * @return array
     */
    public function findVariantsByProductWithOptions(ProductInterface $product);    
    
    /**
     * Returns the variant's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

