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
     * @param VariantInterface $masterVariant
     */
    public function setMasterVariant(VariantInterface $masterVariant);

    /**
     * Returns all the variants.
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