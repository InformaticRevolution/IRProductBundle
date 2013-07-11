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
 * Variable product interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface VariableProductInterface extends ProductInterface
{
    /**
     * Returns the master variant.
     *
     * @return VariantInterface
     */
    public function getMasterVariant();

    /**
     * Sets the master variant.
     *
     * @param VariantInterface $variant
     * 
     * @return VariableProductInterface
     */
    public function setMasterVariant(VariantInterface $variant);

    /**
     * Returns all variants.
     *
     * @return \Traversable
     */
    public function getVariants(); 
    
    /**
     * Adds a variant.
     *
     * @param VariantInterface $variant
     * 
     * @return VariableProductInterface
     */
    public function addVariant(VariantInterface $variant);
    
    /**
     * Removes a variant.
     *
     * @param VariantInterface $variant
     * 
     * @return VariableProductInterface
     */
    public function removeVariant(VariantInterface $variant);    
    
    /**
     * Checks whether product has given variant.
     *
     * @param VariantInterface $variant
     *
     * @return Boolean
     */
    public function hasVariant(VariantInterface $variant);     

    /**
     * Checks whether product has one ore more options.
     *
     * @return Boolean
     */
    public function hasOptions();      
    
    /**
     * Returns all options.
     *
     * @return \Traversable
     */
    public function getOptions();
    
    /**
     * Adds an option.
     *
     * @param OptionInterface $option
     * 
     * @return VariableProductInterface
     */
    public function addOption(OptionInterface $option); 
    
    /**
     * Removes an option.
     *
     * @param OptionInterface $option
     * 
     * @return VariableProductInterface
     */
    public function removeOption(OptionInterface $option);
    
    /**
     * Checks whether product has given option.
     *
     * @param OptionInterface $option
     *
     * @return Boolean
     */
    public function hasOption(OptionInterface $option);  
}