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

use IR\Bundle\ProductBundle\Model\VariantInterface;

/**
 * Variant manager interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface VariantManagerInterface
{   
    /**
     * Creates an empty variant instance.
     *
     * @return VariantInterface
     */    
    public function createVariant();

    /**
     * Finds a variant by the given criteria.
     *
     * @param array $criteria
     *
     * @return VariantInterface|null
     */
    public function findVariantBy(array $criteria);    
    
    /**
     * Returns the variant's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

