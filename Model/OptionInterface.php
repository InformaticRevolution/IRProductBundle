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
 * Option Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OptionInterface
{   
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();      

    /**
     * Returns the internal name.
     *
     * @return string
     */
    public function getName();    
    
    /**
     * Sets the internal name.
     *
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Returns the public name.
     *
     * @return string
     */
    public function getPublicName();    
    
    /**
     * Sets the public name.
     *
     * @param string $publicName
     */
    public function setPublicName($publicName);    

    /**
     * Returns all the values.
     *
     * @return Collection
     */
    public function getValues(); 
    
    /**
     * Adds a value.
     *
     * @param OptionValueInterface $optionValue
     */
    public function addValue(OptionValueInterface $optionValue);
    
    /**
     * Removes a value.
     *
     * @param OptionValueInterface $optionValue
     */
    public function removeValue(OptionValueInterface $optionValue);
    
    /**
     * Checks whether option has given value.
     *
     * @param OptionValueInterface $optionValue
     *
     * @return Boolean
     */
    public function hasValue(OptionValueInterface $optionValue);
    
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

