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
 * Option interface.
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
     * 
     * @return OptionInterface
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
     * 
     * @return OptionInterface
     */
    public function setPublicName($publicName);    

    /**
     * Returns all values.
     *
     * @return \Traversable
     */
    public function getValues(); 
    
    /**
     * Adds a value.
     *
     * @param OptionValueInterface $optionValue
     * 
     * @return OptionInterface
     */
    public function addValue(OptionValueInterface $optionValue);
    
    /**
     * Removes a value.
     *
     * @param OptionValueInterface $optionValue
     * 
     * @return OptionInterface
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

