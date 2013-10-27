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

use Doctrine\Common\Collections\Collection;

/**
 * Variant Interface.
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
     * @return VariableProductInterface
     */
    public function getProduct();

    /**
     * Sets the product.
     *
     * @param VariableProductInterface $product
     */
    public function setProduct(VariableProductInterface $product = null);    

    /**
     * Check whether variant is master variant.
     * 
     * @return Boolean
     */
    public function isMasterVariant();
    
    /**
     * Returns all the options.
     *
     * @return Collection
     */
    public function getOptions();

    /**
     * Adds an option.
     *
     * @param OptionValueInterface $option
     */
    public function addOption(OptionValueInterface $option);

    /**
     * Removes an option.
     *
     * @param OptionValueInterface $option
     */
    public function removeOption(OptionValueInterface $option);

    /**
     * Checks whether variant has given option.
     *
     * @param OptionValueInterface $option
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
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt);    
    
    /**
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt();  
    
    /**
     * Sets the last update time.
     * 
     * @param \Datetime|null $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null);
}

