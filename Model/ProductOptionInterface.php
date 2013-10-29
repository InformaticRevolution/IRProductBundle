<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Model;

/**
 * Product to option relation interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ProductOptionInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();
    
    /**
     * Returns the product.
     * 
     * @return ProductInterface
     */
    public function getProduct();
    
    /**
     * Sets the product.
     *
     * @param ProductInterface|null $product
     */
    public function setProduct(ProductInterface $product = null);
    
    /**
     * Returns the option.
     *
     * @return OptionInterface
     */
    public function getOption();
    
    /**
     * Sets the option.
     *
     * @param OptionInterface $option
     */
    public function setOption(OptionInterface $option);
    
    /**
     * Returns the position.
     * 
     * @return integer
     */
    public function getPosition();
    
    /**
     * Sets the position.
     * 
     * @param integer $position
     */
    public function setPosition($position);
    
    /**
     * Proxy method to access the option internal name.
     *
     * @return string
     */
    public function getName();

    /**
     * Proxy method to access the option public name.
     *
     * @return string
     */
    public function getPublicName();
    
    /**
     * Proxy method to access the option values.
     *
     * @return string
     */
    public function getValues();    
}
