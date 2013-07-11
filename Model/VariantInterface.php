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
 * Variant interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface VariantInterface
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
     * @param ProductInterface $product
     * 
     * @return VariantInterface
     */
    public function setProduct(ProductInterface $product = null);    
 
    /**
     * Returns the stock keeping unit.
     *
     * @return string
     */
    public function getSku();    
    
    /**
     * Sets the stock keeping unit.
     *
     * @param string $sku
     * 
     * @return VariantInterface
     */
    public function setSku($sku);    
    
    /**
     * Returns all options.
     *
     * @return \Traversable
     */
    public function getOptions();

    /**
     * Adds an option.
     *
     * @param OptionValueInterface $option
     * 
     * @return VariantInterface
     */
    public function addOption(OptionValueInterface $option);

    /**
     * Removes an option.
     *
     * @param OptionValueInterface $option
     * 
     * @return VariantInterface
     */
    public function removeOption(OptionValueInterface $option);

    /**
     * Checks whether variant has given option.
     *
     * @param OptionValueInterface $option
     *
     * @return Boolean
     */
    public function hasOption(OptionValueInterface $option);    
    
    /**
     * Returns the creation time.
     *
     * @return \Datetime
     */
    public function getCreatedAt(); 
    
    /**
     * Sets the creation time.
     * 
     * @param \Datetime $datetime
     * 
     * @return VariantInterface
     */
    public function setCreatedAt(\Datetime $datetime);     
    
    /**
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt();    
    
    /**
     * Sets the last update time.
     * 
     * @param \Datetime|null $datetime
     * 
     * @return VariantInterface
     */
    public function setUpdatedAt(\Datetime $datetime = null);   
}

