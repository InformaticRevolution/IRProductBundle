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
 * Variable Product Interface.
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
     */
    public function setMasterVariant(VariantInterface $variant);

    /**
     * Checks whether product has one ore more variants.
     * 
     * This method is not for checking if product is simple or customizable.
     * It should determine if any variants (other than internal master) exist.
     *
     * @return Boolean
     */
    //public function hasVariants();    
    
    /**
     * Returns all variants.
     *
     * @return Collection
     */
    public function getVariants(); 
    
    /**
     * Adds a variant.
     *
     * @param VariantInterface $variant
     */
    public function addVariant(VariantInterface $variant);
    
    /**
     * Removes a variant.
     *
     * @param VariantInterface $variant
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
}