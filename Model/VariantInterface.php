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
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * Sets the product.
     *
     * @param ProductInterface $product
     */
    public function setProduct(ProductInterface $product = null);    

    /**
     * Checks whether variant is master.
     *
     * @return Boolean
     */
    public function isMaster();

    /**
     * Sets the master status of the variant.
     *
     * @param Boolean $master
     */
    public function setMaster($master);    
    
    /**
     * Returns all options.
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
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt(); 
}

