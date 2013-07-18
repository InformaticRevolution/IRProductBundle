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
 * Product manager interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ProductManagerInterface
{   
    /**
     * Creates an empty product instance.
     *
     * @return ProductInterface
     */    
    public function createProduct();
    
    /**
     * Updates a product.
     *
     * @param ProductInterface $product
     * 
     * @return void
     */
    public function updateProduct(ProductInterface $product);    
         
    /**
     * Deletes a product.
     *
     * @param ProductInterface $product
     * 
     * @return void
     */
    public function deleteProduct(ProductInterface $product);    

    /**
     * Finds a product by the given criteria.
     *
     * @param array $criteria
     *
     * @return ProductInterface|null
     */
    public function findProductBy(array $criteria);    
    
    /**
     * Returns a collection with all product instances.
     *
     * @return \Traversable
     */
    public function findProducts();    
    
    /**
     * Returns the product's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

